<?php
/**
 * TestLink Smarty Cache Clearing Script
 *
 * Usage:
 *   1. CLI: php clear_cache.php
 *   2. Web (admin only): https://your-testlink/clear_cache.php?token=YOUR_SECRET
 *
 * SECURITY: Change SECRET_TOKEN below before deploying to production!
 */

// ============================================================
// CONFIGURATION - CHANGE THIS BEFORE PRODUCTION USE
// ============================================================
define('SECRET_TOKEN', 'tL_a8K2mP9xQ3vN7bR4tY6wZ1cF5hJ8gL0sD2aE4uI6oP9qS1tV3xZ5bN7mC9kY2');

// ============================================================
// SECURITY CHECK
// ============================================================
$isCli = (php_sapi_name() === 'cli');

if (!$isCli) {
    if (!isset($_GET['token']) || $_GET['token'] !== SECRET_TOKEN) {
        http_response_code(403);
        die('Forbidden: Invalid or missing token');
    }
    header('Content-Type: text/plain; charset=utf-8');
}

// ============================================================
// MAIN
// ============================================================
$cacheDir = __DIR__ . '/gui/templates_c/';

if (!is_dir($cacheDir)) {
    die("Cache directory not found: $cacheDir\n");
}

if (!is_writable($cacheDir)) {
    die("Cache directory not writable: $cacheDir\nCheck permissions for web server user.\n");
}

echo "Clearing Smarty cache: $cacheDir\n";
echo str_repeat('-', 60) . "\n";

$deleted = 0;
$failed = 0;
$startTime = microtime(true);

$files = glob($cacheDir . '*.php');
foreach ($files as $file) {
    if (is_file($file)) {
        if (@unlink($file)) {
            $deleted++;
        } else {
            $failed++;
            echo "FAILED: $file\n";
        }
    }
}

$elapsed = round((microtime(true) - $startTime) * 1000, 2);

echo str_repeat('-', 60) . "\n";
echo "Deleted: $deleted files\n";
echo "Failed:  $failed files\n";
echo "Time:    {$elapsed} ms\n";
echo "\nDone! Smarty will recompile templates on next page load.\n";
