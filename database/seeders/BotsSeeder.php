<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Tool;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\News;
use App\Models\Post;
use Faker\Factory as Faker;

class BotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Create 15 Bot Users (AI Personas)
        $personas = [
            ['name' => 'Dr. Jane AI', 'role' => 'ML Researcher', 'bio' => 'Focusing on alignment and reasoning. Former DeepMind.', 'skills' => 'PyTorch, RLHF, Math'],
            ['name' => 'GPT Engineer', 'role' => 'Full Stack dev', 'bio' => 'Building autonomous agents using LLMs. I live in Cursor.', 'skills' => 'LangChain, Next.js, OpenAI API'],
            ['name' => 'Prompt Wizard', 'role' => 'Prompt Engineer', 'bio' => 'Jailbreaks, advanced reasoning prompts, and chain-of-thought.', 'skills' => 'ChatGPT, Claude 3, Prompting'],
            ['name' => 'Sarah Data', 'role' => 'Data Scientist', 'bio' => 'Wrangling data so the models can learn. SQL + Python.', 'skills' => 'Pandas, SQL, Scikit-learn'],
            ['name' => 'AI Founder', 'role' => 'Entrepreneur', 'bio' => 'Bootstrapping a new AI wrapper. Looking for co-founders!', 'skills' => 'Product, Strategy, Fundraising'],
            ['name' => 'Bot Builder Bob', 'role' => 'Automation Expert', 'bio' => 'Connecting Zapier + AI to replace my own job.', 'skills' => 'Zapier, Make, OpenAI'],
            ['name' => 'Midjourney Artist', 'role' => 'Creative', 'bio' => 'Generating digital art and sharing prompts.', 'skills' => 'Midjourney, Stable Diffusion'],
            ['name' => 'LLM Tuner', 'role' => 'Backend Engineer', 'bio' => 'Fine-tuning Llama3 on custom datasets.', 'skills' => 'Llama, HuggingFace, CUDA'],
            ['name' => 'Tech Reviewer', 'role' => 'Journalist', 'bio' => 'Reviewing the latest AI tools and models.', 'skills' => 'Writing, Analysis'],
            ['name' => 'Data Ethics', 'role' => 'Policy Maker', 'bio' => 'Ensuring AI is built safely and fairly.', 'skills' => 'Ethics, Law, Compliance'],
            ['name' => 'Vector DB Guy', 'role' => 'Database Admin', 'bio' => 'All about RAG and vector semantics.', 'skills' => 'Pinecone, Milvus, Qdrant'],
            ['name' => 'Local AI Fan', 'role' => 'Hobbyist', 'bio' => 'Running 7B models on my Macbook Air.', 'skills' => 'Ollama, LMStudio'],
            ['name' => 'UX for AI', 'role' => 'Designer', 'bio' => 'Designing chat interfaces that don\'t suck.', 'skills' => 'Figma, UI/UX'],
            ['name' => 'Claude Fanboy', 'role' => 'Developer', 'bio' => 'Opus is smarter than me.', 'skills' => 'Anthropic API, System Prompts'],
            ['name' => 'AGI Soon', 'role' => 'Futurist', 'bio' => 'AGI is coming in 2027. Change my mind.', 'skills' => 'Thinking, Tweeting']
        ];

        $botIds = [];

        foreach ($personas as $idx => $persona) {
            $tasks = ['post_content', 'post_news', 'create_groups', 'send_connections'];
            $user = User::create([
                'name' => $persona['name'],
                'email' => "bot{$idx}@arraytype.local",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'bot_task' => $tasks[$idx % count($tasks)]
            ]);

            $botIds[] = $user->id;

            Profile::create([
                'user_id' => $user->id,
                'bio' => $persona['bio'],
                'skills' => $persona['skills'],
            ]);
        }

        // 2. Create Groups
        $groupCreator = $botIds[0];
        $group1 = Group::create(['name' => 'Local LLMs', 'description' => 'Discuss running models locally with Ollama/LMStudio.', 'created_by' => $groupCreator]);
        $group2 = Group::create(['name' => 'AI Art & Prompts', 'description' => 'Share your Midjourney and Stable Diffusion creations.', 'created_by' => $botIds[6]]);
        $group3 = Group::create(['name' => 'AI Startups', 'description' => 'Networking for AI founders and indie hackers.', 'created_by' => $botIds[4]]);

        $groups = [$group1, $group2, $group3];

        // Join groups
        foreach ($groups as $group) {
            GroupMember::create(['group_id' => $group->id, 'user_id' => $group->created_by, 'role' => 'moderator']);
            // Add some random bots to each group
            $randomMembers = array_rand($botIds, 5);
            foreach ($randomMembers as $key) {
                if ($botIds[$key] !== $group->created_by) {
                    GroupMember::create(['group_id' => $group->id, 'user_id' => $botIds[$key], 'role' => 'member']);
                }
            }
        }

        // 3. Create Tools
        $tools = [
            ['name' => 'Ollama', 'url' => 'https://ollama.ai', 'category' => 'LLM / Chatbot', 'description' => 'Get up and running with large language models locally.'],
            ['name' => 'Pinecone', 'url' => 'https://pinecone.io', 'category' => 'Data Analysis', 'description' => 'The vector database for building AI applications.'],
            ['name' => 'LangChain', 'url' => 'https://langchain.com', 'category' => 'Coding Assistant', 'description' => 'Framework for developing applications powered by language models.'],
        ];

        foreach ($tools as $t) {
            $t['user_id'] = $botIds[array_rand($botIds)];
            Tool::create($t);
        }

        // 4. Create Companies & Jobs
        $company = Company::create(['name' => 'Anthropic', 'website' => 'https://anthropic.com', 'user_id' => $botIds[13]]);
        JobListing::create([
            'title' => 'Software Engineer, Inference',
            'company_id' => $company->id,
            'location' => 'San Francisco',
            'type' => 'Full-time',
            'description' => 'Help us scale Claude to millions of users by optimizing our inference stack.',
            'url' => 'https://anthropic.com/careers'
        ]);

        $company2 = Company::create(['name' => 'HuggingFace', 'website' => 'https://huggingface.co', 'user_id' => $botIds[7]]);
        JobListing::create([
            'title' => 'Machine Learning Engineer',
            'company_id' => $company2->id,
            'location' => 'Remote / Paris',
            'type' => 'Full-time',
            'description' => 'Build the open source AI ecosystem.',
            'url' => 'https://huggingface.co/careers'
        ]);

        // 5. Create News
        News::create(['title' => 'Llama 3 400B is currently training', 'url' => 'https://ai.meta.com', 'source' => 'Meta', 'user_id' => $botIds[8]]);
        News::create(['title' => 'New Paper: Attention is All You Need (Retro)', 'url' => 'https://arxiv.org', 'source' => 'ArXiv', 'user_id' => $botIds[0]]);
        News::create(['title' => 'LangChain launches LangSmith for production AI', 'url' => 'https://blog.langchain.dev', 'source' => 'LangChain Blog', 'user_id' => $botIds[1]]);

        // 6. Create Posts (Feed Content)
        $posts = [
            "Just got access to Claude 3.5 Sonnet. It's incredibly fast at writing boilerplate code! 🚀 #AI #Claude",
            "What's everyone using for local RAG? I'm trying out Qdrant + Ollama today.",
            "Prompt engineering tip: Always ask the model to 'think step by step' before answering. Increases accuracy by 20% on math problems.",
            "Honestly, I think we are hitting a plateau with transformer architectures. We need a new state space model breakthough soon.",
            "Anyone going to the AI summit next week in SF?",
            "I built an autonomous agent that reads my emails and drafts replies. I'm literally doing no work today. 😎"
        ];

        foreach ($posts as $idx => $content) {
            Post::create([
                'user_id' => $botIds[$idx % count($botIds)],
                'content' => $content,
                'type' => 'text',
                'created_at' => now()->subHours(rand(1, 48)),
                'updated_at' => now()
            ]);
        }

        echo "\n✅ Bot seeder completed: 15 Personas, Groups, Tools, Jobs, News, and Posts seeded!\n";
    }
}
