<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT . "classes/User.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = test_input($_POST['email']);

        //nejprve se ujistit, zda existuje
        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
        $stmt = $conn->prepare("SELECT id FROM Users WHERE email = ?");

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        if ($result->num_rows == 0) {
            //neexistuje, vrátit se zpět
            header("Location: /forgot-password?error=1");
        }
        else {
            $row = $result->fetch_assoc();
            //kód na odeslání emailu......

            User::send_reset($email, $row['id']);
            header("Location: /forgot-password?success");

            //informování uživatele, že jsme mu to v pořádku odeslali
        }
    }