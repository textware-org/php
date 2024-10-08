<?php
require_once __DIR__ . '/config.php';
global $menu_items;
$current_page = basename($_SERVER['PHP_SELF']);
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true):
    ?>
    <div class="footer menu">
        <?php
        $first = true;
        foreach ($menu_items as $page => $label) {
            if ($page !== $current_page) {
                if (!$first) {
                    echo ' | ';
                }
                echo '<a href="' . $page . '">' . $label . '</a>';
                $first = false;
            }
        }
        ?>
    </div>
    <div class="footer menu">
        <a href="logout.php">Wyloguj się</a>
    </div>
<?php elseif ($current_page !== "login.php"): ?>
    <div class="footer menu">
        <a href="login.php">Zaloguj się</a>
    </div>
<?php elseif ($current_page !== "index.php"): ?>
    <div class="footer menu">
        <a href="index.php">Podgląd</a>
    </div>
<?php endif; ?>