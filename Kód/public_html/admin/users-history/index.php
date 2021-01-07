<?php
    include "../head.php";
?>
    <script>
        $(document).ready(function() {
            $('#main_table_h').DataTable( {
                "order": [[ 2, "asc" ]]
            } );
        } );
    </script>
    <div class="container-fluid admin">
        <div class="row row-eq-height">
            <div class="col-lg-2">
                <?php include "../menu.php"; ?>
            </div>
            <div class="col-lg-10">
                <div class="col-content">
                    <div class="d-flex justify-content-between align-items-baseline py-0">
                        <h4 class="my-0">Historie uživatelských akcí</h4>
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
                            <th>Jméno</th>
                            <th>Akce</th>
                            <th>Datum</th>
                            </thead>
                            <tbody>
                            <?php
                            $dotaz = "SELECT Users.jmeno, co, datum FROM Historie JOIN Users ON kdo = Users.id";
                            $vysledek = $pdo->prepare($dotaz);
                            $vysledek->execute();
                            $result = $vysledek->fetchAll(\PDO::FETCH_ASSOC);
                            $pocet = $vysledek->rowCount();
                            for ($i = 0; $i < $pocet; $i++) {
                                ?>
                                <tr>
                                    <td>
                                        <?=$result[$i]["jmeno"]?>
                                    </td>
                                    <td>
                                        <?=$result[$i]["co"]?>
                                    </td>
                                    <td>
                                        <?=Functions::DateToHtml($result[$i]["datum"])?>
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