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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('admin_role')->nullable()->after('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_pinned');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin_role');
        });
    }
};
