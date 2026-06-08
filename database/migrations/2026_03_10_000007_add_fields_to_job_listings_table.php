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
        Schema::table('job_listings', function (Blueprint $table) {
            $table->boolean('remote')->default(false)->after('location');
            $table->string('apply_url')->nullable()->after('url');
            $table->string('salary_range')->nullable()->after('apply_url');
            $table->timestamp('featured_until')->nullable()->after('salary_range');
            $table->foreignId('posted_by')->nullable()->after('featured_until')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('posted_by');
            $table->dropColumn(['remote', 'apply_url', 'salary_range', 'featured_until']);
        });
    }
};
