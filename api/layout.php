<?php
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') { json_response(read_layout()); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { json_response(['error' => 'Method not allowed'], 405); }
$payload = json_decode(file_get_contents('php://input'), true);
if (!is_array($payload) || !isset($payload['dishes']) || !is_array($payload['dishes'])) { json_response(['error' => 'A valid dishes array is required'], 422); }
$payload['version'] = 1; $payload['updatedAt'] = date(DATE_ATOM);
if (@file_put_contents(LAYOUT_FILE, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) === false) { json_response(['error' => 'Layout file is not writable'], 500); }
json_response(['ok' => true, 'layout' => $payload]);
