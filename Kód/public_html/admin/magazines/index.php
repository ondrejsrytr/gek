<?php
include "../head.php";
?>

    <div class="container-fluid admin">
        <div class="row row-eq-height">
            <div class="col-lg-2">
                <?php include "../menu.php"; ?>
            </div>
            <div class="col-lg-10">
                <div class="col-content">
                    <div class="d-flex justify-content-between align-items-baseline py-0">
                        <h4 class="my-0">Časopisy</h4>
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
                    <div class="overflow-auto">
                        <table id="main_table" class="table table-striped table-bordered overflow-auto">
                            <thead>
                            <th>Název časopisu</th>
                            <th>Číslo vydání</th>
                            <th>Vydavatel</th>
                            <th>Odkaz na stažení</th>
                            </thead>
                            <tbody>
                            <?php
                            $dotaz = "SELECT Casopisy.nazev, Casopisy.cislo_vydani, Casopisy.vydavatel, Users.id AS userid, Users.jmeno FROM Casopisy INNER JOIN Users ON Casopisy.vydavatel = Users.id";
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
                                print $result[$i]["cislo_vydani"];
                                echo '</td>';
                                echo '<td>';
                                print '
                                            <div data-tooltip-id="' . $result[$i]["userid"] . '" data-tooltip-name="' . $result[$i]["jmeno"] . '" class="html-tooltip"><a href="/user?&id=' . $result[$i]["id"] . '">' . $result[$i]["jmeno"] . '</a>
                                                <span class="tooltiptext">
                                                    <p>
                                                        <b>jmeno_uzivatele</b>
                                                        <span class="badge badge-secondary">Secondary</span><br>
                                                        <a href="mailto:toti@nepovim.cz">toti@nepovim.cz</a>
                                                    </p>
                                                </span>
                                            </div>
                                        ';
                                echo '</td>';
                                echo '<td>';
                                $ex = Functions::FindExtensionOfUploadMag($result[$i]["cislo_vydani"]);
                                echo '<a href="/upload2/'.$result[$i]["cislo_vydani"].'.'.$ex.'" download="Casopis.'.$ex.'">Stáhnout</a>';
                                echo '</td>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal" id="addNewForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="../magazines/upload.php" method="post" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nový časopis</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="articleName">Název časopisu</label>
                                        <input type="text" class="form-control" name="magName">
                                    </div>
                                    <div class="form-group">
                                        <label for="articleFile">Článek ve formátu PDF, DOC(X) nebo ZIP</label>
                                        <br />
                                        <input type="file" class="" accept=".doc,.docx,.pdf,.zip" name="magFile">
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