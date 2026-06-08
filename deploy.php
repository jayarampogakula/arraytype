<?php

/**
 * AIans Robust One-Click Deployment Script
 * 
 * Usage: domain.com/deploy.php?token=YOUR_TOKEN
 */

define('LARAVEL_START', microtime(true));

// Check if vendor exists (needed for Laravel boot)
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "<h1>Error: vendor/autoload.php missing</h1>";
    echo "Please run 'composer install' via SSH or upload the vendor folder.";
    exit;
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Security Check
$envToken = env('DEPLOY_TOKEN');
$urlToken = $_GET['token'] ?? '';

if (empty($envToken)) {
    die("Error: DEPLOY_TOKEN not set in .env");
}

if ($urlToken !== $envToken) {
    header('HTTP/1.0 403 Forbidden');
    die("Unauthorized access.");
}

echo "<h1>AIans Deployment System</h1>";
echo "<pre>";

function runCommand($command)
{
    echo "<strong>Executing: $command</strong>\n";
    if (!function_exists('shell_exec')) {
        echo "Error: shell_exec() is disabled on this server.\n";
        return;
    }

    $output = shell_exec($command . " 2>&1");
    if ($output === null) {
        echo "No output returned (shell_exec failed or returned nothing).\n";
    } else {
        echo htmlspecialchars($output) . "\n";
    }
    echo str_repeat("-", 40) . "\n";
}

function runArtisan($command, $params = [])
{
    echo "<strong>Running Artisan: $command</strong>\n";
    try {
        Artisan::call($command, $params);
        echo htmlspecialchars(Artisan::output()) . "\n";
    } catch (\Exception $e) {
        echo "Artisan Error: " . $e->getMessage() . "\n";
    }
    echo str_repeat("-", 40) . "\n";
}

// 1. Pull latest changes
if (is_dir(__DIR__ . '/.git')) {
    runCommand("git pull origin main");
}

// 2. Internal Laravel tasks (Don't depend on shell_exec)
runArtisan('migrate', ['--force' => true]);
runArtisan('optimize:clear');
runArtisan('view:cache');
runArtisan('config:cache');

// 3. Optional dependencies (Require shell_exec)
echo "\n--- Optional Shell Commands ---\n";
runCommand("composer install --no-interaction --prefer-dist --optimize-autoloader");
runCommand("npm install && npm run build");

echo "\nDeployment check finished!";
echo "</pre>";
