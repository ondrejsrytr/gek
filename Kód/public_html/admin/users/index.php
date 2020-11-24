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
                    <!-- OBSAH STRÁNKY -->
                    <h4>Uživatelé</h4>
                    <script>
                        $(document).ready(function () {
                            $('#table_of_users').DataTable( {
                                "order": [[ 0, "asc" ]]
                            });
                        });
                    </script>
                    <table id="table_of_users" class="table table-striped table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Email</th>
                        <th></th>
                        </thead>
                        <tbody>
                        <?php
                        include_once ROOT."classes/db.php";
                        $dotaz = "SELECT * FROM Users";
                        $vysledek = $pdo->prepare($dotaz);
                        $vysledek->execute();
                        $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                        $pocet = $vysledek->rowCount();
                        for ($i = 0; $i < $pocet; $i++) {
                            echo '<tr>';
                            echo '<td>';
                            print $result[$i]["id"];
                            echo '</td>';
                            echo '<td>';
                            print '<a target="blank" href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>';
                            echo '</td>';
                            echo '<td>';
                            print $result[$i]["email"];
                            echo '</td>';
                            echo '<td>';
                            if($result[$i]["id"] != $_SESSION['user']->getId()) echo '<div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akce</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Změnit údaje</a><a class="dropdown-item text-danger" href="#">Smazat</a></div></div>';
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