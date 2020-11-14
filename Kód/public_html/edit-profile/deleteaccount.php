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
        $password = test_input($_POST['current_password']);
        $_SESSION['delete_account_feedback'] = array();

        //zadal správné heslo?
        if(!password_verify($password, $_SESSION['user']->getPasswordHash())) {
            array_push($_SESSION['delete_account_feedback'], "Vámi zadané současné heslo je nesprávné");
            header("Location: /edit-profile");
        }
        else {
            //odsouhlasil to?
            if (isset($_POST['delete_accept']) && $_POST['delete_accept'] == 'true') {
                define('SQL_HOST', 'sql4.webzdarma.cz');
                define('SQL_DBNAME', 'gekwzcz3751');
                define('SQL_USERNAME', 'gekwzcz3751');
                define('SQL_PASSWORD', '&976l3lW9b^12.8J)ykv');

                $dsn = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . '';
                $user = SQL_USERNAME;
                $password = SQL_PASSWORD;

                try {
                    $pdo = new PDO($dsn, $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die('Connection failed: ' . $e->getMessage());
                }

                //smazat z tabulky Users
                $dotaz = $pdo->prepare("DELETE FROM Users WHERE id = ?");
                $vysledek = $dotaz->execute(array($_SESSION['user']->getId()));
                //smazat tokeny vytvořené pod jeho ID
                $dotaz = $pdo->prepare("DELETE FROM Tokeny WHERE uzivatel = ?");
                $vysledek = $dotaz->execute(array($_SESSION['user']->getId()));

                $pdo = null; // ukončení spojení (je to divné, já vím, ale prý to tak má být)
                header("Location: /logout"); //a hotovo
            }
            else {
                array_push($_SESSION['delete_account_feedback'],  "Je to nutné souhlasit s následky smazáním účtu");
                header("Location: /edit-profile");
            }
        }


    }