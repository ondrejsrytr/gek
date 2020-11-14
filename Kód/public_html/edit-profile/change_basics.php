<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include ROOT."session.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = test_input($_POST['email']);
        $username = test_input($_POST['username']);

        //zkontrolovat, zda něco změnil
        if($_SESSION['user']->getEmail() != $email || $_SESSION['user']->getJmeno() != $username) {
            $chyba = 0;
            if($_SESSION['user']->getEmail() != $email) {

                if($_SESSION['user']->setEmail($email)) {
                    $chyba = 0;
                }
                else {
                    $chyba = 2;
                }
            }
            if($_SESSION['user']->getJmeno() != $username) {
                if($_SESSION['user']->setJmeno($username)) {
                    $chyba = 0;
                }
                else {
                    $chyba = 2;
                }
            }
            header("Location: /edit-profile?&basics=".$chyba);
        }
        else {
            //uživatel nic nezměnil
            header("Location: /edit-profile?&basics=1");
        }


    }

