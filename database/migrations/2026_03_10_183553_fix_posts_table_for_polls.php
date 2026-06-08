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
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'poll_options')) {
                $table->json('poll_options')->nullable()->after('type');
            }

            // Modify type to string to be more flexible (instead of enum)
            $table->string('type')->default('text')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('poll_options');
            $table->enum('type', ['text', 'image', 'link', 'prompt', 'code'])->default('text')->change();
        });
    }
};
