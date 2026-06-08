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
            ['name' => 'AI Tools', 'slug' => 'ai-tools'],
            ['name' => 'AI Agents', 'slug' => 'ai-agents'],
            ['name' => 'Developer Tools', 'slug' => 'developer-tools'],
            ['name' => 'Automation Tools', 'slug' => 'automation-tools'],
            ['name' => 'AI SaaS', 'slug' => 'ai-saas'],
            ['name' => 'AI Models', 'slug' => 'ai-models'],
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
        DB::table('product_categories')->whereIn('slug', [
            'ai-tools',
            'ai-agents',
            'developer-tools',
            'automation-tools',
            'ai-saas',
            'ai-models',
        ])->delete();
    }
};
