<?php 
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/ActivityLog.php";

//Ondřeji nesahat, zase to zkurvíš :-) Toto je pro fandu aby udělal aktivitu :-) - Smáža

$dotaz = "UPDATE Clanky SET vybrany_r = NULL WHERE id = ?";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["clanekid"]));
$dotaz = "DELETE FROM Clanky_hodnoceni WHERE clanek = ?";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["clanekid"]));

ActivityLog::Log('Článek '.$_POST['clanekid'].' odeslán k přehodnocení');

header('Location: index.php');



?>