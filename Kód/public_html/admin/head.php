<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";
include_once ROOT."classes/Functions.php";

if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}


///POLOŽKY V MENU A OPRÁVNĚNÍ
/// nazev: Pod jakým názvem se bude zobrazovat v levém menu
/// url: adresa, která slouží ke zvýraznění aktuální stránky
/// opraveni: Která oprávnění budou mít přístup k dané stránce
$_SERVER['menu'] = [
    [
        "nazev" => "Dashboard",
        "url" => "/admin/",
        "opravneni" => array(0,1,2,3,4,5)
    ],
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
        "opravneni" => array(2,5),
        "dotaz" => "SELECT 1 FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE (Clanky.stav = 0 AND Clanky.vybrany_r = ?)",
        "dotaz_execute_array" => [$_SESSION['user']->GetId()]
    ],
    //redaktor, šéfredaktor
    [
        "nazev" => "Příspěvky od autorů",
        "url" => "/admin/articles-all",
        "opravneni" => array(3,4,5),
        "dotaz" => "SELECT 1 FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE Clanky.stav = 0",
        "dotaz_execute_array" => null
    ],
    [ //redaktor, šéfredaktor, admin // Toto přidá novou položku na které pracuju, na github se to pak bude dávat lépe - Smáža
        "nazev" => "Příspěvky na vydání",
        "url" => "/admin/articles-submit",
        "opravneni" => array(3,4,5),
        "dotaz" => "SELECT 1 FROM Clanky INNER JOIN Users A ON Clanky.autor = A.id INNER JOIN Users B ON Clanky.vybrany_r = B.id INNER JOIN Clanky_hodnoceni ON Clanky.id = Clanky_hodnoceni.clanek WHERE Clanky.stav = 0 AND vybrany_r > 0 "
    ],
    //administrátor
    [
        "nazev" => "Uživatelé",
        "url" => "/admin/users",
        "opravneni" => array(5)
    ],
    [
        "nazev" => "Historie uživ. akcí",
        "url" => "/admin/users-history",
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
        .admin > .row > div[class^="col"] {
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

