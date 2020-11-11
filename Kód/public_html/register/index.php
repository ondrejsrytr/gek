<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

if(isset($_SESSION['user'])) {
    header("Location: /");
}
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Registrace</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>


<main>
    <div class="container-fluid d-flex h-100 flex-column pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="card">
                <article class="card-body">
                    <h4 class="card-title text-center mb-4 mt-1">Registrace</h4>
                    <hr>
                    <form method="post" action="register.php">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="email" class="form-control" placeholder="E-mail" type="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="username" class="form-control" placeholder="Jméno" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="password" class="form-control" placeholder="Heslo" type="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="password2" class="form-control" placeholder="Heslo pro ověření" type="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Registovat</button>
                        </div>
                        <p class="text-center"><a href="/login" class="btn">Už máte účet?</a></p>
                    </form>
                </article>
            </div>
        </div>
    </div>

    <div style="height: 16vh;"></div>
</main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>