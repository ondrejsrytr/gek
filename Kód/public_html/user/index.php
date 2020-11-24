<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include ROOT."session.php";

    /*
    if(!isset($_SESSION['user'])) {
        $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: /login");
    }
    */

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $nalezenuser = false;

    $userid = test_input($_GET['id']);

    if(empty($userid)) {
        $nalezenuser = false;
    }
    else {
        include ROOT."classes/db.php";

        $dotaz = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
        $vysledek = $dotaz->execute(array($userid));
        $uzivatel = $dotaz->fetch();

        if((int)$uzivatel['id'] > 0) {
            $nalezenuser = true;
        }
        else {
            $nalezenuser = false;
        }
    }



    ?>
<!DOCTYPE html>
    <html lang="cs">

    <head>
        <title>Detail uživatele<?php if($nalezenuser) echo ' - '.$uzivatel['jmeno'].''; ?></title>
        <?php
        include ROOT . "layout/head.php";
        ?>
    </head>

    <body>
        <?php
        include ROOT . "layout/navbar.php";
        ?>

    <main>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Detail uživatele</h1>
            </div>
        </div>
        <div class="container">
            <?php
                if($nalezenuser) {
            ?>
            <h2><?= $uzivatel['jmeno'] ?> <span class="badge badge-pill <?= $_SESSION['user']::getPoleOpravneni()[$uzivatel['opravneni']]["badge_class"] ?>"><?= $_SESSION['user']->getPoleOpravneni()[$uzivatel['opravneni']]["name"] ?></span></h2>
            <p></p>
            <p>
                Email: <a href="mailto:<?= $uzivatel['email'] ?>"><?= $uzivatel['email'] ?></a><br>
                Stav účtu:
                <?php
                    if($uzivatel['opravneni'] == "-1") {
                        echo "deaktivovaný";
                    }
                    else {
                        if($uzivatel['email_verify'] == 1) {
                            echo "OK (email ověřen)";
                        }
                        else {
                            echo "OK";
                        }
                    }

                ?>
            </p>
            <?php
                }
            else {
            ?>
                <h2>Uživatel nenalezen</h2>
            <?php
            }
            ?>
        </div>
    </main>

        <?php
        include ROOT . "layout/footer.php";
        ?>
    </body>

    </html>
