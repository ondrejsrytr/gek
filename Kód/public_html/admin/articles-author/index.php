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
                        <h4 class="my-0">Vaše příspěvky</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addNewForm">Přidat nový</button>
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
                        <th>Hodnotitel</th>
                        <th>Datum ohodnocení</th>
                        <th>Aktuálnost</th>
                        <th>Originalita</th>
                        <th>Odbornost</th>
                        <th>Formát</th>
                        </thead>
                        <tbody>
                        <?php
                        //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                        $dotaz = "SELECT Clanky.nazev, B.id AS userid, B.jmeno as hodnotitel, datum_ohodnoceni, aktualnost, originalita, odbornost, format FROM Clanky_hodnoceni JOIN Clanky ON Clanky_hodnoceni.clanek = Clanky.id JOIN Users B ON Clanky_hodnoceni.hodnotitel = B.id WHERE Clanky.autor = ?;";
                        $vysledek = $pdo->prepare($dotaz);
                        $vysledek->execute(array($_SESSION['user']->getId()));
                        $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                        $pocet = $vysledek->rowCount();
                        for ($i = 0; $i < $pocet; $i++) {
                            echo '<tr>';
                            echo '<td>';
                            print $result[$i]["nazev"];
                            echo '</td>';
                            echo '<td>';
                            print '<a target="blank" href="/user?&id='.$result[$i]["userid"].'">'.$result[$i]["hodnotitel"].'</a>';
                            echo '</td>';
                            echo '<td>';
                            print $result[$i]["datum_ohodnoceni"];
                            echo '</td>';
                            echo '<td>';
                            echo $result[$i]["aktualnost"];
                            echo '</td>';
                            echo '<td>';
                            echo $result[$i]["originalita"];
                            echo '</td>';
                            echo '<td>';
                            echo $result[$i]["odbornost"];
                            echo '</td>';
                            echo '<td>';
                            echo $result[$i]["format"];
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal" id="addNewForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="../articles-author/upload.php" method="post" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nový příspěvek</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="articleName">Název příspěvku</label>
                                        <input type="text" class="form-control" name="articleName">
                                    </div>
                                    <div class="form-group">
                                        <label for="articleFile">Článek ve formátu PDF nebo DOC(X)</label>
                                        <br />
                                        <input type="file" class="" name="articleFile">
                                    </div>
                                    <div class="form-group">
                                        <label for="articleName">Tématické číslo časopisu</label>
                                        <select class="custom-select">
                                            <option selected="selected">nevybráno</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Zavřít</button>
                                    <button type="submit" class="btn btn-primary">Uložit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include "../foot.php";
?>