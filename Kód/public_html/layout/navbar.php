<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include_once ROOT . "session.php";
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container container-wide">

            <a class="navbar-brand" href="/">
                <img src="/gek.png" width="30" height="30" alt="">
                Gek
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if ($_SESSION['user'] != null) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Administrace</a>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_SESSION['user']->getJmeno() ?> <span class="badge badge-pill <?= $_SESSION['user']::getPoleOpravneni()[$_SESSION['user']->getOpravneni()]["badge_class"] ?>"><?= User::getPoleOpravneni()[$_SESSION['user']->getOpravneni()]["name"] ?></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="profile">
                                <a class="dropdown-item" type="button" href="/edit-profile">Nastavení účtu</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" type="button" href="/helpdesk">Helpdesk</a>
                                <a class="dropdown-item" type="button" href="/support">Podpora</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" type="button" href="/logout">Odhlásit se</a>
                            </div>
                        </li>
                        <?php
                    }
                    else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Přihlášení</a>
                        </li>
                    <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>
</header>