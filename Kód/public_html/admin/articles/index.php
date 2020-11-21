<?php
    include "../head.php";
?>
    <!-- SOUPCE STRÁNKY -->
    <div class="container-fluid row mx-5 mt-4">
        <div class="col-sm-2 mx-4">
            <ul class="nav nav-pills flex-column">
                <?php include "../menu.php"; ?>
            </ul>
        </div>
        <div class="col-sm-8">
            <div class="d-flex justify-content-between align-items-baseline py-0">
                <h4 class="my-0">Vaše příspěvky</h4>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addNewForm">Přidat nový</button>
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
                            $dotaz = "SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id";
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
                                print $result[$i]["jmeno"];
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
            </div>
        </div>
    </div>
    <!-- ///SOUPCE STRÁNKY -->
    <div class="modal" id="addNewForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nový příspěvek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="articleName">Název příspěvku</label>
                            <input type="text" class="form-control" id="articleName">
                        </div>
                        <div class="form-group">
                            <label for="articleFile">Článek ve formátu PDF nebo DOC(X)</label>
                            <br />
                            <input type="file" class="" id="articleFile">
                        </div>
                        <div class="form-group">
                            <label for="articleName">Tématické číslo časopisu</label>
                            <select class="custom-select">
                                <option selected="selected">nevybráno</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Zavřít</button>
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </div>
        </div>
    </div>
<?php
include "../foot.php";
?>