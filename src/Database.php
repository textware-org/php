<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Database
{
    private $db;
    private $DB_PATH;

    public function __construct($DB_PATH)
    {
        $this->DB_PATH = $DB_PATH;
        try {
            if (!file_exists($this->DB_PATH)) {
                $dir = dirname($this->DB_PATH);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                chmod($this->DB_PATH, 0666);
            }
            $this->db = new SQLite3($this->DB_PATH, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
            $this->db->enableExceptions(true);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }


    private function handleError($e)
    {
        $errorMessage = "src\Database error: " . $e->getMessage() . "\n";
        $errorMessage .= "src\Database path: " . $this->DB_PATH . "\n";
        $errorMessage .= "File exists: " . (file_exists($this->DB_PATH) ? 'Yes' : 'No') . "\n";
        if (file_exists($this->DB_PATH)) {
            $errorMessage .= "File permissions: " . substr(sprintf('%o', fileperms($this->DB_PATH)), -4) . "\n";
        }
        $errorMessage .= "Current user: " . exec('whoami') . "\n";
        $errorMessage .= "Directory writable: " . (is_writable(dirname($this->DB_PATH)) ? 'Yes' : 'No') . "\n";

        error_log($errorMessage);

        if (isset($_ENV['DEBUG']) && $_ENV['DEBUG'] === 'true') {
            die($errorMessage);
        } else {
            die("src\Database connection failed. Please check the error log.");
        }
    }

    private function createTables()
    {
        $this->db->exec('
            CREATE TABLE IF NOT EXISTS content (
                id INTEGER PRIMARY KEY,
                markdown TEXT
            )
        ');
        $this->db->exec('
            CREATE TABLE IF NOT EXISTS metadata (
                id INTEGER PRIMARY KEY,
                title TEXT,
                description TEXT
            )
        ');
    }

    public function getContent()
    {
        try {
            $result = $this->db->query('SELECT markdown FROM content ORDER BY id DESC LIMIT 1');
            if ($result === false) {
                // Preparation failed
                $error = $this->db->lastErrorMsg();
                throw new Exception("Failed to prepare statement: $error");
            }
            $row = $result->fetchArray(SQLITE3_ASSOC);
            return $row ? $row['markdown'] : '';
        } catch (Exception $e) {
            error_log("Error getting content: " . $e->getMessage());
            return '';
        }
    }

    public function saveContent($content)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO content (markdown) VALUES (:content)');
            if ($stmt === false) {
                // Preparation failed
                $error = $this->db->lastErrorMsg();
                throw new Exception("Failed to prepare statement: $error");
            }

            $stmt->bindValue(':content', $content, SQLITE3_TEXT);
            $result = $stmt->execute();
            if (!$result) {
                throw new Exception($this->db->lastErrorMsg());
            }
            return true;
        } catch (Exception $e) {
            error_log("Error saving content: " . $e->getMessage());
            return false;
        }
    }

    public function getMetadata()
    {
        try {
            $result = $this->db->query('SELECT title, description FROM metadata ORDER BY id DESC LIMIT 1');
            $row = $result->fetchArray(SQLITE3_ASSOC);
            return $row ? $row : ['title' => '', 'description' => ''];
        } catch (Exception $e) {
            error_log("Error getting metadata: " . $e->getMessage());
            return ['title' => '', 'description' => ''];
        }
    }

    public function saveMetadata($title, $description)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO metadata (title, description) VALUES (:title, :description)');
            if (!$stmt) {
                throw new Exception($this->db->lastErrorMsg());
            }
            $stmt->bindValue(':title', $title, SQLITE3_TEXT);
            $stmt->bindValue(':description', $description, SQLITE3_TEXT);
            $result = $stmt->execute();
            if (!$result) {
                throw new Exception($this->db->lastErrorMsg());
            }
            return true;
        } catch (Exception $e) {
            error_log("Error saving metadata: " . $e->getMessage());
            return false;
        }
    }
}