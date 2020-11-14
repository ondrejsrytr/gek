<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";


if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Nastavení účtu</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
    <?php
        //pokud se vrátíme ze scriptu deleteaccount.php, tak znovu vyvoláme dialog a oznámíme uživateli nějakou nesrovnalost
        if(isset($_SESSION['delete_account_feedback'])) {
            echo '<script>$( document ).ready(function() { $("#deleteaccount").modal() });</script>';
        }
    ?>
</head>

<body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>
    <div class="jumbotron jumbotron-fluid" style="margin-bottom: 0px;">
        <div class="container">
            <h1 class="display-4">Nastavení účtu</h1>
            <!--<p class="lead" style="/*! displaY: none; */">Tato stránka vám umožní nastavit váš účet podle vašich představ</p>-->
        </div>
    </div>
    <main class="container d-flex h-100 flex-column pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card margin-bottom-20">
                    <div class="card-header">
                        Základní údaje
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($_SESSION['edit_profile_feedback'])) {
                            foreach ($_SESSION['edit_profile_feedback'] as $zprava) {
                                echo '<div class="alert '.$zprava['alert_class'].' alert-dismissible fade show" role="alert">'.$zprava['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            }
                            unset($_SESSION['edit_profile_feedback']);
                        }
                        ?>

                        <form action="change_basics.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Vaše jméno</label>
                                        <input id="username" name="username" value="<?=$_SESSION['user']->getJmeno()?>" class="form-control" type="text" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Emailová adresa</label>
                                        <input id="email" name="email" value="<?=$_SESSION['user']->getEmail()?>" class="form-control" placeholder="Email" type="email" required>
                                        <small class="form-text text-muted">V případě změny emailové adresy bude nutné opakované ověření</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Uložit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card margin-bottom-20">
                    <div class="card-header">
                        Změna hesla
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($_SESSION['edit_profile_feedback2'])) {
                            foreach ($_SESSION['edit_profile_feedback2'] as $zprava) {
                                echo '<div class="alert '.$zprava['alert_class'].' alert-dismissible fade show" role="alert">'.$zprava['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            }
                            unset($_SESSION['edit_profile_feedback2']);
                        }
                        ?>
                        <form action="change_password.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Nové heslo</label>
                                        <input id="password" name="password" class="form-control" type="password" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password2">Nové heslo znovu</label>
                                        <input id="password2" name="password2" class="form-control" type="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_password">Současné heslo</label>
                                        <input id="current_password" name="current_password" class="form-control" type="password" required>
                                        <!--<small class="form-text text-muted">Před změnou hesla je nutné zadat vaše aktuální heslo</small>-->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Změnit heslo</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card margin-bottom-20">
                    <div class="card-header">
                        Další akce
                    </div>
                    <div class="card-body" method="post">
                        <div class="form-group">
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteaccount">Smazat účet</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal" id="deleteaccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="modal-dialog modal-dialog-centered" method="post" action="deleteaccount.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vyžadováno ověření</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                        if(isset($_SESSION['delete_account_feedback'])) {
                            foreach ($_SESSION['delete_account_feedback'] as $zprava) {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$zprava.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            }
                            unset($_SESSION['delete_account_feedback']);
                        }
                    ?>
                    <div class="form-group">
                        <p>Pro tuto akci je nutné zadat vaše heslo:</p>
                        <input id="current_password" name="current_password" class="form-control" type="password" required>
                    </div>
                    <div class="form-group form-check">
                        <input value="true" name="delete_accept" type="checkbox" class="form-check-input" id="delete_accept">
                        <label class="form-check-label" for="delete_accept">Jsem si vědom/á toho, že tato akce je nevratná a veškeré mé aktivity budou smazány</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Zpět</button>
                    <button type="submit" class="btn btn-danger">Smazat účet</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>
