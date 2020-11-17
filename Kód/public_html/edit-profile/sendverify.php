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

    $key = random_int(10000, 99999);

    $dotaz = $pdo->prepare("UPDATE Users SET email_verify_code = ? WHERE id = ?");
    $vysledek = $dotaz->execute(array($key, $_SESSION['user']->getId()));

    $email = test_input($_POST['email']);

    $_SESSION['new_email'] = $email;

    Email::Send("noreply@gek.wz.cz", $email, "Potvrzení emailu", "Zde potvrzení emailu, kód ".$key);

    $pdo = null; //ukončení spojení