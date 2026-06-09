<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            ['name' => 'AI Coding Assistants', 'slug' => 'ai-coding-assistants'],
            ['name' => 'Machine Learning Infra', 'slug' => 'ml-infra'],
            ['name' => 'AI Search Engines', 'slug' => 'ai-search-engines'],
            ['name' => 'AI Customer Support', 'slug' => 'ai-customer-support'],
            ['name' => 'AI Writing & Copywriting', 'slug' => 'ai-writing-copywriting'],
            ['name' => 'AI Finance & Fintech', 'slug' => 'ai-finance-fintech'],
            ['name' => 'Health & Biotech AI', 'slug' => 'health-biotech-ai'],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                ['name' => $category['name'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $slugs = [
            'ai-coding-assistants',
            'ml-infra',
            'ai-search-engines',
            'ai-customer-support',
            'ai-writing-copywriting',
            'ai-finance-fintech',
            'health-biotech-ai'
        ];

        DB::table('product_categories')->whereIn('slug', $slugs)->delete();
    }
};
