<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include ROOT."session.php";

    if(!isset($_SESSION['user'])) {
        $_SESSION['referer'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: /login");
    }
    ?>
    <!doctype html>
    <html lang="cs">

    <head>
        <title>Podpora</title>
        <?php
        include ROOT . "layout/head.php";
        ?>
    </head>

    <body>
        <?php
        include ROOT . "layout/navbar.php";
        ?>

    <main class="container">
        <?php
        if(isset($_SESSION['send_email_feedback'])) {
            foreach ($_SESSION['send_email_feedback'] as $zprava) {
                echo '<div class="alert '.$zprava['alert_class'].' alert-dismissible fade show" role="alert">'.$zprava['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            }
            unset($_SESSION['send_email_feedback']);
        }
        ?>
        <div class="container-fluid bg-secondary text-white">
            <div class="row justify-content-md-center my-5">
                <div class="col-12 col-sm-12 col-md-7 col-lg-5 my-5">
                    <form action="send.php" method="post">
                        <div class="form-group">
                            <label for="email">Váš e-mail:</label>
                            <input maxlength="200" class="form-control" value="<?= $_SESSION['user']->getEmail() ?>" type="email" id="email" placeholder="Váš e-mail" disabled>
                        </div>

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
    </main>

        <?php
        include ROOT . "layout/footer.php";
        ?>
    </body>

    </html>
