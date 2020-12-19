<?php

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/User.php";
include_once ROOT."classes/ActivityLog.php";
include ROOT."session.php";

$vysledek = $pdo->prepare("INSERT INTO Clanky_hodnoceni (clanek, hodnotitel, aktualnost, originalita, odbornost, format) VALUES(?,?,?,?,?,?)");
$vysledek->execute(array($_POST["articleId"],$_SESSION["user"]->getId(), $_POST["aktualnost"], $_POST["originalita"],$_POST["odbornost"],$_POST["format"]));

ActivityLog::Log('Ohodnocen článek '.$_POST['articleId']);



echo ("jsem tu, nespadlo to. ");
echo($stav);
echo(" jo?");
