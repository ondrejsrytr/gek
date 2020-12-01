<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/db.php";
    include_once ROOT."classes/User.php";
    include ROOT."session.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id = test_input($_POST['id']);

    $dotaz = "DELETE FROM Users WHERE id = ?";
    $vysledek = $pdo->prepare($dotaz);
    $vysledek->execute(array($id));

    header("Location: index.php");