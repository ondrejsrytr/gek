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
        $password1 = test_input($_POST['password']);
        $password2 = test_input($_POST['password2']);
        $currentpassword = test_input($_POST['current_password']);

        $_SESSION['edit_profile_feedback2'] = array(); //zde bude pole zpráv, které se předají do frontendu

        if(!password_verify($currentpassword, $_SESSION['user']->getPasswordHash())) {
            //nesouhlasí současné heslo
            array_push($_SESSION['edit_profile_feedback2'], array(
                "message" => "Vámi zadané současné heslo je nesprávné",
                "alert_class" => "alert-danger"
            ));
        }
        else {
            if($password1 == $password2) {
                if($_SESSION['user']->setHeslo($password1, $password2)) {
                    array_push($_SESSION['edit_profile_feedback2'], array(
                        "message" => "Heslo bylo úspěšně změněno",
                        "alert_class" => "alert-success"
                    ));
                }
                else {
                    array_push($_SESSION['edit_profile_feedback2'], array(
                        "message" => "Chyba při změně hesla",
                        "alert_class" => "alert-danger"
                    ));
                }

            }
            else {
                array_push($_SESSION['edit_profile_feedback2'], array(
                    "message" => "Hesla se neshodují!",
                    "alert_class" => "alert-danger"
                ));
            }
        }
    }

    header("Location: /edit-profile");