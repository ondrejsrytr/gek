<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$register_ok = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");

    include ROOT."classes/User.php";

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $email = test_input($_POST['email']);


    if(User::register($email, $password, $username)) {
        $register_ok = true;
    }
    else {
        $register_ok = false;
    }

}
else {
    echo "Neznámá chyba";
    die();
}

define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

?>
<!doctype html>
<html lang="cs">

<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
<header>
    <?php
    include ROOT . "layout/navbar.php";
    ?>
</header>

<main class="container">
    <?php
        if($register_ok) {
    ?>
    <div class="container alert alert-success" role="alert">
        Registrace proběhla úspěšně. Nyní je potřeba ověřit váš email, proto zkontrolujte vaší emailovou schánku, kam jsme vám zaslali další instrukce.
    </div>
    <?php
        }
        else {
    ?>
            <div class="alert alert-danger" role="alert">
                Při registraci vašeho účtu nastala neznámá chybu. Zkuste to, prosím, později a pokud problém setrvá, kontaktujte správce webu.
            </div>
    <?php
        }
    ?>
</main>

<footer>
    <?php
    include ROOT . "layout/footer.php";
    ?>
</footer>
</body>

</html>

