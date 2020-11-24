<div class="col-menu">
    <ul class="nav nav-pills flex-column">
        <?php
        foreach ($_SERVER['menu'] as $polozka) {

            if(in_array($_SESSION['user']->getOpravneni(), $polozka['opravneni'])) {
                //if($_SERVER['REQUEST_URI'] == $polozka['url']."/") {
                if(strpos($_SERVER['REQUEST_URI'], $polozka['url']) !== false) {
                    echo '<li class="nav-item"><a class="nav-link active" href="'.$polozka['url'].'">'.$polozka['nazev'].'</a></li>';
                }
                else {
                    echo '<li class="nav-item"><a class="nav-link" href="'.$polozka['url'].'">'.$polozka['nazev'].'</a></li>';
                }
            }
        }
        ?>
    </ul>
</div>
