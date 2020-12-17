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
                            <th>Recenzent</th>
                            <th>Aktuálnost</th>
                            <th>Originalita</th>
                            <th>Odbornost</th>
                            <th>Format</th>
                            <th>Vydat článek</th>
                            <th>Vymazat</th>
                            <th>Přehodnocení</th>
                            </thead>
                            <tbody>
                            <?php
                            //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                            $dotaz = "SELECT A.jmeno, A.id AS userid, Clanky.id, Clanky.stav, Clanky.nazev, Clanky.datum_vydani, Clanky.vybrany_r, B.jmeno as nejakyrecenzent, Clanky_hodnoceni.aktualnost, Clanky_hodnoceni.originalita, Clanky_hodnoceni.odbornost, Clanky_hodnoceni.format FROM Clanky INNER JOIN Users A ON Clanky.autor = A.id INNER JOIN Users B ON Clanky.vybrany_r = B.id INNER JOIN Clanky_hodnoceni ON Clanky.id = Clanky_hodnoceni.clanek WHERE Clanky.stav = 0 AND vybrany_r > 0 ";
                            $vysledek = $pdo->prepare($dotaz);
                            $vysledek->execute();
                            $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                            $pocet = $vysledek->rowCount();
                            for ($i = 0; $i < $pocet; $i++) {
                                ?>
                                <tr>
                                    <td>
                                        <?=$result[$i]["nazev"]?>
                                    </td>
                                    <td>
                                        <?php
                                        print '
                                            <div data-tooltip-id="'.$result[$i]["userid"].'" data-tooltip-name="'.$result[$i]["jmeno"].'" class="html-tooltip"><a href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>
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
                                        <?=$result[$i]["datum_vydani"]?>
                                    </td>
                                    <td>
                                        <a href="/upload/<?=$result[$i]["id"]?>.pdf" download="Clanek.pdf">Stáhnout</a>
                                    </td>
                                    <td>
                                    <?=$result[$i]["nejakyrecenzent"]?>
                                    </td>
                                    <td>
                                    <?=$result[$i]["aktualnost"]?>
                                    </td>
                                    <td>
                                    <?=$result[$i]["originalita"]?>
                                    </td>
                                    <td>
                                    <?=$result[$i]["odbornost"]?>
                                    </td>
                                    <td>
                                    <?=$result[$i]["format"]?>
                                    </td>
                                    <td>
                                    <form action="vydat.php" method="post"><input type="hidden" name="clanekid" value="<?=$result[$i]['id']?>"><button type="submit">Vydat</button></form>
                                    </td>
                                    <td>
                                    <form action="smazat.php" method="post"><input type="hidden" name="clanekid" value="<?=$result[$i]['id']?>"><button type="submit">Smazat</button></form>
                                    </td>
                                    <td>
                                    <form action="prehodnotit.php" method="post"><input type="hidden" name="clanekid" value="<?=$result[$i]['id']?>"><button type="submit">Poslat k přehodnocení</button></form>
                                    </td>

                                </tr>
                                <?php
                            }
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