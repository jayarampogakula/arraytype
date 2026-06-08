<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    if (!Schema::hasColumn('tools', 'user_id')) {
        Schema::table('tools', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
        echo "Successfully added user_id to tools table.\n";

        // Assign existing tools to the admin user (ID 1) as a fallback
        DB::table('tools')->whereNull('user_id')->update(['user_id' => 1]);
        echo "Assigned existing tools to user ID 1.\n";
    } else {
        echo "Column user_id already exists in tools table.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
