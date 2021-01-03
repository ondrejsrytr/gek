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

$userid = test_input($_POST['userid']);

$dotaz = $pdo->prepare("SELECT jmeno, email, opravneni FROM Users WHERE id = ?");
$vysledek = $dotaz->execute([$userid]);
$uzivatel = $dotaz->fetch();

$json_arr = array("jmeno" => $uzivatel['jmeno'], "email" => $uzivatel['email'], "opravneni" => $uzivatel['opravneni']);

echo json_encode($json_arr);

$pdo = null;