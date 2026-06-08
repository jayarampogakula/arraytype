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

    protected $description = 'Generates random post and like activity from bot users.';

    public function handle()
    {
        $status = BotSetting::get('bot_status', 'enabled');
        if ($status !== 'enabled') {
            $this->info('Bot activity is currently disabled in settings.');
            return;
        }

        $bots = \App\Models\User::where('email', 'like', '%@aians.local')->get();
        if ($bots->isEmpty()) {
            $this->error('No bots found. Please run the BotSeeder first.');
            return;
        }

        $bot = $bots->random();

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

        // Make sure we have activities for the specific type
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
}
