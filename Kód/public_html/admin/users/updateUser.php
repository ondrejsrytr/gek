<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

include_once ROOT."classes/db.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$id = test_input($_POST['id']);
$jmeno = test_input($_POST['jmeno']);
$email = test_input($_POST['email']);
$heslo = test_input($_POST['heslo']);
$opravneni = test_input($_POST['opravneni']);


if(!empty($heslo)) {
    $hash = password_hash($heslo,  PASSWORD_DEFAULT);
    $dotaz = $pdo->prepare("UPDATE Users SET jmeno = ?, email = ?, heslo = ?, opravneni = ? WHERE id = ?");
    $vysledek = $dotaz->execute([$jmeno, $email, $hash, $opravneni, $id]);
}
else {
    $dotaz = $pdo->prepare("UPDATE Users SET jmeno = ?, email = ?, opravneni = ? WHERE id = ?");
    $vysledek = $dotaz->execute([$jmeno, $email, $opravneni, $id]);
}

header("Location: index.php");