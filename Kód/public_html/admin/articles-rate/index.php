<?php
include "../head.php";
?>

    <div class="container admin">
        <div class="row row-eq-height">
            <div class="col-lg-3">
                <?php include "../menu.php"; ?>
            </div>
            <div class="col-lg-9">
                <div class="col-content">
                    <div class="d-flex justify-content-between align-items-baseline py-0">
                        <h4 class="my-0">Příspěvky k ohodnocení</h4>
                    </div>
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
                        $dotaz = "SELECT Users.id AS userid, Users.jmeno, Clanky.id, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id";
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
                            print '<a target="blank" href="/user?&id='.$result[$i]["userid"].'">'.$result[$i]["jmeno"].'</a>';
                            echo '</td>';
                            echo '<td>';
                            print $result[$i]["datum_vydani"];
                            echo '</td>';
                            echo '<td>';
                            echo '<a href="/upload/'.$result[$i]["id"].'.pdf" download="Clanek.pdf">Stáhnout</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "../foot.php";
?>