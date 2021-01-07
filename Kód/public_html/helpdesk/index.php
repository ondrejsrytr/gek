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
                        <button type="button" class="btn btn-primary btn-xs" title="Edit" data-toggle="modal" data-target="#editModal">
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
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Odpovědět</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <textarea class="form-control" rows="3"></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                        <button type="button" class="btn btn-primary">Odeslat</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
</body>

</html>