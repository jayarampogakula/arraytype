<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('source_url')->nullable()->after('title');
            $table->text('summary')->nullable()->after('source_url');
            $table->string('category')->nullable()->after('summary');
            $table->string('status')->default('pending')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['source_url', 'summary', 'category', 'status']);
        });
    }
};
