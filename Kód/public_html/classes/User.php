<?php

// trida je nedokoncena, nektere casti (okomentovane "TO DO") je potreba doplnit

class User
{
    public $id;
    public $jmeno;
    public $opravneni;
    public $email;
    public $emailverify;

    public function __construct($id, $jmeno, $opravneni, $email, $emailverify)
    {
        $this->id = $id;
        $this->jmeno = $jmeno;
        $this->opravneni = $opravneni;
        $this->email = $email;
        $this->emailverify = $emailverify;
    }

    public static function getPoleOpravneni() {
        return array(
            0 => [
                "name" => "Uživatel",
                "badge_class" => "badge-secondary"
            ],
            1 => [
                "name" => "Recenzent",
                "badge_class" => "badge-info"
            ],
            2 => [
                "name" => "Redaktor",
                "badge_class" => "badge-warning"
            ],
            3 => [
                "name" => "Šéfredaktor",
                "badge_class" => "badge-danger"
            ],
            4 => [
                "name" => "Administrátor",
                "badge_class" => "badge-dark"
            ]
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getJmeno()
    {
        return $this->jmeno;
    }

    public function getOpravneni()
    {
        return $this->opravneni;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailVerify() {
        return $this->emailverify;
    }

    //vsechny settery vraci true nebo false, jestli byla provedena zmena
    //settery vraci true i pokud navrhovana zmena odpovida aktualni hodnote
    //settery overuji, jestli navrhovana zmena neni identicka s aktualnim stavem
    public function setJmeno($nJmeno) {
        if($nJmeno == $this->jmeno || $nJmeno == '')
            return true;
        try {
            $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
            if ($conn->connect_errno) {
                throw new Exception("Selhalo připojení do databáze");
            }
            $stmt = $conn->prepare("UPDATE Users SET jmeno = ? WHERE id = ?");
            $stmt->bind_param("si", $nJmeno, $this->id);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();
            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }

            $stmt->close();
            $conn->close();

            $this->jmeno = $nJmeno;
            return true;
        } catch (Exception $e) {
            if ($stmt) {
                $stmt->close();
            }
            die($e->getMessage());
        }
    }

    //mozna TODO: zmena emailu nastavi opravneni na 0 a vyzada opetovnou aktivaci uctu
    public function setEmail($nEmail) {
        if($nEmail == $this->jmeno || $nEmail == '')
            return true;
        try {
            $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');

            //overeni, jestli ucet s timto emailem jiz existuje
            $stmt = $conn->prepare("SELECT email FROM Users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $nEmail);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();
            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }
            if ($stmt->get_result()->num_rows) {
                $stmt->close();
                $conn->close();
                return false;
            }

            $stmt->close();
            $stmt = $conn->prepare("UPDATE Users SET email = ?, email_verify = 0 WHERE id = ?");
            $stmt->bind_param("si", $nEmail, $this->id);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();
            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }

            $stmt->close();

            $token = self::gen_token();
            $stmt = $conn->prepare("INSERT INTO Tokeny (token, uzivatel, ucel) VALUES (?, ?, 1)");
            $stmt->bind_param("ss", $token, $this->id);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            self::send_verify($nEmail, $token);
            session_destroy();
            return true;
        } catch (Exception $e) {
            if ($stmt) {
                $stmt->close();
            }
            die($e->getMessage());
        }
    }

    public function setHeslo($nHeslo, $nHeslo2) {
        if($nHeslo == '')
            return true;
        if($nHeslo != $nHeslo2)
            return false;
        try {
            $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
            if ($conn->connect_errno) {
                throw new Exception("Selhalo připojení do databáze");
            }
            $hash = password_hash($nHeslo,  PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE Users SET heslo = ? WHERE id = ?");
            $stmt->bind_param("si", $hash, $this->id);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();
            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }

            $stmt->close();
            $conn->close();
            return true;
        } catch (Exception $e) {
            if ($stmt) {
                $stmt->close();
            }
            die($e->getMessage());
        }
        return true;
    }

    //setOpravneni je staticke, protoze se vetsinou nastavuje jinemu uzivateli (uzivatel nezvysuje sva vlastni prava)
    public static function setOpravneni($id, $opravneni) {
        try {
            $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
            if ($conn->connect_errno) {
                throw new Exception("Selhalo připojení do databáze");
            }
            $stmt = $conn->prepare("UPDATE Users SET opravneni = ? WHERE id = ?");
            $stmt->bind_param("ii", $opravneni, $id);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();
            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }

            $stmt->close();
            $conn->close();

            return true;
        } catch (Exception $e) {
            if ($stmt) {
                $stmt->close();
            }
            die($e->getMessage());
        }
    }

    // vraci bool, jestli registrace probehla uspesne
    public static function register($email, $heslo, $jmeno)
    {
        try {
            $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
            if ($conn->connect_errno) {
                throw new Exception("Selhalo připojení do databáze");
            }
            $stmt = $conn->prepare("SELECT email FROM Users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            if ($stmt === false) {
                throw new Exception("Nemůžeme zpracovat vložená data");
            }
            $stmt->execute();

            if ($stmt === false) {
                throw new Exception("Nemohu spustit query dotaz");
            }


            if ($stmt->get_result()->num_rows) {
                $stmt->close();
                $conn->close();
                return false;
            }

            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO Users (email, jmeno, heslo) VALUES (?, ?, ?)");
            $hash = password_hash($heslo,  PASSWORD_DEFAULT);
            //mozna pouzit real_escape_char... nebo to osetrovat pri tahani z DB? pri bind_param prece sql injection nejde... ze? :(
            $stmt->bind_param("sss", $email, $jmeno, $hash);
            $stmt->execute();
            //mozna otestovat jestli to selhalo? No, nebo to muzeme posunout to loginu, ktery se proveden na konci
            $uid = $stmt->insert_id;
            $stmt->close();

            /*$token = self::gen_token();
            $stmt = $conn->prepare("INSERT INTO Tokeny (token, uzivatel, ucel) VALUES (?, ?, 1)");
            //probehlo to uspesne?
            $stmt->bind_param("ss", $token, $uid);
            $stmt->execute();
            $stmt->close();
            $conn->close();*/

            self::send_verify($email, $uid);
            return true;
        } catch (Exception $e) {
            if ($stmt) {
                $stmt->close();
            }
            die($e->getMessage());
        }
    }

    // pri uspechu vrati objekt uzivatele, pri neuspechu NULL
    public static function login($email, $heslo)
    {
        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
        $stmt = $conn->prepare("SELECT id, jmeno, opravneni, email, heslo, email_verify FROM Users WHERE email = ?");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt->close();
            $conn->close();
            return false;
        }

        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        if(!password_verify($heslo, $row["heslo"])) return false; //Ověření hesla
        return new User($row["id"], $row["jmeno"], $row["opravneni"], $row["email"], $row['email_verify']);

    }

    //Odeslani verifikacniho emailu uzivateli se zadanym emailem pri registraci a nahodne vygenerovanem tokenu pri registraci
    public static function send_verify($email, $uid)
    {
        $token = self::gen_token();
        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
        $stmt = $conn->prepare("INSERT INTO Tokeny (token, uzivatel, ucel) VALUES (?, ?, 1)");
        $stmt->bind_param("ss", $token, $uid);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $to = $email;
        $subject = "Potvrzení emailu";
        $message = "Dobrý den,<br><br>zbývá poslední krok k registraci. Email ověříte <a href='http://gek.wz.cz/register/verify.php?token=$token'>kliknutím na odkaz<a>.<br><br>Váš věrný GEK tým"; //token v url musi souhlasit s tokenem u uzivatele aby jsme neverifikovali jineho uzivatele
        $headers = "From: noreply@gek.wz.cz \r \n";
        $headers .= "MIME-Version: 1.0" . "\r \n";
        $headers .= "Content-type:text/html;charser=UTF-8" . "\r \n";

        mail($to, $subject, $message, $headers);

        //pak přidat někam header('location:odeslano.php');
    }

    public static function send_reset($email, $uid) {
        $token = self::gen_token();

        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
        $stmt = $conn->prepare("INSERT INTO Tokeny (token, uzivatel, ucel) VALUES (?, ?, 2)");

        $stmt->bind_param("si", $token, $uid);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $to = $email;
        $subject = "Potvrzení emailu";
        $message = "Dobrý den,<br><br>Vyžádali jste si reset hesla. Potvrďte kliknutím na následující odkaz: <a href='http://gek.wz.cz/forgot-password/new.php?token=$token'>kliknutím na odkaz<a>.<br><br>Váš věrný GEK tým"; //token v url musi souhlasit s tokenem u uzivatele aby jsme neverifikovali jineho uzivatele
        $headers = "From: noreply@gek.wz.cz \r \n";
        $headers .= "MIME-Version: 1.0" . "\r \n";
        $headers .= "Content-type:text/html;charser=UTF-8" . "\r \n";

        mail($to, $subject, $message, $headers);
        return true;
    }

    // generovani tokenu,
    //do budoucna: mozna do argumentu pridat $ucel a presunout sem i hozeni tokenu do databaze
    private function gen_token()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 23; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    //vraci ID uzivatele s danym emailem, nebo 0
    private function id_from_email($email) {
        $conn = new mysqli('sql4.webzdarma.cz', 'gekwzcz3751', '&976l3lW9b^12.8J)ykv', 'gekwzcz3751');
        $stmt = $conn->prepare("SELECT id FROM Users WHERE email = ?");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        if ($result->num_rows == 0) {
            return 0;
        }

        $row = $result->fetch_assoc();

        return $row["id"];
    }

}

?>