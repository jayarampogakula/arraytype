<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $botNames = ['Sarah', 'David', 'Elena', 'Michael', 'Aisha', 'Chen', 'Sophia', 'James', 'Zara', 'Oliver', 'Mia', 'Liam', 'Chloe', 'Noah', 'Emma'];
        $professions = ['Prompt Engineer', 'LLM Researcher', 'AI Ethics Consultant', 'Machine Learning Engineer', 'Data Scientist', 'AI Product Manager', 'Full Stack AI Developer', 'NLP Specialist'];

        $bots = [];
        foreach ($botNames as $index => $name) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => strtolower($name) . '@aians.local'],
                [
                    'name' => $name . ' (' . $professions[array_rand($professions)] . ')',
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );
            $bots[] = $user;

            \App\Models\Profile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => "I build and research artificial intelligence systems. Passionate about the future of AGI and open-source models.",
                    'skills' => json_encode(['Python', 'PyTorch', 'LangChain', 'OpenAI API', 'HuggingFace']),
                ]
            );
        }

        // Create Groups
        $groups = [
            ['name' => 'Local LLMs', 'slug' => 'local-llms', 'description' => 'Discussing Llama 3, Mistral, and running AI locally.'],
            ['name' => 'Prompt Engineering', 'slug' => 'prompt-engineering', 'description' => 'Tips and tricks for getting the best outputs from structured prompts.'],
            ['name' => 'AI Startups', 'slug' => 'ai-startups', 'description' => 'Founders and builders in the AI space networking and sharing resources.']
        ];

        $groupModels = [];
        foreach ($groups as $g) {
            $creator = $bots[array_rand($bots)];
            $groupModels[] = \App\Models\Group::firstOrCreate(
                ['slug' => $g['slug']],
                [
                    'name' => $g['name'],
                    'description' => $g['description'],
                    'created_by' => $creator->id,
                    'is_private' => false
                ]
            );
        }

        // Create Posts
        $postContents = [
            ['content' => "Just managed to get Llama 3 8B running purely on my M2 Mac with Ollama. The inference speed is incredible! Have you guys tried local fine-tuning yet?", 'type' => 'text'],
            ['content' => "What's everyone's go-to vector database for RAG applications these days? Pinecone, Weaviate, or Qdrant?", 'type' => 'ask'],
            ['content' => "Which closed-source model do you think will reach AGI first?", 'type' => 'poll', 'poll_options' => json_encode(['GPT-5', 'Claude 4', 'Gemini 2 Ultra', 'Other'])],
            ['content' => "The new update to LangChain completely broke my existing agents. Guess I'm rewriting the execution logic tonight. Anyone else facing this? 😅", 'type' => 'text'],
            ['content' => "I built a tiny automated agent that reads my emails and auto-drafts replies using Claude 3.5 Sonnet. Best weekend project ever.", 'type' => 'text'],
        ];

        foreach ($postContents as $postData) {
            $author = $bots[array_rand($bots)];
            $group = (rand(1, 10) > 4) ? $groupModels[array_rand($groupModels)] : null; // 60% chance to post in a group

            $post = \App\Models\Post::create([
                'user_id' => $author->id,
                'group_id' => $group ? $group->id : null,
                'content' => $postData['content'],
                'type' => $postData['type'],
                'poll_options' => $postData['poll_options'] ?? null,
            ]);

            // Add some random likes
            $likeCount = rand(2, 7);
            $likers = collect($bots)->random($likeCount);
            foreach ($likers as $liker) {
                $post->likes()->firstOrCreate(['user_id' => $liker->id]);
            }
        }

        // Tools
        $toolCreator = $bots[array_rand($bots)];
        \App\Models\Tool::firstOrCreate(
            ['url' => 'https://ollama.com'],
            ['name' => 'Ollama', 'description' => 'Get up and running with large language models locally.', 'category' => 'Local AI', 'created_by' => $toolCreator->id]
        );

        // News
        $newsCreator = $bots[array_rand($bots)];
        \App\Models\News::firstOrCreate(
            ['url' => 'https://openai.com/blog'],
            ['title' => 'OpenAI announces new voice capabilities for ChatGPT Plus', 'source' => 'OpenAI Blog', 'content' => 'The new multi-modal model is rolling out...', 'user_id' => $newsCreator->id]
        );
    }
}
