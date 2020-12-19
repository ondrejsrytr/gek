<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/ActivityLog.php";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $recenzent_id = test_input($_POST['recenzent_id']);
    $clanek_id = test_input($_POST['clanek_id']);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('SQL_HOST', 'sql4.webzdarma.cz');
    define('SQL_DBNAME', 'gekwzcz3751');
    define('SQL_USERNAME', 'gekwzcz3751');
    define('SQL_PASSWORD', '&976l3lW9b^12.8J)ykv');

    $dsn = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . '';
    $user = SQL_USERNAME;
    $password = SQL_PASSWORD;

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Připojení k databázi selhalo: ' . $e->getMessage());
    }

    if($recenzent_id == 0) $recenzent_id = null;

    $dotaz = "UPDATE Clanky SET vybrany_r = ? WHERE id = ?";
    $vysledek = $pdo->prepare($dotaz);
    $vysledek->execute(array($recenzent_id, $clanek_id));
    ActivityLog::Log('Přiřazen recenzent '.$recenzent_id.' k článku '.$clanek_id);

    header("Location: index.php");