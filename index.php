<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Markdown.php';
global $DB_PATH;
global $title;
global $htmlContent;

//var_dump($DB_PATH);
session_start();

$db = new Database($DB_PATH);
$markdown = new Markdown();
$content = $db->getContent();
$htmlContent = $markdown->parse($content);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once __DIR__ . '/head.php'; ?>
</head>
<body>

<!--<div class="tophead">-->
<!--    <h1>--><?php //echo $title; ?><!--</h1>-->
<!--</div>-->
<div class="content">
    <div class="markdown">
        <?php echo $htmlContent; ?>
    </div>
</div>
<footer>
    <?php require_once __DIR__ . '/foot.php'; ?>
</footer>
</body>
</html>