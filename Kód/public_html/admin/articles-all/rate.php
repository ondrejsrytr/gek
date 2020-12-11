<?php

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/User.php";
include ROOT."session.php";

$vysledek = $pdo->prepare("INSERT INTO Clanky_hodnoceni (clanek, hodnotitel, aktualnost, originalita, odbornost, format) VALUES(?,?,?,?,?,?)");
$vysledek->execute(array($_POST["articleId"],$_SESSION["user"]->getId(), $_POST["aktualnost"], $_POST["originalita"],$_POST["odbornost"],$_POST["format"]));

$stav;

//tohle se mozna muze vyhodit, podle toho jak budeme nakladat s neschvalenyma clankama... muzeme je nechat jako neschvaleny, ale to by tam asi delalo bordel, jak jinak rozlisit mezi jeste neschvalenym a odmitnutym?
if($_POST["articleApproved"] == true) {
	$stav = 1; //schvalen
}
else {
	$stav = -1; //neschvalen
}

$vysledek = $pdo->prepare("UPDATE Clanky SET stav = ? WHERE id = ?");
$vysledek->execute(array($stav, $_POST["articleId"]));



echo ("jsem tu, nespadlo to. ");
echo($stav);
echo(" jo?");
