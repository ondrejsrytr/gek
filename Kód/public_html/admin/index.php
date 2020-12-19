<?php
include "head.php";
?>
    <div class="container admin">
        <div class="row row-eq-height">
            <div class="col-lg-3">
                <?php include "menu.php"; ?>
            </div>
            <div class="col-lg-9">
                <div class="col-content">
                    <!-- OBSAH STRÁNKY -->
                    <h4 class="my-0">Dashboard</h4>
                    <div style="height: 100px;"></div>
                    <h5>Poslední aktivita</h5>
                    <table class="pure-table">
                        <?php
                            include ROOT."classes/db.php";
                            $dotaz = $pdo->prepare("SELECT co, datum FROM Historie WHERE kdo = ? LIMIT 5");
                            $vysledek = $dotaz->execute([$_SESSION['user']->getId()]);
                            $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);
                            if($dotaz->rowCount() > 0) {
                                echo '<tr>
                                        <th>Datum</th>
                                        <th>Aktivita</th>
                                      </tr>';
                                foreach ($vysledky as $aktivita) {
                                    echo '<tr>
                                            <td>'.$aktivita['datum'].'</td>
                                            <td>'.$aktivita['co'].'</td>
                                      </tr>';
                                }
                            }
                            else {
                                echo "<p>Zatím neevidujeme žádnou vaší aktivitu</p>";
                            }

                            $pdo = null;
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include "foot.php";
?>