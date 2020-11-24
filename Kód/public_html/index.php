<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";
?>
<!doctype html>
<html lang="cs">

    <head>
        <title>Hlavní stránka</title>
        <?php
        include ROOT . "layout/head.php";
        ?>
    </head>

    <body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>


    <main class="container d-flex h-100 flex-column pt-5">
        <div id="article_filter" class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" checked> Články
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2"> Časopisy
            </label>
        </div>
        <br>
        <?php //Vypsání datatables
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
        ?>
        <table id="main_table" class="table table-striped table-bordered">
            <thead>
            <th>Název článku</th>
            <th>Autor</th>
            <th>Datum vydání</th>
            <th>Odkaz ke stažení</th>
            </thead>
            <tbody>
            <?php
            //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
            $dotaz = "SELECT Users.id, Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id";
            $vysledek = $pdo->prepare($dotaz);
            $vysledek->execute();
            $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
            $pocet = $vysledek->rowCount();
            for ($i = 0; $i < $pocet; $i++) {
                echo '<tr>';
                echo '<td>';
                print $result[$i]["nazev"];
                echo '</td>';
                echo '<td>';
                print '<a target="blank" href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>';
                echo '</td>';
                echo '<td>';
                print $result[$i]["datum_vydani"];
                echo '</td>';
                echo '<td>';
                echo "Odkaz zde"; //TODO
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
    </body>

</html>
