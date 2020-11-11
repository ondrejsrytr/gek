<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

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

<main>
    <!-- TODO: frontend -->
    <form method="POST">
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch ($chyba) {
                case 1:
                    ?>
                    <div class="container alert alert-danger" role="alert">
                        Hesla se neshoduji nebo nevyhovuji pozadavkum
                    </div>
                    <?php
                    break;
                default:
                    break;
            }
        }
        ?>
        Jmeno: <input type="text" name="username" value="<?=$_SESSION['user']->getJmeno()?>" placeholder="Jmeno"><br>
        Email: <input type="text" name="email" value="<?=$_SESSION['user']->getEmail()?>" placeholder="email"><br>
        Heslo: <input type="password" name="password" placeholder="nove heslo"><br>
        Heslo znovu: <input type="password" name="password2" placeholder="nove heslo znovu"><br>
        <input type="submit" value="Ulozit">
    </form>

</main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>
