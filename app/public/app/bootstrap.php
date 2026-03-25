<?php
require_once 'config/config.php';

set_exception_handler(function (\Throwable $e) {
    error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

    http_response_code(500);
    $errorCode = '500';
    $errorMessage = 'An unexpected error occurred.';

    if ($e instanceof \RuntimeException && $e->getMessage() === 'Database connection failed.') {
        $errorMessage = 'Failed to connect to the database. Please try again later.';
    }

    if (str_contains($e->getMessage(), '404')) {
        http_response_code(404);
        $errorCode = '404';
        $errorMessage = 'The page could not be found.';
    }

    require_once APP_ROOT . '/views/inc/error.php';
});

// TODO: Replace with Composer PSR-4 autoloading once Composer and PHP are installed.
// This currently only autoloads classes from libraries/. Controllers and models
// are still loaded manually via require_once in Core.php and Controller.php.
// Steps:
// 1. Install PHP + Composer (e.g. via Laragon)
// 2. Run: composer init
// 3. Add PSR-4 autoload mapping in composer.json for controllers/, models/, libraries/:
//
//    {
//        "autoload": {
//            "psr-4": {
//                "App\\Controllers\\": "app/controllers/",
//                "App\\Models\\":      "app/models/",
//                "App\\Libraries\\":  "app/libraries/"
//            }
//        }
//    }
//
// 4. Run: composer dump-autoload
// 5. Replace this block with: require_once '../vendor/autoload.php';
spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});

// Init core library
$init = new Core;