<?php

$publicPath = __DIR__ . '/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// If the requested file exists in the public folder, serve it directly
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Otherwise, route everything through public/index.php
require_once __DIR__ . '/index.php';
