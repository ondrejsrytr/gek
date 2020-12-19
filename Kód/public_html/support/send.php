<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

include_once ROOT."classes/email.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$predmet = test_input($_POST['predmet']);
$zprava = test_input($_POST['zprava']);

$_SESSION['send_email_feedback'] = array(); //zde bude pole zpráv, které se předají do frontendu

$isok = true;

if(empty($predmet)) {
    array_push($_SESSION['send_email_feedback'], array(
        "message" => "Předmět nesmí být prázdný",
        "alert_class" => "alert-danger"
    ));
    $isok = false;
}
if(empty($zprava)) {
    array_push($_SESSION['send_email_feedback'], array(
        "message" => "Obsah zprávy nesmí být prázdný",
        "alert_class" => "alert-danger"
    ));
    $isok = false;
}
if($isok) {
    include ROOT."classes/db.php";
    $dotaz = $pdo->prepare("SELECT email FROM Users WHERE opravneni = 5");
    $vysledek = $dotaz->execute();
    $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);

    $admini = "";

    foreach ($vysledky as $v) {
        if(!empty($v['email'])) {
            if($admini != "") $admini .= ", ";
            $admini .= $v['email'];
        }
    }

    Email::Send($_SESSION['user']->getEmail(), $admini, $predmet, $zprava);
    array_push($_SESSION['send_email_feedback'], array(
        "message" => "Zpráva byla úspěšně předána administrátorům. V nejbližší době čekejte odpověď.",
        "alert_class" => "alert-success"
    ));
}
else {
    array_push($_SESSION['send_email_feedback'], array(
        "message" => "Zpráva nemohla být odeslána",
        "alert_class" => "alert-danger"
    ));
}
header("Location: index.php");




