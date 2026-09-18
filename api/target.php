<?php
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$targetFile = __DIR__ . '/../assets/targets/menu.mind';
	json_response(['installed' => is_file($targetFile) && filesize($targetFile) > 0]);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['target'])) { json_response(['error' => 'Upload a compiled .mind target'], 422); }
$file = $_FILES['target']; $name = strtolower((string)$file['name']);
if ($file['error'] !== UPLOAD_ERR_OK || !str_ends_with($name, '.mind')) { json_response(['error' => 'Only compiled MindAR .mind files are accepted'], 415); }
if (@move_uploaded_file($file['tmp_name'], __DIR__ . '/../assets/targets/menu.mind')) { json_response(['ok' => true, 'message' => 'Tracking target installed']); }
json_response(['error' => 'Could not save the target file'], 500);
