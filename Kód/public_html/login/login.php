<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        define('ROOT', "/3w/users/g/gek.wz.cz/web/");

        include ROOT."classes/User.php";

        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);

        $tmp_usr = false;
        $tmp_usr = User::login($email, $password);

        if($tmp_usr != false || $tmp_usr != NULL) {
            if($tmp_usr->getEmailVerify() === 0) {
                header("Location: /login?&error=1"); //lenoch si ještě neotevřel email a nerozklikl odkaz v něm
            }
            else {
                session_start();
                $_SESSION['user'] = $tmp_usr;
                if(isset($_POST['referer'])) {
                    //zajistit po úspěšném přihlášení návrat na stránku, kterou původně uživatel navštívil
                    if(strpos($_POST['referer'], "gek.wz.cz") !== false) {
                        header("Location: http://".$_POST['referer']); //kontrola, pokud je to skutečně naše doména
                    }
                    else {
                        header("Location: /");
                    }
                }
                else {
                    header("Location: /");
                }
            }
        }
        else {
            header("Location: /login?&error=2"); //vrátit se na stránku přihlášení a vzkázat uživateli, že jeho zadané údaje jsou neplatné
        }
    }
    else {
        echo "Neznámá chyba"; //nějaký "hacker" si hraje?
        die();
    }