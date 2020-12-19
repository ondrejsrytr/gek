<div class="col-menu">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <?php
                if((substr($_SERVER['REQUEST_URI'], -1) == "/" && $_SERVER['REQUEST_URI'] == "/admin/") || ($_SERVER['REQUEST_URI'] == "/admin")) {
                    echo '<a class="nav-link active" href="/admin">Dashboard</a>';
                }
                else {
                    echo '<a class="nav-link" href="/admin">Dashboard</a>';
                }
            ?>

        </li>
        <?php
        foreach ($_SERVER['menu'] as $polozka) {

            if(in_array($_SESSION['user']->getOpravneni(), $polozka['opravneni'])) {
                if((substr($_SERVER['REQUEST_URI'], -1) == "/" && $_SERVER['REQUEST_URI'] == $polozka['url']."/") || ($_SERVER['REQUEST_URI'] == $polozka['url'])) {
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
