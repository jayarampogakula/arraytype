<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BotSetting;

class GenerateBotActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bots:generate-activity';

    protected $description = 'Generates random post, news, group, or connection activity from bot users.';

    public function handle()
    {
        $status = BotSetting::get('bot_status', 'enabled');
        if ($status !== 'enabled') {
            $this->info('Bot activity is currently disabled in settings.');
            return;
        }

        $bots = \App\Models\User::where('email', 'like', '%@arraytype.local')->get();
        if ($bots->isEmpty()) {
            $this->error('No bots found. Please run the BotSeeder or create one in admin.');
            return;
        }

        // Automatically accept any pending connection requests sent to bots
        $botIds = $bots->pluck('id')->toArray();
        $pendingBotRequests = \App\Models\Connection::whereIn('connected_user_id', $botIds)
            ->where('status', 'pending')
            ->get();

        if (!$pendingBotRequests->isEmpty()) {
            foreach ($pendingBotRequests as $req) {
                $req->update(['status' => 'accepted']);
                $this->info("Automatically accepted pending connection request from User ID {$req->user_id} to Bot ID {$req->connected_user_id}.");
            }
        }

        $bot = $bots->random();
        $task = $bot->bot_task ?? 'post_content';

        $this->info("Executing task '{$task}' for bot: {$bot->name}");

        switch ($task) {
            case 'post_news':
                $this->generateNewsActivity($bot);
                break;
            case 'create_groups':
                $this->generateGroupActivity($bot);
                break;
            case 'send_connections':
                $this->generateConnectionActivity($bot);
                break;
            case 'list_products':
                $this->generateProductActivity($bot);
                break;
            case 'post_content':
            default:
                $this->generateContentActivity($bot);
                break;
        }
    }

    protected function generateContentActivity($bot)
    {
        $allowedTypesJSON = BotSetting::get('allowed_types', '["text"]');
        $allowedTypes = json_decode($allowedTypesJSON, true) ?: ['text'];

        if (empty($allowedTypes)) {
            $this->info('No activity types are allowed right now.');
            return;
        }

        $type = $allowedTypes[array_rand($allowedTypes)];

        $activities = [
            'text' => [
                "Just read a fascinating paper on sparse matrix optimization for LLMs. The memory efficiency gains are wild!",
                "Any recommendations for open-source alternatives to Midjourney? Looking for something that handles text better.",
                "Finally got my local Llama 3 instance to output consistent JSON. Temperature 0.2 seems to be the sweet spot.",
                "DeepMind's latest update on Gemini 1.5 Pro is incredible. That context window changes everything for RAG.",
                "Is it just me, or is prompt engineering becoming more about system architecture than just 'talking' to the model?",
                "Developing an agentic workflow using LangGraph today. The state management is a bit of a learning curve but powerful.",
                "Just tested Groq's Llama 3 70B... the inference speed is absolutely mind-blowing. 300+ tokens/sec!",
                "Working on a custom GPT for analyzing medical datasets. The cross-referencing capabilities are saving me days of work.",
                "What's the consensus on Mojo vs. Python for AI infra? Is it worth the switch yet?",
                "The evolution of small language models (SLMs) like Phi-3 is exactly what we need for edge computing."
            ],
            'ask' => [
                "What is everyone's current favorite local model for coding? I'm torn between DeepSeek 33B and StarCoder2.",
                "Has anyone completely replaced standard search with Claude or ChatGPT for technical documentation?",
                "How do you handle prompt injection in production apps? Any recommended middleware or guardrails?",
                "Does anyone have experience fine-tuning Mistral 7B on domain-specific medical data? Looking for dataset tips.",
                "What's your go-to vector database for production? Weighing Chroma vs. Pinecone for a new project.",
                "How are we feeling about the 'Dead Internet Theory' in the age of generative AI? Is the feed still human?",
                "What's the best way to handle long-term memory in LLM agents without hitting context limits?",
                "Looking for a really good tutorial on building RAG from scratch with Ollama. Any links?",
            ],
            'poll' => [
                ['content' => 'Which framework do you prefer for building AI apps?', 'options' => ['LangChain', 'LlamaIndex', 'Custom/Raw', 'DSPy']],
                ['content' => 'What is the most promising use-case for AI in 2026?', 'options' => ['Auto-Coder Agents', 'Personal Assistants', 'Healthcare', 'Robotics']],
                ['content' => 'Will AGI be achieved by 2030?', 'options' => ['Yes, definitely', 'Likely', 'Unlikely', 'Never']],
                ['content' => 'How much of your daily code is AI-generated?', 'options' => ['0-25%', '25-50%', '50-75%', '75-100%']]
            ]
        ];

        if (!isset($activities[$type])) {
            $type = 'text';
        }

        if ($type === 'poll') {
            $pollActivity = $activities['poll'][array_rand($activities['poll'])];
            \App\Models\Post::create([
                'user_id' => $bot->id,
                'content' => $pollActivity['content'],
                'type' => 'poll',
                'poll_options' => json_encode($pollActivity['options'])
            ]);
            $this->info("Generated a new poll by {$bot->name}!");
            return;
        }

        \App\Models\Post::create([
            'user_id' => $bot->id,
            'content' => $activities[$type][array_rand($activities[$type])],
            'type' => $type
        ]);

        $this->info("Generated a new activity post by {$bot->name}!");
    }

    protected function generateNewsActivity($bot)
    {
        $posted = false;

        try {
            $tags = ['ai', 'machinelearning', 'openai', 'llm'];
            $tag = $tags[array_rand($tags)];
            $response = \Illuminate\Support\Facades\Http::timeout(6)->get('https://dev.to/api/articles', [
                'tag' => $tag,
                'per_page' => 15,
                'top' => 7
            ]);

            if ($response->successful()) {
                $articles = $response->json();
                if (is_array($articles) && !empty($articles)) {
                    shuffle($articles);
                    foreach ($articles as $article) {
                        if (empty($article['title']) || empty($article['url'])) {
                            continue;
                        }

                        // Check if already posted
                        $exists = \App\Models\News::where('title', $article['title'])
                            ->orWhere('source_url', $article['url'])
                            ->exists();

                        if (!$exists) {
                            $title = trim($article['title']);
                            $summary = trim($article['description'] ?? 'A real-time update on artificial intelligence and developer tools.');
                            $url = $article['url'];
                            
                            // Fetch full article for real content details
                            $content = 'Detailed insights are available on the source platform.';
                            try {
                                $fullResponse = \Illuminate\Support\Facades\Http::timeout(3)->get('https://dev.to/api/articles/' . $article['id']);
                                if ($fullResponse->successful()) {
                                    $fullData = $fullResponse->json();
                                    if (!empty($fullData['body_markdown'])) {
                                        $content = trim($fullData['body_markdown']);
                                    }
                                }
                            } catch (\Exception $ex) {
                                $content = $summary;
                            }

                            \App\Models\News::create([
                                'user_id' => $bot->id,
                                'title' => mb_substr($title, 0, 255),
                                'source_url' => $url,
                                'summary' => mb_substr($summary, 0, 1000),
                                'content' => $content,
                                'category' => 'Technology',
                                'status' => 'approved',
                                'views_count' => rand(10, 150),
                                'is_hot' => (rand(1, 10) > 8),
                            ]);

                            $this->info("Bot {$bot->name} fetched & posted real-time news: '{$title}'");
                            $posted = true;
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->warn('Real-time news API fetch failed: ' . $e->getMessage() . '. Falling back to local headlines.');
        }

        if (!$posted) {
            $headlines = [
                "Vibe-Coding is the Next Big Wave in Software Development",
                "Vite 7 Launches with 5x Performance Improvement in Hot Reloading",
                "OpenAI Announces GPT-5 Search Features Available Globally",
                "Anthropic Releases Claude 4 Opus with Advanced Logic Engine",
                "Meta Open Sources Llama 4 400B Model with Multilingual Support",
                "Apple's On-Device Intelligence Framework Outperforms Cloud Competitors",
                "NVIDIA Announces Next-Generation Blackwell Ultra AI Chips",
                "Google DeepMind's AlphaFold 3 Maps Cellular Interactions",
                "Mistral AI Launches Pixtral 12B Multimodal Model",
                "Microsoft Introduces Copilot Agents to Automate Business Processes"
            ];

            $headline = $headlines[array_rand($headlines)];

            // Check if already posted
            if (!\App\Models\News::where('title', $headline)->exists()) {
                \App\Models\News::create([
                    'user_id' => $bot->id,
                    'title' => $headline,
                    'summary' => 'This is a breaking update on the latest developments in artificial intelligence, deep learning, and vector search systems.',
                    'content' => 'In a major announcement today, industry leaders unveiled new capabilities that promise to change how developer workflows and LLM agentic pipelines are designed. The technology is rolling out to enterprise users and the developer community over the coming weeks.',
                    'source_url' => 'https://news.ycombinator.com',
                    'status' => 'approved',
                    'category' => 'Industry',
                    'views_count' => rand(5, 50),
                    'is_hot' => (rand(1, 10) > 8),
                ]);
            }

            $this->info("Bot {$bot->name} posted a fallback news article: '{$headline}'");
        }
    }

    protected function generateGroupActivity($bot)
    {
        $groups = [
            "ArrayType Developers",
            "Prompt Engineering Masters",
            "Local LLM Enthusiasts",
            "Vibe Coders Hub",
            "AI Ethics & Alignment",
            "Vector DBs & RAG",
            "Stable Diffusion Art",
            "Next-Gen AI Agents",
            "Blackwell GPU Miners",
            "Claude & Anthropic API"
        ];

        $groupName = $groups[array_rand($groups)];

        // Avoid duplicate group names
        if (\App\Models\Group::where('name', $groupName)->exists()) {
            $groupName .= " " . rand(2, 99);
        }

        $group = \App\Models\Group::create([
            'name' => $groupName,
            'description' => 'A community group for discussing ' . $groupName . ' topics, sharing code, and networking.',
            'created_by' => $bot->id,
            'slug' => \Illuminate\Support\Str::slug($groupName),
            'is_private' => false
        ]);

        \App\Models\GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $bot->id,
            'role' => 'moderator'
        ]);

        $this->info("Bot {$bot->name} created a new group: '{$groupName}'");
    }

    protected function generateConnectionActivity($bot)
    {
        // Find a user/bot who is not currently connected to this bot
        $connectedUserIds = \App\Models\Connection::where('user_id', $bot->id)->pluck('connected_user_id')
            ->concat(\App\Models\Connection::where('connected_user_id', $bot->id)->pluck('user_id'))
            ->push($bot->id)
            ->unique()
            ->toArray();

        $candidate = \App\Models\User::whereNotIn('id', $connectedUserIds)->inRandomOrder()->first();

        if (!$candidate) {
            $this->info("Bot {$bot->name} already connected to everyone.");
            return;
        }

        // If the candidate is also a bot, auto-accept connection. Otherwise pending.
        $status = str_ends_with($candidate->email, '@arraytype.local') ? 'accepted' : 'pending';

        \App\Models\Connection::create([
            'user_id' => $bot->id,
            'connected_user_id' => $candidate->id,
            'status' => $status
        ]);

        $this->info("Bot {$bot->name} sent connection request to {$candidate->name} (Status: {$status})");
    }

    protected function generateProductActivity($bot)
    {
        $productsList = [
            [
                'name' => 'ChatGPT',
                'tagline' => 'Your conversational AI assistant by OpenAI',
                'description' => 'A state-of-the-art conversational AI system by OpenAI designed for answering questions, drafting content, explaining concepts, and writing software code.',
                'website_url' => 'https://chatgpt.com',
                'category_slug' => 'agents',
                'logo' => 'https://images.unsplash.com/photo-1678269137974-b58602b9e6fa?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Claude',
                'tagline' => 'Helpful, harmless, and honest AI assistant by Anthropic',
                'description' => 'Anthropic\'s advanced AI chatbot that excels at deep reasoning, coding assistance, mathematical logic, and processing large volumes of textual documentation.',
                'website_url' => 'https://claude.ai',
                'category_slug' => 'agents',
                'logo' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Gemini',
                'tagline' => 'Next-generation multimodal AI by Google',
                'description' => 'Google\'s conversational assistant integrated with Google Search. It excels at drawing insights across text, code, images, audio, and video formats.',
                'website_url' => 'https://gemini.google.com',
                'category_slug' => 'agents',
                'logo' => 'https://images.unsplash.com/photo-1707343843437-caacff5cfa74?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Cursor',
                'tagline' => 'The AI-first code editor for rapid development',
                'description' => 'An AI-powered fork of VS Code built to help developers write and edit code faster with built-in chat, inline generation, codebase indexing, and multi-file editing.',
                'website_url' => 'https://cursor.com',
                'category_slug' => 'coding',
                'logo' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'v0 by Vercel',
                'tagline' => 'Generative UI system for frontend developers',
                'description' => 'An AI companion by Vercel that turns natural language descriptions into ready-to-use React, Tailwind CSS, and HTML component code in real-time.',
                'website_url' => 'https://v0.dev',
                'category_slug' => 'coding',
                'logo' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'ElevenLabs',
                'tagline' => 'State-of-the-art text-to-speech and voice cloning AI',
                'description' => 'A leading generative audio platform designed for generating ultra-realistic voiceovers, synthetic sound effects, and lifelike multi-language text-to-speech.',
                'website_url' => 'https://elevenlabs.io',
                'category_slug' => 'content',
                'logo' => 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Midjourney',
                'tagline' => 'High-quality generative text-to-image art creator',
                'description' => 'An independent research lab focusing on creative expression, providing an AI image generator capable of creating stunning artistic and photorealistic graphics from prompts.',
                'website_url' => 'https://midjourney.com',
                'category_slug' => 'content',
                'logo' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Stable Diffusion',
                'tagline' => 'Open source text-to-image generator',
                'description' => 'Stability AI\'s open-source generative model that produces high-resolution images, artworks, and digital assets from natural language descriptions.',
                'website_url' => 'https://stability.ai',
                'category_slug' => 'content',
                'logo' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Perplexity AI',
                'tagline' => 'Conversational search engine with direct source citations',
                'description' => 'An AI-powered search tool that delivers direct, natural language answers to queries, backed by real-time web indexing and verifiable source links.',
                'website_url' => 'https://perplexity.ai',
                'category_slug' => 'research',
                'logo' => 'https://images.unsplash.com/photo-1546074177-3df148018967?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'DeepSeek V3',
                'tagline' => 'Advanced open-source reasoning and language model',
                'description' => 'An extremely capable open-source language model developed by DeepSeek, offering state-of-the-art programming, math, logic, and reasoning capabilities.',
                'website_url' => 'https://deepseek.com',
                'category_slug' => 'models',
                'logo' => 'https://images.unsplash.com/photo-1614741118887-7a4ee193a5fa?q=80&w=200&auto=format&fit=crop'
            ],
            [
                'name' => 'Make.com',
                'tagline' => 'Visual workflow automation platform',
                'description' => 'A powerful system to design, build, and automate complex workflows. Connect apps, tools, and custom AI agents together visually without writing code.',
                'website_url' => 'https://make.com',
                'category_slug' => 'automation',
                'logo' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=200&auto=format&fit=crop'
            ]
        ];

        // Filter out products that have already been listed to avoid duplicate spamming
        $existingNames = \App\Models\Product::pluck('name')->map(fn($n) => strtolower(trim($n)))->toArray();
        $availableProducts = array_filter($productsList, function($p) use ($existingNames) {
            return !in_array(strtolower(trim($p['name'])), $existingNames);
        });

        // If all curated products are already listed, reset list to post again
        if (empty($availableProducts)) {
            $availableProducts = $productsList;
        }

        $productData = $availableProducts[array_rand($availableProducts)];

        // Find Category
        $category = \App\Models\ProductCategory::where('slug', $productData['category_slug'])->first();

        // If category is not seeded yet, fall back to first category
        $categoryId = $category ? $category->id : 1;

        \App\Models\Product::create([
            'user_id' => $bot->id,
            'category_id' => $categoryId,
            'name' => $productData['name'],
            'logo' => $productData['logo'],
            'tagline' => $productData['tagline'],
            'description' => $productData['description'],
            'website_url' => $productData['website_url'],
            'status' => 'approved',
            'launch_date' => now()->toDateString(),
        ]);

        $this->info("Bot {$bot->name} listed a new AI product: '{$productData['name']}' under category ID {$categoryId}!");
    }
}
