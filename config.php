<?php
declare(strict_types=1);

const MENU_IMAGE = __DIR__ . '/assets/images/menu.jpg';
const LAYOUT_FILE = __DIR__ . '/assets/targets/layout.json';
const MAX_UPLOAD_BYTES = 8388608;

function json_response(array $data, int $status = 200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}

function read_layout(): array {
    $contents = @file_get_contents(LAYOUT_FILE);
    $layout = $contents ? json_decode($contents, true) : null;
    return is_array($layout) ? $layout : ['version' => 1, 'dishes' => []];
}
