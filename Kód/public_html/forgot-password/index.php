<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";

/*
if(!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}
*/
?>

<!doctype html>
<html lang="cs">

<head>
    <title>Zapomenuté heslo</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
<?php
include ROOT . "layout/navbar.php";
?>

<main>
    <?php
    if (isset($_GET['success'])) {
        ?>
        <div class="container-fluid d-flex h-100 flex-column pt-5">
            <div class="row justify-content-center align-items-center">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">Zapomenuté heslo</h4>
                        <hr>
                        <div class="alert alert-success" role="alert">
                            Na váš email byl zaslán odkaz pro obnovení hesla.
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="container-fluid d-flex h-100 flex-column pt-5">
            <div class="row justify-content-center align-items-center">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">Zapomenuté heslo</h4>
                        <hr>
                        <form method="post" action="reset.php">
                            <p>Zadajte email účtu, ke kterému jste zapomněli heslo</p>
                            <?php
                                if($_GET['error'] == 1) {
                                    echo '<p class="text-danger">Litujeme, ale vámi zadaný email jsme nedohledali v naší databázi.</p>';
                                }
                            ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="email" class="form-control" placeholder="E-mail" type="email"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Pokračovat</button>
                            </div>
                        </form>
                    </article>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</main>

<?php
include ROOT . "layout/footer.php";
?>
</body>

</html>
