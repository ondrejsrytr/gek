<?php
include "../head.php";
?>
<script type="text/javascript">
    //todo: pojmenovat funkci inteligentneji
    //pisu to ve dve rano, nechte me bejt
    function hodTamTenText(nazev, id) {
        document.getElementById("nazevCl").value = nazev;
        document.getElementById("idCl").value = id;
    }
</script>
<div class="container-fluid admin">
    <div class="row row-eq-height">
        <div class="col-lg-2">
            <?php include "../menu.php"; ?>
        </div>
        <div class="col-lg-10">
            <div class="col-content">
                <div class="d-flex justify-content-between align-items-baseline py-0">
                    <h4 class="my-0">Články k ohodnocení</h4>
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
                            <th>Název článku</th>
                            <th>Autor</th>
                            <th>Datum vydání</th>
                            <th>Odkaz ke stažení</th>
                        </thead>
                        <tbody>
                            <?php
                            //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                            $dotaz = "SELECT Users.id AS userid, Users.jmeno, Clanky.id, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE (Clanky.stav = 0 AND Clanky.vybrany_r = ?)";
                            $vysledek = $pdo->prepare($dotaz);
                            $vysledek->execute(array($_SESSION['user']->GetId()));
                            $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                            $pocet = $vysledek->rowCount();
                            for ($i = 0; $i < $pocet; $i++) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $result[$i]["nazev"] ?>
                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                    </td>
                                    <td>
                                        <?= $result[$i]["datum_vydani"] ?>
                                    </td>
                                    <td>
                                        <a href="/upload/<?= $result[$i]["id"] ?>.pdf" download="Clanek.pdf">Stáhnout</a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#hodnotitForm" onclick="hodTamTenText('<?= $result[$i]["nazev"] ?>', '<?= $result[$i]["id"] ?>')">Hodnotit</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal" id="hodnotitForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="../articles-all/rate.php" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hodnocení příspěvku</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="articleName">Název příspěvku</label>
                                    <input type="text" class="form-control" name="articleName" id="nazevCl" disabled>
                                    <input type="hidden" name="articleId" id="idCl">
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="aktualnost">Aktuálnost</label>
                                        <select class="custom-select" name="aktualnost">
                                            <option selected="selected">1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="originalita">Originalita</label>
                                        <select class="custom-select" name="originalita">
                                            <option selected="selected">1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="odbornost">Odbornost</label>
                                        <select class="custom-select" name="odbornost">
                                            <option selected="selected">1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="format">Formát</label>
                                        <select class="custom-select" name="format">
                                            <option selected="selected">1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="articleApproved">Schváleno</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="checkbox" class="form-control" name="articleApproved">
                                        </div>
                                    </div>
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