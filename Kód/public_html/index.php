<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";
include_once ROOT . "classes/Functions.php";
?>
<!doctype html>
<html lang="cs">
<head>
    <title>Hlavní stránka</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
<script>
    $(document).ready(function() {
        $('#main_table_clanky').DataTable( {
            "order": [[ 2, "asc" ]]
        } );
        $('#main_table_casopisy').DataTable( {
            "order": [[ 2, "asc" ]]
        } );
    } );
</script>
<?php
include ROOT . "layout/navbar.php";
?>


<main class="container d-flex h-100 flex-column pt-5">
    <!--<div id="article_filter" class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <input type="radio" name="options" id="option1" checked> Články
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options" id="option2"> Časopisy
        </label>
    </div> -->

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Časopisy</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Články</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <br>
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
            <table id="main_table_casopisy" class="table table-striped table-bordered">
                <thead>
                <th>Název Časopisu</th>
                <th>Vydavatel</th>
                <th>Číslo vydání</th>
                <th>Odkaz ke stažení</th>
                </thead>
                <tbody>
                <?php
                //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                $dotaz = "SELECT Casopisy.nazev, Casopisy.cislo_vydani, Casopisy.vydavatel, Users.id AS userid, Users.jmeno FROM Casopisy INNER JOIN Users ON Casopisy.vydavatel = Users.id";
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
                    //print '<a href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>'; //verze bez tooltipu
                    print '
                    <div data-tooltip-id="'.$result[$i]["userid"].'" data-tooltip-name="'.$result[$i]["jmeno"].'" class="html-tooltip"><a href="/user?&id='.$result[$i]["userid"].'">'.$result[$i]["jmeno"].'</a>
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
                    print $result[$i]["cislo_vydani"];
                    echo '</td>';
                    echo '<td>';
                    $ex = Functions::FindExtensionOfUpload($result[$i]["id"]);
                    echo '<a href="/upload/'.$result[$i]["id"].'.'.$ex.'" download="Clanek.'.$ex.'">Stáhnout</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div> <!-- PRVNI TABULKA -->

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <br>
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
            <table id="main_table_clanky" class="table table-striped table-bordered">
                <thead>
                <th>Název článku</th>
                <th>Autor</th>
                <th>Datum vydání</th>
                <th>Odkaz ke stažení</th>
                </thead>
                <tbody>
                <?php
                //SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id
                $dotaz = "SELECT Users.id, Users.jmeno, Clanky.nazev, Clanky.datum_vydani FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE Clanky.stav = 1";
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
                    //print '<a href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>'; //verze bez tooltipu
                    print '
                    <div data-tooltip-id="'.$result[$i]["id"].'" data-tooltip-name="'.$result[$i]["jmeno"].'" class="html-tooltip"><a href="/user?&id='.$result[$i]["id"].'">'.$result[$i]["jmeno"].'</a>
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
                    echo Functions::DateToHtml($result[$i]["datum_vydani"]);
                    echo '</td>';
                    echo '<td>';
                    $ex = Functions::FindExtensionOfUpload($result[$i]["id"]);
                    echo '<a href="/upload/'.$result[$i]["id"].'.'.$ex.'" download="Clanek.'.$ex.'">Stáhnout</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div> <!-- DRUHA TABULKA -->

    </div>



</main>


<?php
if(!isset($_SESSION['oznameni']) && isset($_SESSION['user']) && ($_SESSION['user']->getOpravneni() == 2 || $_SESSION['user']->getOpravneni() == 3 || $_SESSION['user']->getOpravneni() == 4)) {
    $_SESSION['oznameni'] = true;

    $notify_text = null;

    //recenzent
    if($_SESSION['user']->getOpravneni() == 2) {
        include_once ROOT."classes/db.php";
        $dotaz = "SELECT Users.id FROM Clanky INNER JOIN Users on Clanky.autor = Users.id WHERE (Clanky.stav = 0 AND Clanky.vybrany_r = ?)";
        $vysledek = $pdo->prepare($dotaz);
        $vysledek->execute(array($_SESSION['user']->GetId()));
        $pocet = $vysledek->rowCount();
        if($pocet == 0) {
            $notify_text = "Dobrý den, vypadá to, že všechny články máte ohodnocené.";
        }
        else if($pocet == 1) {
            $notify_text = "Dobrý den, v administraci máte k ohodnocení ".$pocet." článek.";
        }
        else {
            $notify_text = "Dobrý den, v administraci máte k ohodnocení ".$pocet." článků.";
        }
    }
    //redaktor, šéfredaktor
    else if($_SESSION['user']->getOpravneni() == 3 || $_SESSION['user']->getOpravneni() == 4) {
        include_once ROOT."classes/db.php";
        $dotaz = "SELECT 1 FROM Clanky INNER JOIN Users A ON Clanky.autor = A.id INNER JOIN Users B ON Clanky.vybrany_r = B.id INNER JOIN Clanky_hodnoceni ON Clanky.id = Clanky_hodnoceni.clanek WHERE Clanky.stav = 0 AND vybrany_r > 0 ";
        $vysledek = $pdo->prepare($dotaz);
        $vysledek->execute();
        $pocet = $vysledek->rowCount();
        $notify_text = "Dobrý den, v administraci ";
        if($pocet > 0) {
            if($pocet == 1) {
                $notify_text .= "vás čeká 1 článek na vydání ";
            }
            else {
                $notify_text .= $pocet."vás čeká článků na vydání ";
            }
        }
        $dotaz = "SELECT 1 FROM Clanky WHERE vybrany_r is null AND stav = 0";
        $vysledek = $pdo->prepare($dotaz);
        $vysledek->execute();
        $pocet2 = $vysledek->rowCount();
        if($pocet > 0 && $pocet2 > 0) $notify_text .= "a ";
        else if($pocet2 > 0) {
            if($pocet2 == 1) {
                $notify_text .= $pocet2." příspěvek nemá přiřazeného recenzenta";
            }
            else if($pocet2 >= 2 && $pocet2 <= 4) {
                $notify_text .= $pocet2." příspěvky nemají přiřazeného recenzenta";
            }
            else {
                $notify_text .= $pocet2." příspěvků nemají přiřazeného recenzenta";
            }

        }
    }
    $pdo = null;
    echo '
                <div class="toast" data-autohide="false">
                    <div class="toast-header">
                        <strong class="mr-auto text-primary">Oznámení</strong>
                        <!--<small class="text-muted">5 mins ago</small>-->
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">
                        '.$notify_text.'
                    </div>
                </div>
                <script>$(".toast").toast("show");</script>
            ';
}
?>


<?php
include ROOT . "layout/footer.php";
?>
</body>

</html>
