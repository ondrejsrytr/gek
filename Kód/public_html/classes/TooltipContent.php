<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT."classes/User.php";
include_once ROOT."session.php";

class TooltipContent
{

    /**
     * Vygeneruje HTML kód pro tooltip podle ID uživatele
     * @param integer|$id ID uživatele
     * @return string Vrátí vygenerovaný HTML pro tooltip
     */
    public static function getTooltipForId($id) {
        include_once ROOT."classes/db.php";
        $dotaz = "SELECT jmeno, opravneni, email FROM Users WHERE id = ?";
        $vysledek = $pdo->prepare($dotaz);
        $vysledek->execute([$id]);

        $uzivatel = $vysledek->fetch();

        $pdo = null;
        return self::getTooltipContent($uzivatel['jmeno'], $uzivatel['opravneni'], $uzivatel['email']);
    }

    /**
     * Vygeneruje HTML kód pro tooltip
     * @param string|$name Jméno uživatele
     * @param string|$role Role uživatele
     * @param string|$email Email uživatele
     * @return string Vrátí vygenerovaný HTML kód se vším všudy
     */
    public static function getTooltipContent($name, $role, $email) {
        return '
            <p>
                <b>'.$name.'</b><br>
                <span class="badge '.User::getPoleOpravneni()[$role]['badge_class'].'">'.User::getPoleOpravneni()[$role]['name'].'</span><br>
                <a href="mailto:'.$email.'">'.$email.'</a>
            </p>
        ';
    }
}

//pro přímé použití s ajaxem

if(isset($_POST['user_id'])) {
    echo TooltipContent::getTooltipForId($_POST['user_id']);
}