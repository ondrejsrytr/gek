<?php

// trida je nedokoncena, nektere casti (okomentovane "TO DO") je potreba doplnit

class User {
	public $id;
	public $jmeno;
	public $opravneni;
	public $email;

	private User($id, $jmeno, $opravneni, $email) {
		$this.id = $id;
		$this.jmeno = $jmeno;
		$this.opravneni = $opravneni;
		$this.email = $email;
	}

	public function getId() {
		return $this->id;
	}

	public function getJmeno() {
		return $this->jmeno;
	}

	public function getOpravneni() {
		return $this->opravneni;
	}

	public function getEmail() {
		return $this->email;
	}

	//TO DO: settery, ktere aktualizuji databazi

	// vraci bool, jestli registrace probehla uspesne
	public static function register($email, $heslo, $jmeno, ) {
		$conn = new mysqli('localhost', 'projekt-vspj.ml', '9l66(0DZdkIkU)', 'projekt_vspj.ml');
		$stmt = $conn->prepare("SELECT email FROM Users WHERE email = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$res = $stmt->get_result();

		// pokud uzivatel jiz existuje
		if($stmt->get_result()->num_rows()) {
			$stmt->close();
			$conn->close();
			return false;
		}

		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO Users (email, jmeno, heslo) VALUES (?, ?, ?)")
		$hash = password_hash($heslo, PASSWORD_ARGON2I);
		//mozna pouzit real_escape_char... nebo to osetrovat pri tahani z DB? pri bind_param prece sql injection nejde... ze? :(
		$stmt->bind_param("sss", $email, $jmeno, $hash);
		$stmt->execute();
		//mozna otestovat jestli to selhalo? No, nebo to muzeme posunout to loginu, ktery se proveden na konci
		$uid = $stmt->insert_id;
		$stmt->close();

		$token = gen_token();
		$stmt = $conn->prepare("INSERT INTO Tokeny (token, uzivatel, ucel) VALUES (?, ?, 1)");
		//probehlo to uspesne?
		$stmt->bind_param("ss", $token, $uid)
		$stmt->execute();
		$stmt->close();
		$conn->close();

		send_verify($email, $token);
		return true;
	}

	// pri uspechu vrati objekt uzivatele, pri neuspechu NULL
	public static function login($email, $heslo) {
		$conn = new mysqli('localhost', 'projekt-vspj.ml', '9l66(0DZdkIkU)', 'projekt_vspj.ml');
		$stmt = $conn->prepare("SELECT id, email, jmeno, opravneni, heslo FROM Users WHERE email = ? AND opravneni > 0 LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		if($stmt->get_result->num_rows() == 0)
			return NULL;
		$result = $stmt->get_result()->fetch_assoc();
		//mozna nastavit sessionu...ne, to se spis bude nastavovat jinde :-)))
		return new User($result["id"], $result["jmeno"], $result["opravneni"], $result["email"]);
	}

	//Odeslani verifikacniho emailu uzivateli se zadanym emailem pri registraci a nahodne vygenerovanem tokenu pri registraci
	public static function send_verify($email, $token) {
		$to = $email;
		$subject = "Potvrzení emailu"
		$message = "<a href='http://projekt-vspj.ml/verifikace.php?token=$token'>Potvrdit email<a>"; //token v url musi souhlasit s tokenem u uzivatele aby jsme neverifikovali jineho uzivatele
		$headers = "From: noreply@gmail.com \r \n";
		$headers .= "MIME-Version: 1.0" . "\r \n";
		$headers .= "Content-type:text/html;charser=UTF-8" . "\r \n";

		mail($to,$subject,$message,$headers);

		//pak přidat někam header('location:odeslano.php');
	}

	// generovani tokenu,
	//do budoucna: mozna do argumentu pridat $ucel a presunout sem i hozeni tokenu do databaze
	private function gen_token() {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    	$randomString = ''; 
    	for ($i = 0; $i < 23; $i++) {
        	$index = rand(0, strlen($characters) - 1); 
        	$randomString .= $characters[$index]; 
    	}
    	return $randomString;
	}

}
?>