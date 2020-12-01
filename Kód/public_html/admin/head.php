<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}


///POLOŽKY V MENU A OPRÁVNĚNÍ
/// nazev: Pod jakým názvem se bude zobrazovat v levém menu
/// url: adresa, která slouží ke zvýraznění aktuální stránky
/// opraveni: Která oprávnění budou mít přístup k dané stránce
$_SERVER['menu'] = [
    //autor
    [
        "nazev" => "Vaše příspěvky",
        "url" => "/admin/articles-author",
        "opravneni" => array(1,5)
    ],
    //recenzent
    [
        "nazev" => "Příspěvky k ohodnocení",
        "url" => "/admin/articles-rate",
        "opravneni" => array(2,5)
    ],
    //redaktor, šéfredaktor
    [
        "nazev" => "Příspěvky od autorů",
        "url" => "/admin/articles-all",
        "opravneni" => array(3,4,5)
    ],
    //administrátor
    [
        "nazev" => "Uživatelé",
        "url" => "/admin/users",
        "opravneni" => array(5)
    ]
];


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

