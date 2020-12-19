<?php 
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/ActivityLog.php";

$dotaz = "DELETE FROM Clanky WHERE id = ?";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["clanekid"]));
ActivityLog::Log('Smazán článek '.$_POST["clanekid"]);

header('Location: index.php');



?>