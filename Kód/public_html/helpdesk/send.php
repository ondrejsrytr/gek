<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";
include ROOT . "classes/db.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$predmet = test_input($_POST['predmet']);
$zprava = test_input($_POST['zprava']);
$dotaz = $pdo->prepare("INSERT INTO Helpdesk_vlakno (predmet, obsah, tazatel) VALUES (\"$predmet\", \"$zprava\", {$_SESSION['user']->getId()})");
$vysledek = $dotaz->execute();

header("Location: /helpdesk");
