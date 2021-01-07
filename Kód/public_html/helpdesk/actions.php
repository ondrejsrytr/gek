<?php
define('ROOT', '/3w/users/g/gek.wz.cz/web/');
include ROOT . 'classes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $akce = isset($_POST['approve']) ? 'approve' : 'delete';
    $id = isset($_POST['approve']) ? $_POST['approve']['value'] : $_POST['delete']['value'];
    $query = isset($_POST['approve']) ? 'UPDATE Helpdesk_vlakno SET stav=TRUE WHERE id=?' : 'DELETE FROM Helpdesk_vlakno WHERE id=?';
    $dotaz = $pdo->prepare($query);
    $vysledek = $dotaz->execute([$id]);
}
header("Location: /helpdesk");
