<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

/*
if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}

$chyba = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $password2 = test_input($_POST['password2']);
    $email = test_input($_POST['email']);

    

    //settery overuji, jestli se data neshoduji s aktualnim stavem
    $_SESSION['user']->setJmeno($username);
    if($_SESSION['user']->setHeslo($password, $password2) == false)
        $chyba = 1;
    $_SESSION['user']->setEmail($email);
}
*/
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Upravit profil</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>

<main class="container d-flex h-100 flex-column pt-5">
        <h4 class="card-title text-center mb-4 mt-1">Správa účtu</h4>
        <div class="container-fluid col-lg-8 pb-5">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card margin-bottom-20">
                        <div class="card-header">
                            Základní údaje
                        </div>
                        <div class="card-body" method="post">
                            <?php
                                if(isset($_GET['basics'])) {
                                    switch($_GET['basics']) {
                                        case 1:
                                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">Změny nemohly být uloženy, protože údaje zůstaly nepozměněné<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                            break;
                                        case 0:
                                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Změny byly úspěšně uloženy<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                            break;
                                        case 2:
                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Nastala chyba při ukládání změn<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                            break;
                                    }
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
                        <div class="card-body" method="post">
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
                                            <input id="current_password" name="current_password" class="form-control" type="password">
                                            <small id="emailHelp" class="form-text text-muted">Před změnou hesla je nutné zadat vaše aktuální heslo</small>
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
                </div>
            </div>
        </div>

</main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>
