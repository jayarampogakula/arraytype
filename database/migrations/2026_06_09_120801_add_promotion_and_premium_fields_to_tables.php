<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('is_admin');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('pin_type')->default('none')->after('is_pinned'); // 'none', 'homepage', 'category'
            $table->timestamp('pinned_until')->nullable()->after('pin_type');
            $table->string('custom_cta_text')->nullable()->after('website_url');
            $table->integer('views_count')->default(0)->after('status');
            $table->integer('clicks_count')->default(0)->after('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_premium');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['pin_type', 'pinned_until', 'custom_cta_text', 'views_count', 'clicks_count']);
        });
    }
};
