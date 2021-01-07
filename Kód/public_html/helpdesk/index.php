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
        <div class="container-fluid bg-secondary text-white">
            <div class="row justify-content-md-center my-5">
                <div class="col-12 col-sm-12 col-md-7 col-lg-5 my-5">
                    <form action="send.php" method="post">
                        <div class="form-group">
                            <label for="predmet">Předmět:</label>
                            <input maxlength="200" class="form-control" type="text" name="predmet" id="predmet" placeholder="Předmět pro příjemce">
                        </div>

                        <div class="form-group">
                            <label for="zprava">Zpráva:</label>
                            <textarea maxlength="1000" style="resize: none;" class="form-control" rows="5" name="zprava" id="zprava" placeholder="Zpráva pro příjemce. Můžete vložit max. 1000 písmen."></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Odeslat</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container col-md-9">
            <ul class="list-group">
                <?php
                include ROOT . "classes/db.php";

                $dotaz = $pdo->prepare("SELECT u.id as user_id, u.jmeno as user_jmeno, p.* FROM Helpdesk_vlakno p INNER JOIN Users u ON p.tazatel = u.id");
                $vysledek = $dotaz->execute();
                $vysledky = $dotaz->fetchAll(PDO::FETCH_ASSOC);
                foreach ($vysledky as $v) {
                ?>
                    <li class="list-group-item">
                        <div>
                            <?= $v["predmet"] ?>
                        </div>
                        <a href="<?php echo 'http://gek.wz.cz/user/?&id=' . $v['user_id']; ?>">
                            Od <?= $v["user_jmeno"] ?>
                            <?php
                            echo '<span class="badge badge-';
                            if ($v["stav"] == 0) echo 'secondary">';
                            else echo 'success">';
                            echo 'Stav</span>';
                            ?>
                        </a>
                        <div>
                            <div class="mic-info">
                                dne <?= $v["datum"] ?>
                            </div>
                        </div>
                        <div class="comment-text my-2">
                            <?= $v["obsah"] ?>
                        </div>
                        <form class="action" action="actions.php" method="post">
                            <button type="button" class="btn btn-primary btn-xs" title="Edit" data-toggle="modal" data-target="#editModal">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="submit" class="btn btn-success btn-xs" title="Approved" name="approve" value="<?php echo $v['id']; ?>">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete" name="delete" value="<?php echo $v['id']; ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </li>
                <?php
                }
                ?>
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