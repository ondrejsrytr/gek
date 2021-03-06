<?php
/* jmeno: articleName soubor: articleFile */

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/User.php";
include_once ROOT."classes/ActivityLog.php";
include ROOT."session.php";

if($_POST["tematicky_casopis"] == 0) $_POST["tematicky_casopis"] = null;

$dotaz = "INSERT INTO Clanky (nazev, autor, tematicky_casopis) VALUES(?,?,?)";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["articleName"],$_SESSION["user"]->getId(), $_POST["tematicky_casopis"]));

$last_id = $pdo->lastInsertId();
$uploaddir = ROOT."upload/";
$extension = "";


switch($_FILES['articleFile']['type']) {
    case "application/pdf":
        $extension = ".pdf";
        break;
    case "application/msword":
    case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        $extension = ".docx";
        break;
}

$uploadfile = $uploaddir . basename($last_id. $extension);

echo $last_id;

if (move_uploaded_file($_FILES['articleFile']['tmp_name'], $uploadfile)) {
    ActivityLog::Log('Nahrán článek '.$last_id);
    header("Location: index.php");
} else {
    echo "Possible file upload attack!\n";
}



