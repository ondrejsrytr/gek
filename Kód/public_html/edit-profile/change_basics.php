<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include_once ROOT."classes/ActivityLog.php";
    include ROOT."session.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //$email = test_input($_POST['email']);
        $username = test_input($_POST['username']);

        $_SESSION['edit_profile_feedback'] = array(); //zde bude pole zpráv, které se předají do frontendu

        //zkontrolovat, zda něco změnil
        //if($_SESSION['user']->getEmail() != $email || $_SESSION['user']->getJmeno() != $username) {
        if( $_SESSION['user']->getJmeno() != $username) {
            if($_SESSION['user']->getJmeno() != $username) {
                if(!empty($username)) {
                    if($_SESSION['user']->setJmeno($username)) {
                        array_push($_SESSION['edit_profile_feedback'], array(
                            "message" => "Uživatelské jméno bylo úspěšně změneno",
                            "alert_class" => "alert-success"
                        ));
                        ActivityLog::Log('Změna uživatelského jména');
                    }
                    else {
                        array_push($_SESSION['edit_profile_feedback'], array(
                            "message" => "Nastala neznámá chyba při změně uživatelského jména. Pokdu bude problém setrvávat, kontaktujte administrátora.",
                            "alert_class" => "alert-danger"
                        ));
                    }
                }
                else {
                    array_push($_SESSION['edit_profile_feedback'], array(
                        "message" => "Pole pro uživatelské jméno nesmí být prázdné",
                        "alert_class" => "alert-danger"
                    ));
                }
            }
            /*
            if($_SESSION['user']->getEmail() != $email) {
                if($_SESSION['user']->setEmail($email)) {
                    array_push($_SESSION['edit_profile_feedback'], array(
                        "message" => "Email byl úspěšně změněn",
                        "alert_class" => "alert-success"
                    ));
                }
                else {
                    array_push($_SESSION['edit_profile_feedback'], array(
                        "message" => "Nastala chyba při změně emailu",
                        "alert_class" => "alert-danger"
                    ));
                }
            }
            */
        }
        else {
            array_push($_SESSION['edit_profile_feedback'], array(
                "message" => "Změny nemohly být uloženy, protože žádné údaje nebyly změněny!",
                "alert_class" => "alert-warning"
            ));
        }
    }
    else {
        array_push($_SESSION['edit_profile_feedback'], array(
            "message" => "Neplatná metoda odeslání!",
            "alert_danger" => "alert-danger"
        ));
    }
    header("Location: /edit-profile");
