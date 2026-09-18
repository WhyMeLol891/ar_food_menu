<?php
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$targetFiles = [__DIR__ . '/../assets/targets/menu.mind', __DIR__ . '/../assets/targets/targets.mind'];
	$targetFile = array_values(array_filter($targetFiles, static fn(string $path): bool => is_file($path) && filesize($path) > 0))[0] ?? null;
	json_response(['installed' => $targetFile !== null, 'file' => $targetFile ? basename($targetFile) : null, 'version' => $targetFile ? (int) filemtime($targetFile) : 0]);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['target'])) { json_response(['error' => 'Upload a compiled .mind target'], 422); }
$file = $_FILES['target']; $name = strtolower((string)$file['name']);
if ($file['error'] !== UPLOAD_ERR_OK || !str_ends_with($name, '.mind')) { json_response(['error' => 'Only compiled MindAR .mind files are accepted'], 415); }
$targetDirectory = __DIR__ . '/../assets/targets';
$targetPath = $targetDirectory . '/menu.mind';
if (!is_dir($targetDirectory) && !@mkdir($targetDirectory, 0775, true)) { json_response(['error' => 'The targets folder could not be created'], 500); }
if (@move_uploaded_file($file['tmp_name'], $targetPath) && is_file($targetPath) && filesize($targetPath) > 0) { json_response(['ok' => true, 'message' => 'Tracking target installed and saved', 'size' => filesize($targetPath), 'version' => (int) filemtime($targetPath)]); }
json_response(['error' => 'Could not save the target file'], 500);
