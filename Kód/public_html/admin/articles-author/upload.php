<?php
/* jmeno: articleName soubor: articleFile */

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/User.php";
include ROOT."session.php";

$dotaz = "INSERT INTO Clanky (nazev, autor) VALUES(?,?)";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["articleName"],$_SESSION["user"]->getId()));

$last_id = $pdo->lastInsertId();
$uploaddir = ROOT."/upload/";
$uploadfile = $uploaddir . basename($last_id.".pdf");
echo $last_id;

if (move_uploaded_file($_FILES['articleFile']['tmp_name'], $uploadfile)) {
    echo "Upload byl dobrej"; //Ondřej je zlej ;-(
} else {
    echo "Possible file upload attack!\n";
}



