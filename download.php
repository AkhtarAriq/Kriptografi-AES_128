<?php
$file = isset($_GET['file']) ? $_GET['file'] : '';

if ($file && file_exists("uploads/$file")) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    readfile("uploads/$file");
    exit;
} else {
    echo "File not found!";
}
