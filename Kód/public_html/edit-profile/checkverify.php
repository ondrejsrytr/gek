<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include ROOT."session.php";
    include ROOT."classes/email.php";
    include ROOT."classes/db.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $code = test_input($_POST['code']);

    $dotaz = $pdo->prepare("SELECT 1 FROM Users WHERE id = ? AND email_verify_code = ?");
    $vysledek = $dotaz->execute(array($_SESSION['user']->getId(), $code));
    $overeni_ok = $dotaz->fetchColumn();

    if($overeni_ok) {
        $dotaz = $pdo->prepare("UPDATE Users SET email = ? WHERE id = ?");
        $vysledek = $dotaz->execute(array($_SESSION['new_email'], $_SESSION['user']->getId()));
        $_SESSION['user']->email = $_SESSION['new_email'];
        unset($_SESSION['new_email']);
        $arr = array("response" => "ok");
        echo json_encode($arr);
        $_SESSION['edit_profile_feedback'] = array();
        array_push($_SESSION['edit_profile_feedback'], array(
            "message" => "Email byl úspěšně změněn",
            "alert_class" => "alert-success"
        ));
    }
    else {
        $arr = array("response" => "fail");
        echo json_encode($arr);
    }

    $pdo = null; //ukončení spojení