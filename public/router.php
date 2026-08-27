<?php

// Router for PHP's built-in server (php -S), so it serves real static files
// (CSS/JS/images) directly and boots the Symfony kernel for everything else.
// Note: this can't simply require() index.php — symfony/runtime needs this
// file itself to be the entry point (php -S sets SCRIPT_FILENAME to it), so
// the kernel bootstrap below mirrors index.php instead of delegating to it.
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ('/' !== $path && is_file(__DIR__.$path)) {
    return false;
}

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return static function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
