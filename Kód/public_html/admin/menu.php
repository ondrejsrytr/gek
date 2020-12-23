<div class="col-menu">
    <ul class="nav nav-pills flex-column">
        <?php
        foreach ($_SERVER['menu'] as $polozka) {

            if(in_array($_SESSION['user']->getOpravneni(), $polozka['opravneni'])) {
                $pocet_menu = null;
                if(isset($polozka['dotaz']) && $polozka['dotaz'] != null) {
                    include ROOT."classes/db.php";
                    $dotaz = $polozka['dotaz'];
                    $vysledek = $pdo->prepare($dotaz);
                    if(isset($polozka['dotaz_execute_array']) && $polozka['dotaz_execute_array'] != null) {
                        $vysledek->execute($polozka['dotaz_execute_array']);
                    }
                    else {
                        $vysledek->execute();
                    }
                    $pocet = $vysledek->rowCount();
                    if($pocet > 0) {
                        $pocet_menu = $pocet;
                    }
                }

                if((substr($_SERVER['REQUEST_URI'], -1) == "/" && $_SERVER['REQUEST_URI'] == $polozka['url']."/") || ($_SERVER['REQUEST_URI'] == $polozka['url'])) {
                    $badge_html = '<span class="badge badge-pill badge-light">'.$pocet_menu.'</span> ';
                    echo '<li class="nav-item"><a class="nav-link active" href="'.$polozka['url'].'">'.$badge_html.$polozka['nazev'].'</a></li>';
                }
                else {
                    $badge_html = '<span class="badge badge-pill badge-primary">'.$pocet_menu.'</span> ';
                    echo '<li class="nav-item"><a class="nav-link" href="'.$polozka['url'].'">'.$badge_html.$polozka['nazev'].'</a></li>';
                }
            }
        }
        ?>
    </ul>
</div>
