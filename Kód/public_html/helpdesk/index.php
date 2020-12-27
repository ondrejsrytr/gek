<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";

if (!isset($_SESSION['user'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: /login");
}
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Helpdesk</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>

    <main>
        <div class="container col-md-9">
            <ul class="list-group">
                <li class="list-group-item">
                    <div>
                        <a href="#">
                            Tema</a>
                        <div class="mic-info">
                            Od: <a href="#">Uzivatel</a> dne 2.10.2020
                        </div>
                    </div>
                    <div class="comment-text my-2">
                        Telo
                    </div>
                    <div class="action">
                        <button type="button" class="btn btn-primary btn-xs" title="Edit">
                            <i class="far fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-xs" title="Approved">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>