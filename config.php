<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Database.php';

#global $DB_PATH;

function getDbPath() {
    $rootDir = dirname(__DIR__);
    $dbPath = $rootDir . DIRECTORY_SEPARATOR . 'db.sqlite';
    return $dbPath;
}

$DB_PATH = getDbPath();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_ENV['DEBUG']) && $_ENV['DEBUG'] === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}


$db = new Database($DB_PATH);
// Fetch metadata
$metadata = $db->getMetadata();
$title = htmlspecialchars($metadata['title']);
$description = htmlspecialchars($metadata['description']);

$menu_items = [
    'edit.php' => 'Edytuj treść',
    'meta.php' => 'Edytuj metadane',
    'index.php' => 'Podgląd'
];