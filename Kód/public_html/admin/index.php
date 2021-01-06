<?php
include "head.php";
?>
<div class="container-fluid admin">
    <div class="row">
        <div class="col-lg-2">
            <?php include "menu.php"; ?>
        </div>
        <div class="col-lg-10">
            <div class="col-content">
                <!-- OBSAH STRÁNKY -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="jumbotron bg-white py-0 px-0">
                                <h1 class="display-4">Projekt GEK – časopisy a články</h1>
                                <p>Tento projekt byl vytvořen studenty Lukáš Smaženka, Ondřej Šrytr, František Bartuněk, Milan Zatloukal, Dmytro Radchuk v rámci předmětu ŘSP – Řízení softwarových projektů</p>
                                <hr class="my-4">
                                <h3>Instrukce pro autory:</h3>
                                <p>Autoří zasílají své příspěvky do redakce časopisu pomocí formuláře v levém menu. Ty musí být ve shodě s Pokyny pro autory:</p>
                                <a href="//www.vspj.cz/soubory/download/id/7344">Stáhnout pokyny</a> a ve formátu, požadovaném šablonou <a href="//www.vspj.cz/soubory/download/id/4186L">Stáhnout šablonu</a> <br><br>
                                    <hr class="my-4">
                                    <h3>Redakční rada</h3>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5>Recenzenti:</h5>
                                            <?php
                                            include ROOT . "classes/db.php";
                                            $dotaz = $pdo->prepare("SELECT id, jmeno FROM Users WHERE opravneni = ?");
                                            $vysledky = $dotaz->execute([2]);
                                            $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($vysledky as $user) {
                                                print '
                                        <div data-tooltip-id="' . $user['id'] . '" class="html-tooltip"><a href="/user?&id=' . $user["id"] . '">' . $user["jmeno"] . '</a>
                                            <span class="tooltiptext">
                                                <p>
                                                    <b>jmeno_uzivatele</b>
                                                    <span class="badge badge-secondary">Secondary</span><br>
                                                    <a href="mailto:toti@nepovim.cz">toti@nepovim.cz</a>
                                                </p>
                                            </span>
                                        </div>
                                        <br>
                                    ';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Redaktoři:</h5>
                                            <?php
                                            $dotaz = $pdo->prepare("SELECT id, jmeno FROM Users WHERE opravneni = ?");
                                            $vysledky = $dotaz->execute([3]);
                                            $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($vysledky as $user) {
                                                print '
                                            <div data-tooltip-id="' . $user['id'] . '" class="html-tooltip"><a href="/user?&id=' . $user["id"] . '">' . $user["jmeno"] . '</a>
                                                <span class="tooltiptext">
                                                </span>
                                            </div>
                                            <br>
                                        ';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Šéfredaktoři:</h5>
                                            <?php
                                            $dotaz = $pdo->prepare("SELECT id, jmeno FROM Users WHERE opravneni = ?");
                                            $vysledky = $dotaz->execute([4]);
                                            $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($vysledky as $user) {
                                                print '
                                            <div data-tooltip-id="' . $user['id'] . '" class="html-tooltip"><a href="/user?&id=' . $user["id"] . '">' . $user["jmeno"] . '</a>
                                                <span class="tooltiptext">
                                                </span>
                                            </div>
                                            <br>
                                        ';
                                            }
                                            ?>
                                        </div>
                                    </div>



                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h3>Vaše poslední aktivita</h3>
                            <br>
                            <table class="table table-striped">
                                <?php
                                include ROOT . "classes/db.php";
                                $dotaz = $pdo->prepare("SELECT co, datum FROM Historie WHERE kdo = ? LIMIT 5");
                                $vysledek = $dotaz->execute([$_SESSION['user']->getId()]);
                                $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);
                                if ($dotaz->rowCount() > 0) {
                                    echo '<thead><tr>
                                <th>Datum</th>
                                <th>Aktivita</th>
                                </tr></thead>';
                                    foreach ($vysledky as $aktivita) {
                                        echo '<tr>
                                    <td>' . Functions::DateToHtml($aktivita['datum']) . '</td>
                                    <td>' . $aktivita['co'] . '</td>
                                </tr>';
                                    }
                                } else {
                                    echo "<p>Zatím neevidujeme žádnou vaší aktivitu</p>";
                                }

                                $pdo = null;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
include "foot.php";
?>