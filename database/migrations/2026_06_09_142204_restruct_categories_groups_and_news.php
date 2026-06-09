<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Schema updates for news table
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'views_count')) {
                $table->integer('views_count')->default(0)->after('user_id');
            }
            if (!Schema::hasColumn('news', 'is_hot')) {
                $table->boolean('is_hot')->default(false)->after('views_count');
            }
        });

        // 2. Restructure product_categories
        $newCategories = [
            'Agents' => 'agents',
            'Automation' => 'automation',
            'Content' => 'content',
            'Coding' => 'coding',
            'Models' => 'models',
            'Prompts' => 'prompts',
            'Productivity' => 'productivity',
            'Research' => 'research',
        ];

        // Insert new categories if not exist
        $newCategoryIds = [];
        foreach ($newCategories as $name => $slug) {
            $catId = DB::table('product_categories')->where('slug', $slug)->value('id');
            if (!$catId) {
                $catId = DB::table('product_categories')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $newCategoryIds[$slug] = $catId;
        }

        // Map old category slugs to new category IDs
        $mapping = [
            'ai-agents' => 'agents',
            'automation-tools' => 'automation',
            'developer-tools' => 'productivity',
            'ai-tools' => 'productivity',
            'ai-saas' => 'productivity',
            'productivity' => 'productivity',
            'ai-customer-support' => 'productivity',
            'ai-search-engines' => 'productivity',
            'ai-coding-assistants' => 'coding',
            'ai-models' => 'models',
            'ml-infra' => 'models',
            'ai-art-design' => 'content',
            'ai-chatbots' => 'content',
            'video-audio-ai' => 'content',
            'ai-writing-copywriting' => 'content',
            'data-analytics' => 'research',
            'health-biotech-ai' => 'research',
            'ai-finance-fintech' => 'research',
            'marketing-seo' => 'content',
        ];

        // Update existing products with new category_id
        $oldCategories = DB::table('product_categories')->get();
        foreach ($oldCategories as $oldCat) {
            if (in_array($oldCat->slug, array_values($newCategories))) {
                continue; // Do not migrate/delete the new ones
            }

            $targetSlug = $mapping[$oldCat->slug] ?? 'productivity';
            $targetId = $newCategoryIds[$targetSlug];

            DB::table('products')->where('category_id', $oldCat->id)->update([
                'category_id' => $targetId
            ]);

            // Now delete the old category record
            DB::table('product_categories')->where('id', $oldCat->id)->delete();
        }

        // 3. Restructure groups (reddit-style)
        // Core groups: discussions, showcases, questions, tutorials
        $newGroups = [
            'Discussions' => [
                'slug' => 'discussions',
                'description' => 'General discussions on artificial intelligence, tech, and models.'
            ],
            'Showcases' => [
                'slug' => 'showcases',
                'description' => 'Show off your builds, products, side-projects, and custom AI tools.'
            ],
            'Questions' => [
                'slug' => 'questions',
                'description' => 'Ask questions, seek help, and get answers from experts and builders.'
            ],
            'Tutorials' => [
                'slug' => 'tutorials',
                'description' => 'Guides, walkthroughs, prompting tips, and educational articles.'
            ],
        ];

        $newGroupIds = [];
        $adminId = DB::table('users')->where('is_admin', true)->value('id') ?? 1;

        foreach ($newGroups as $name => $data) {
            $groupId = DB::table('groups')->where('slug', $data['slug'])->value('id');
            if (!$groupId) {
                $groupId = DB::table('groups')->insertGetId([
                    'name' => $name,
                    'slug' => $data['slug'],
                    'description' => $data['description'],
                    'is_private' => false,
                    'created_by' => $adminId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $newGroupIds[$data['slug']] = $groupId;
        }

        // Map any existing posts & memberships to the 'discussions' group by default, and delete old groups
        $oldGroups = DB::table('groups')->get();
        $defaultGroupId = $newGroupIds['discussions'];

        foreach ($oldGroups as $oldGroup) {
            if (array_key_exists($oldGroup->slug, $newGroupIds)) {
                continue; // Do not delete new groups
            }

            // Move posts to default discussions group
            DB::table('posts')->where('group_id', $oldGroup->id)->update([
                'group_id' => $defaultGroupId
            ]);

            // Move members to default discussions group
            $members = DB::table('group_members')->where('group_id', $oldGroup->id)->get();
            foreach ($members as $m) {
                $exists = DB::table('group_members')
                    ->where('group_id', $defaultGroupId)
                    ->where('user_id', $m->user_id)
                    ->exists();
                if (!$exists) {
                    DB::table('group_members')->insert([
                        'group_id' => $defaultGroupId,
                        'user_id' => $m->user_id,
                        'role' => $m->role,
                        'created_at' => $m->created_at,
                        'updated_at' => $m->updated_at,
                    ]);
                }
            }

            // Delete old group
            DB::table('groups')->where('id', $oldGroup->id)->delete();
            DB::table('group_members')->where('group_id', $oldGroup->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'is_hot']);
        });
    }
};
