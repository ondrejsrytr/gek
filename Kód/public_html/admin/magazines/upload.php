<?php
/* jmeno: articleName soubor: articleFile */

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/db.php";
include_once ROOT."classes/User.php";
include_once ROOT."classes/ActivityLog.php";
include ROOT."session.php";

$dotaz = "INSERT INTO Casopisy (nazev, vydavatel) VALUES(?,?)";
$vysledek = $pdo->prepare($dotaz);
$vysledek->execute(array($_POST["magName"], $_SESSION["user"]->getId()));

$last_id = $pdo->lastInsertId();
$uploaddir = ROOT."upload2/";
$extension = "";


switch($_FILES['magFile']['type']) {
    case "application/pdf":
        $extension = ".pdf";
        break;
    case "application/msword":
    case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        $extension = ".docx";
        break;
    case "application/zip":
    case "application/octet-stream":
    case "application/x-zip-compressed":
    case "multipart/x-zip":
        $extension = ".zip";
        break;
}

$uploadfile = $uploaddir . basename($last_id. $extension);

echo $last_id;

if (move_uploaded_file($_FILES['magFile']['tmp_name'], $uploadfile)) {
    ActivityLog::Log('Nahrán časopis '.$last_id);
    header("Location: index.php");
} else {
    echo "Possible file upload attack!\n";
}



