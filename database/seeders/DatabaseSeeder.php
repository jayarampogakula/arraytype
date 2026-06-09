<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@arraytype.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('adMin@2026#'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'user@arraytype.com'],
            [
                'name' => 'Demo User',
                'username' => 'user',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $botUser = \App\Models\User::firstOrCreate(
            ['email' => 'bot@arraytype.local'],
            [
                'name' => 'Automated Bot (AI Assistant)',
                'username' => 'bot',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $botUser->id],
            [
                'bio' => 'I build and research artificial intelligence systems.',
                'skills' => json_encode(['AI', 'Machine Learning']),
            ]
        );

        // Additional testing logic
        $users = \App\Models\User::factory(4)->create();
        foreach ($users as $user) {
            \App\Models\Profile::create([
                'user_id' => $user->id,
                'bio' => 'Enthusiast testing the platform.',
            ]);
        }

        foreach ($users->take(2) as $user) {
            \App\Models\Tool::create([
                'user_id' => $user->id,
                'name' => 'Awesome AI ' . ucfirst(fake()->word()),
                'url' => 'https://awesomeai.local',
                'description' => 'A powerful local tool for managing vector indexing, semantic search, and RAG embeddings.',
                'category' => 'LLM / Chatbot',
            ]);

            \App\Models\Product::create([
                'user_id' => $user->id,
                'category_id' => 1,
                'name' => 'NextGen ' . ucfirst(fake()->word()),
                'tagline' => 'Accelerating developer productivity using AI agents.',
                'description' => 'An automated coding companion that writes, refactors, and tests code directly from natural language specifications.',
                'website_url' => 'https://nextgen.local',
                'status' => 'approved',
            ]);
        }

        // Tech Company and Jobs
        $company = \App\Models\Company::create([
            'user_id' => $users->last()->id,
            'name' => 'Silicon AI Partners',
            'website' => 'https://siliconai.local',
            'description' => 'A cutting edge AI startup.',
        ]);

        \App\Models\JobListing::create([
            'company_id' => $company->id,
            'title' => 'Senior Prompter & Researcher',
            'location' => 'San Francisco',
            'remote' => true,
            'type' => 'Full-time',
            'description' => 'Looking for an experienced LLM prompt engineer dedicated to cutting edge solutions.',
        ]);

        // Seed News
        $newsArticles = [
            [
                'title' => 'OpenAI Releases Advanced Reasoning Model GPT-5 Reasoning Engine',
                'summary' => 'OpenAI has officially launched its next-generation reasoning engine, showcasing significant improvements in mathematics, logical synthesis, and code generation tasks.',
                'content' => "In an official blog post today, OpenAI announced the release of GPT-5's new reasoning capabilities. The model uses an updated chain-of-thought architecture that allows it to self-correct and verify its logic before returning final responses. Benchmarks show a 40% improvement on complex mathematics and competitive programming tasks.",
                'category' => 'Industry',
            ],
            [
                'title' => 'NVIDIA Unveils Next-Gen Blackwell Architecture for AI Datacenters',
                'summary' => 'NVIDIA announced its Blackwell GPU cluster architecture, offering up to 25x reduced energy consumption and cost compared to previous generation Hopper architectures.',
                'content' => "During the GTC keynote address, NVIDIA CEO Jensen Huang detailed the new Blackwell platform. Featuring 208 billion transistors, the dual-die chip provides significant throughput gains for LLM inference and trillion-parameter foundational model training. Major cloud providers have already committed to deploying Blackwell clusters later this year.",
                'category' => 'Hardware',
            ]
        ];

        foreach ($newsArticles as $idx => $art) {
            \App\Models\News::create([
                'user_id' => $users->skip($idx)->first()->id ?? $users->first()->id,
                'title' => $art['title'],
                'summary' => $art['summary'],
                'content' => $art['content'],
                'status' => 'approved',
                'category' => $art['category'],
                'source_url' => 'https://news.ycombinator.com',
            ]);
        }

        $this->call([
            BotsSeeder::class,
        ]);
    }
}
