<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

ob_start();

switch ($page) {
    case 'login':
        include(__DIR__ . "/pages/login.php");
        break;
    case 'register':
        include(__DIR__ . "/pages/register.php");
        break;
<<<<<<< HEAD
=======
    case 'catalog-event':
        include(__DIR__ . "/pages/catalog-event.php");

>>>>>>> main
    default:
        include(__DIR__ . "/pages/home.php");
        break;
}

$content = ob_get_clean();

include(__DIR__ . "/layout/layout.php");
?>
