<?php
// Enable error reporting for debugging on Vercel
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$appStorage = '/tmp/storage';
$dirs = [
    $appStorage . '/app',
    $appStorage . '/framework/cache/data',
    $appStorage . '/framework/views',
    $appStorage . '/framework/sessions',
    $appStorage . '/logs',
    '/tmp/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
putenv('VIEW_COMPILED_PATH=' . $_ENV['VIEW_COMPILED_PATH']);

$_ENV['SESSION_DRIVER'] = 'cookie';
putenv('SESSION_DRIVER=' . $_ENV['SESSION_DRIVER']);

$_ENV['LOG_CHANNEL'] = 'stderr';
putenv('LOG_CHANNEL=' . $_ENV['LOG_CHANNEL']);

$_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
putenv('APP_CONFIG_CACHE=' . $_ENV['APP_CONFIG_CACHE']);

$_ENV['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';
putenv('APP_EVENTS_CACHE=' . $_ENV['APP_EVENTS_CACHE']);

$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
putenv('APP_PACKAGES_CACHE=' . $_ENV['APP_PACKAGES_CACHE']);

$_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes.php';
putenv('APP_ROUTES_CACHE=' . $_ENV['APP_ROUTES_CACHE']);

$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
putenv('APP_SERVICES_CACHE=' . $_ENV['APP_SERVICES_CACHE']);

// Forward request to Laravel's public/index.php
require __DIR__ . '/../public/index.php';
