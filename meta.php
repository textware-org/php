<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/Auth.php';
require_once __DIR__ . '/src/Database.php';
global $DB_PATH;
global $title;
global $htmlContent;

$title = 'Logowanie';


session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$db = new Database($DB_PATH);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    if ($db->saveMetadata($title, $description)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to save metadata. Please try again.";
    }
}

$metadata = $db->getMetadata();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once __DIR__ . '/head.php'; ?>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
<div class="tophead">
    <h1><?php echo $title; ?></h1>
</div>
<div class="info">
    <?php if ($error): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</div>
<div class="content">
    <form method="POST">
        <div class="form-group">

            <label for="title">Tytuł:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($metadata['title']); ?>"
                   required><br>
        </div>
        <div class="form-group">

            <label for="description">Opis:</label>
            <textarea id="description" name="description" class="form-control" placeholder="Responsive textarea"
                      required><?php echo htmlspecialchars($metadata['description']); ?></textarea><br>
        </div>
        <div class="form-group">
            <input type="submit" value="Zapisz metadane">
        </div>
    </form>
</div>
<footer>
    <?php require_once __DIR__ . '/foot.php'; ?>
</footer>
</body>
</html>