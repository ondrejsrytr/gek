<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Administrace</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
    <style>
        .admin .row .col-lg-3, .admin .row .col-lg-9 {
            margin-top: 30px;
        }
        .admin .col-content {
            background-color: white;
            height: 100%;
            padding: 30px;
        }
        .admin .col-menu {
            padding: 10px;
            background-color: white;
            height: 100%;
        }
    </style>
</head>

<body>
<?php
include ROOT . "layout/navbar.php";
?>

<main>

