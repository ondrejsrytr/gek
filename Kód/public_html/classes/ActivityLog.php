<?php
    define('ROOT', "/3w/users/g/gek.wz.cz/web/");
    include_once ROOT."classes/User.php";
    include ROOT."session.php";

    class ActivityLog {
        /**
         * Zalogování libovolné aktivity
         * @param string|$activity Název aktivity
         */
        public static function Log($activity) {
            include ROOT."classes/db.php";

            $dotaz = "INSERT INTO Historie (kdo, co) VALUES (?,?)";
            $vysledek = $pdo->prepare($dotaz);
            $vysledek->execute([$_SESSION['user']->GetId(), $activity]);
        }
    }