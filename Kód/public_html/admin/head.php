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
        main {
            padding-top: 60px;
            background-color: #e4e8f0;
            height: 80vh;
        }

        div.container-fluid div {
            padding: 20px;
            background-color: white;
        }

        @media (max-width: 600px) {

            div.container-fluid {
                flex-direction: column !important;
            }

            ul.nav {
                flex-direction: row !important;
            }
        }
    </style>
</head>

<body>
<?php
include ROOT . "layout/navbar.php";
?>

<main>

