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
                'name' => 'Awesome AI ' . fake()->word(),
                'url' => fake()->url(),
                'description' => fake()->paragraph(),
                'category' => 'LLM / Chatbot',
            ]);

            \App\Models\Product::create([
                'user_id' => $user->id,
                'category_id' => 1,
                'name' => 'NextGen ' . fake()->word(),
                'tagline' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'website_url' => fake()->url(),
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
        foreach ($users->take(1) as $user) {
            \App\Models\News::create([
                'user_id' => $user->id,
                'title' => fake()->sentence(),
                'summary' => fake()->paragraph(),
                'content' => fake()->paragraphs(3, true),
                'status' => 'approved',
                'category' => 'Industry',
                'source_url' => 'https://news.ycombinator.com',
            ]);
        }

        $this->call([
            BotsSeeder::class,
        ]);
    }
}
