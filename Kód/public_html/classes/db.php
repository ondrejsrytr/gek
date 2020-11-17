<?php
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
        die('Connection failed: ' . $e->getMessage());
    }