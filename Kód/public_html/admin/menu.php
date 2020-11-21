<?php
    //stránky
    $menu = array(
        array(
            "nazev" => "Příspěvky",
            "url" => "/admin/articles"
        ),
        array(
            "nazev" => "Uživatelé",
            "url" => "/admin/users"
        )
    );

    foreach ($menu as $polozka) {

        if($_SERVER['REQUEST_URI'] == $polozka['url']."/") {
            echo '<li class="nav-item"><a class="nav-link active" href="'.$polozka['url'].'">'.$polozka['nazev'].'</a></li>';
        }
        else {
            echo '<li class="nav-item"><a class="nav-link" href="'.$polozka['url'].'">'.$polozka['nazev'].'</a></li>';
        }
    }
?>
