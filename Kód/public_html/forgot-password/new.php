<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $overeno = false;

    //ověření tokenu....
?>
<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

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
<header>
    <?php
    include ROOT . "layout/navbar.php";
    ?>
</header>

<main class="container">


</main>

<footer>
    <?php
    include ROOT . "layout/footer.php";
    ?>
</footer>
</body>

</html>

