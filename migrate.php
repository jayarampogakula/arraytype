<?php

/**
 * ArrayType Standalone Migration Script
 * 
 * Usage: domain.com/migrate.php?token=YOUR_TOKEN
 */

define('LARAVEL_START', microtime(true));

// 1. Load Autoloader
require __DIR__ . '/vendor/autoload.php';

// 2. Boot Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 2.1 Manual Env Check (Fallback for some shared hosts)
if (file_exists(__DIR__ . '/.env')) {
    $content = file_get_contents(__DIR__ . '/.env');
    if (preg_match('/^DEPLOY_TOKEN\s*=\s*["\']?([^"\']+)["\']?/m', $content, $matches)) {
        $_ENV['DEPLOY_TOKEN'] = trim($matches[1]);
        putenv("DEPLOY_TOKEN=" . trim($matches[1]));
    }
}

// 3. Security Check
$envToken = env('DEPLOY_TOKEN') ?: getenv('DEPLOY_TOKEN');
$urlToken = $_GET['token'] ?? '';

if (empty($envToken)) {
    echo "<h1>Error: DEPLOY_TOKEN not found</h1>";
    echo "<p>Please ensure your <code>.env</code> file is uploaded to the root directory and contains:</p>";
    echo "<pre>DEPLOY_TOKEN=\"ARRAYTYPE_DEPLOY_2026\"</pre>";
    exit;
}

if ($urlToken !== $envToken) {
    header('HTTP/1.0 403 Forbidden');
    die("Unauthorized access. Token mismatch.");
}

// 4. Run Migration
echo "<h1>ArrayType Migration Utility</h1>";
echo "<pre>";

$isFresh = isset($_GET['fresh']) && $_GET['fresh'] == 'true';
$command = $isFresh ? 'migrate:fresh' : 'migrate';

try {
    echo "Using Database: " . config('database.connections.mysql.database') . "\n";
    echo "Bypassing foreign key checks...\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    echo "Running $command...\n";
    Artisan::call($command, ['--force' => true]);
    echo Artisan::output();

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "\n$command completed successfully!";
} catch (\Exception $e) {
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "<h2>Error!</h2>";
    echo htmlspecialchars($e->getMessage());
}
echo "</pre>";
