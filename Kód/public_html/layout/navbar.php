<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include_once ROOT . "session.php";
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

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

                        <li class="nav-item">
                            <a class="nav-link" href="/helpdesk">Helpdesk</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item">
                        <?php
                        if ($_SESSION['user'] != null) {
                            ?>
                            <span class="nav-link"><a href="/edit-profile"><?= $_SESSION['user']->getJmeno() ?></a> (<a
                                        href="/logout">Odhlásit se</a>)</span>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link" href="/login">Přihlášení</a>
                            <?php
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>