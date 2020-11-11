<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";

if (isset($_SESSION['user'])) {
    header("Location: /");
}
?>
<!doctype html>
<html lang="cs">

<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
<head>
    <title>Přihlášení</title>
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
                    <h4 class="card-title text-center mb-4 mt-1">Přihlášení</h4>
                    <hr>
                    <?php
                        function test_input($data) {
                            $data = trim($data);
                            $data = stripslashes($data);
                            $data = htmlspecialchars($data);
                            return $data;
                        }
                        $errorid = test_input($_GET['error']);
                        if(isset($errorid) && (int)$errorid > 0) {
                            switch($errorid) {
                                case '1':
                                    echo '<p class="text-danger">Váš email před přihlášením nejdříve ověřit. Zkontrolujte vaši emailovou schránku.</p>';
                                    break;
                                case '2':
                                    echo '<p class="text-danger">Špatný email nebo heslo. Zkuste se přihlásit znovu.</p>';
                                    break;
                            }
                        }
                    ?>
                    <form method="post" action="login.php">
                        <input type="hidden" value="<?php if(isset($_SESSION['referer'])) echo $_SESSION['referer']; ?>" name="referer">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="email" class="form-control" placeholder="Email" type="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="password" class="form-control" placeholder="Heslo" type="password"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Přihlásit se</button>
                        </div>
                        <p class="text-center"><a href="/register" class="btn">Nemáte účet?</a><br><a href="/forgot-password" class="btn">Zapomněli jste heslo?</a>
                        </p>
                    </form>
                </article>
            </div>
        </div>

        <div style="height: 16vh;"></div>
</main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>