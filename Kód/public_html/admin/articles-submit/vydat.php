<?php 
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/ActivityLog.php";

$dotaz = "UPDATE Clanky SET stav = 1 WHERE id = ?";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["clanekid"]));
ActivityLog::Log('Vydán článek '.$_POST['articleId']);

header('Location: index.php');



?>