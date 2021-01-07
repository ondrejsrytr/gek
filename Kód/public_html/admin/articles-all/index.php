<?php
include "../head.php";
?>
<div class="container-fluid admin">
    <div class="row">
        <div class="col-lg-2">
            <?php include "../menu.php"; ?>
        </div>
        <div class="col-lg-10">
            <div class="col-content">
                <div class="d-flex justify-content-between align-items-baseline py-0">
                    <h4 class="my-0">Příspěvky</h4>
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
                            <th>Tématické číslo časopisu</th>
                            <th>Recenzent</th>
                        </thead>
                        <tbody>
                            <?php
                            //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                            $dotaz = "SELECT Users.id AS userid, Users.jmeno, Clanky.id, Clanky.nazev, Clanky.datum_vydani, Clanky.tematicky_casopis, vybrany_r FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE Clanky.stav = 0";
                            $vysledek = $pdo->prepare($dotaz);
                            $vysledek->execute();
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
                                            <div data-tooltip-id="' . $result[$i]["userid"] . '" data-tooltip-name="' . $result[$i]["jmeno"] . '" class="html-tooltip"><a href="/user?&id=' . $result[$i]["userid"] . '">' . $result[$i]["jmeno"] . '</a>
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
                                        <?= Functions::DateToHtml($result[$i]["datum_vydani"]) ?>
                                    </td>
                                    <td>
                                        <?php
                                            $ex = Functions::FindExtensionOfUpload($result[$i]["id"]);
                                        ?>
                                        <a href="/upload/<?= $result[$i]["id"] ?>.<?= $ex ?>" download="Clanek.<?= $ex ?>">Stáhnout</a>
                                    </td>
                                    <td>
                                        <?php
                                            if($result[$i]["tematicky_casopis"] != null) {
                                                echo $result[$i]["tematicky_casopis"];
                                            }
                                            else {
                                                echo "Nevybráno";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $opravneni = "2";
                                        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
                                        $stmt = $conn->prepare("SELECT id, jmeno FROM Users WHERE opravneni = ?");


                                        $stmt->bind_param("i", $opravneni);
                                        $stmt->execute();

                                        $r_result = $stmt->get_result();

                                        echo '<form action="recenzent_change.php" method="post" class="auto-submit">';
                                        echo "<input type='hidden' name='clanek_id' value='" . $result[$i]['id'] . "'>";
                                        echo '<select class="form-control" name="recenzent_id">';
                                        echo '<option value="0">Nevybrán</option>';
                                        while ($row = $r_result->fetch_assoc()) {
                                            if ($result[$i]['vybrany_r'] == $row['id']) {
                                                echo '<option selected value="' . $row['id'] . '">' . $row['jmeno'] . '</option>';
                                            } else {
                                                echo '<option value="' . $row['id'] . '">' . $row['jmeno'] . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        echo '</form>';

                                        $stmt->close();
                                        $conn->close();
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            $pdo = null;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../foot.php";
?>