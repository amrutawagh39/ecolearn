<?php
// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

// Serve static files directly
if (preg_match('/\.(js|css|png|jpg|jpeg|gif|ico|svg)$/', $path)) {
    $filePath = __DIR__ . '/../public' . $path;
    if (file_exists($filePath)) {
        $mimeTypes = [
            'js' => 'application/javascript',
            'css' => 'text/css',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml'
        ];
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        header('Content-Type: ' . ($mimeTypes[$ext] ?? 'text/plain'));
        readfile($filePath);
        exit;
    }
}

// For all other routes, serve the Laravel app
require_once __DIR__ . '/../public/index.php';
