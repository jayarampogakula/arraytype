<?php
// Load Laravel environment
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$now = now()->toDateTimeString();

// Create Admin User
$userId = DB::table('users')->insertGetId([
    'name' => 'ArrayType Admin',
    'email' => 'admin@arraytype.com',
    'password' => Hash::make('ArrayType#2026!Secure'),
    'is_admin' => 1,
    'admin_role' => 'super_admin',
    'email_verified_at' => $now,
    'created_at' => $now,
    'updated_at' => $now,
]);

// Create Profile for Admin
DB::table('profiles')->insert([
    'user_id' => $userId,
    'bio' => 'Platform administrator for ArrayType — Where AI Minds Connect.',
    'skills' => 'AI, Machine Learning, Platform Management',
    'created_at' => $now,
    'updated_at' => $now,
]);

// Seed Group with admin as creator
DB::table('groups')->insert([
    ['name' => 'AI Agents', 'description' => 'Community for building and deploying AI autonomous agents.', 'created_by' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'Prompt Engineering', 'description' => 'Craft powerful prompts for ChatGPT, Claude, Gemini and more.', 'created_by' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'LLM Development', 'description' => 'Fine-tuning, RLHF, and deploying large language models.', 'created_by' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'AI for Data Engineers', 'description' => 'Using AI to build smarter data pipelines and analytics.', 'created_by' => $userId, 'created_at' => $now, 'updated_at' => $now],
]);

// Make admin member of all groups
$groups = DB::table('groups')->get();
foreach ($groups as $group) {
    DB::table('group_members')->insert([
        'group_id' => $group->id,
        'user_id' => $userId,
        'role' => 'moderator',
        'created_at' => $now,
        'updated_at' => $now,
    ]);
}

// Seed News
DB::table('news')->insert([
    ['title' => 'OpenAI launches GPT-4o with native image output', 'url' => 'https://openai.com', 'source' => 'OpenAI Blog', 'user_id' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['title' => 'Google Gemini Ultra achieves new benchmarks in reasoning', 'url' => 'https://deepmind.google', 'source' => 'Google DeepMind', 'user_id' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['title' => 'Anthropic releases Claude 3.5 Opus with extended context', 'url' => 'https://anthropic.com', 'source' => 'Anthropic', 'user_id' => $userId, 'created_at' => $now, 'updated_at' => $now],
    ['title' => 'Meta releases Llama 3 with 70B parameters openly', 'url' => 'https://ai.meta.com', 'source' => 'Meta AI', 'user_id' => $userId, 'created_at' => $now, 'updated_at' => $now],
]);

// Seed Company and Jobs
$companyId = DB::table('companies')->insertGetId([
    'name' => 'OpenAI',
    'website' => 'https://openai.com',
    'description' => 'Creating safe and beneficial AI.',
    'user_id' => $userId,
    'created_at' => $now,
    'updated_at' => $now,
]);

DB::table('job_listings')->insert([
    ['title' => 'Senior AI Engineer', 'company_id' => $companyId, 'location' => 'Remote / San Francisco', 'type' => 'Full-time', 'description' => 'Join our team to build and scale AI APIs.', 'url' => 'https://openai.com/careers', 'created_at' => $now, 'updated_at' => $now],
    ['title' => 'Prompt Engineer', 'company_id' => $companyId, 'location' => 'Remote', 'type' => 'Full-time', 'description' => 'Design and optimize prompts for production AI systems.', 'url' => 'https://openai.com/careers', 'created_at' => $now, 'updated_at' => $now],
]);

// Seed a welcome feed post
DB::table('posts')->insert([
    'user_id' => $userId,
    'content' => "Welcome to ArrayType — Where AI Minds Connect! 🤖\n\nThis is the central hub for all things AI. Share your discoveries, prompts, code and news with fellow builders. Together we push the frontier of AI forward.",
    'type' => 'text',
    'created_at' => $now,
    'updated_at' => $now,
]);

echo "\n✅ Admin user created successfully!\n";
echo "   Email    : admin@arraytype.com\n";
echo "   Password : ArrayType#2026!Secure\n";
echo "   Admin ID : $userId\n\n";
echo "✅ Seed data created: Groups, News, Tools, Jobs, and Welcome Post\n";
