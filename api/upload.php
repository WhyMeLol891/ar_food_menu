<?php
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['menu'])) { json_response(['error' => 'Upload a menu image'], 422); }
$file = $_FILES['menu'];
if ($file['error'] !== UPLOAD_ERR_OK) { json_response(['error' => 'Upload failed'], 400); }
if ($file['size'] > MAX_UPLOAD_BYTES) { json_response(['error' => 'The image must be 8 MB or smaller'], 413); }
$info = @getimagesize($file['tmp_name']); $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
if (!$info || !in_array($info['mime'], $allowed, true)) { json_response(['error' => 'Only JPG, PNG, GIF, and WEBP images are accepted'], 415); }
if (!function_exists('imagecreatefromjpeg')) { json_response(['error' => 'PHP GD is required to convert the upload to JPG'], 500); }
$source = match ($info['mime']) { 'image/jpeg' => @imagecreatefromjpeg($file['tmp_name']), 'image/png' => @imagecreatefrompng($file['tmp_name']), 'image/gif' => @imagecreatefromgif($file['tmp_name']), 'image/webp' => @imagecreatefromwebp($file['tmp_name']), default => false };
if (!$source || !@imagejpeg($source, MENU_IMAGE, 88)) { json_response(['error' => 'Could not convert the image to assets/images/menu.jpg'], 500); }
imagedestroy($source); json_response(['ok' => true, 'message' => 'Menu image updated']);
