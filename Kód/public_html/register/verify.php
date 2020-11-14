<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $overeno = false;

    $token = test_input($_GET['token']);

    //ověřit token, zda je správný
    $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
    $stmt = $conn->prepare("SELECT Users.id FROM Tokeny JOIN Users ON Tokeny.uzivatel = Users.id WHERE Tokeny.token = ?");

    $stmt->bind_param("s", $token);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows == 0) $overeno = false;
    else {
        $row = $result->fetch_assoc();
        $userid = $row["id"];

        $stmt->close();
        $stmt = $conn->prepare("UPDATE Users SET email_verify=1 WHERE id = ?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->close();
        //pri overeni smaz token z databaze
        $stmt = $conn->prepare("DELETE FROM Tokeny WHERE uzivatel = ?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();

        $overeno = true;
    }
    $stmt->close();
    $conn->close();
?>
<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include ROOT."session.php";

?>
<!doctype html>
<html lang="cs">

<head>
    <title>Ověření emailu</title>
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
        if($overeno) {
    ?>
        <div class="container-fluid d-flex h-100 flex-column pt-5">
            <div class="container alert alert-success" role="alert">
                Ověření emailu bylo provedeno úspěšně. <a href="/login">Nyní se můžete přihlásit</a>.
            </div>
        </div>
    <?php
        }
        else {
    ?>
        <div class="container-fluid d-flex h-100 flex-column pt-5">
            <div class="alert alert-danger" role="alert">
                Ověření emailu se nezdařilo. V případě problémů kontaktujte správce.
            </div>
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

