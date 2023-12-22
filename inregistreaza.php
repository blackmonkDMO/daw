<?php
session_start();

if (!isset($_POST['nume'], $_POST['prenume'], $_POST['utilizator'], $_POST['parola'], $_POST['email'])) {
	exit('Pentru înregistrare vă rugăm să completați formularul de <a href=inregistrare.php>aici</a>!');
}
if (empty($_POST['nume']) || empty($_POST['prenume']) ||empty($_POST['utilizator']) || empty($_POST['parola']) || empty($_POST['email'])) {
	exit('Nu ați completat toate datele necesare. Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

if (preg_match('/^[a-zA-Z0-9-]+$/', $_POST['nume']) == 0) {
    exit('Numele ' . $_POST['nume'] . ' nu este unul valid. Numele poate conține litere mari, litere mici, cifre și carcterul "-". Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

if (preg_match('/^[a-zA-Z0-9-]+$/', $_POST['prenume']) == 0) {
    exit('Prenumele ' . $_POST['prenume'] . ' nu este unul valid. Prenumele poate conține litere mari, litere mici, cifre și carcterul "-". Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

if (preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['utilizator']) == 0) {
    exit('Numele de utilizator ' . $_POST['utilizator'] . ' nu este unul valid. Numele de utilizator poate conține litere mari, litere mici, cifre și caracterele "-" sau "_". Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

if (strlen($_POST['parola']) > 20 || strlen($_POST['parola']) < 5) {
	exit('Parola aleasă trebuie să aibă între 5 și 20 de carctere. Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Adresa de email introdusă nu este validă. Vă rugăm reîncercați <a href=inregistrare.php>aici</a>!');
}

include_once('db.php');

if ($stmt = $db->prepare('SELECT Id FROM Conturi WHERE Email = ?')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		// Email already exists
        $stmt->close();
        $db->close();
		exit('Adresa de email ' . $_POST['email'] . ' este deja folosită! Vă rugăm să folosiți o altă adresă de email. Puteți reîncerca <a href=inregistrare.php>aici</a>!');
	}
    $stmt->close();
} else {
	echo 'Eroare SQL!';
}

if ($stmt = $db->prepare('SELECT Id, Parola FROM Conturi WHERE Utilizator = ?')) {
	$stmt->bind_param('s', $_POST['utilizator']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		// Utilizator already exists
		echo 'Numele de utilizator ' . $_POST['utilizator'] . ' este deja folosit! Vă rugăm să alegeți altul. Puteți reîncerca <a href=inregistrare.php>aici</a>!';
	} else {
		// Utilizator doesn't exists, insert new account
        if ($stmt = $db->prepare('INSERT INTO Conturi (Nume, Prenume, Utilizator, Parola, Rol, Email, CodActivare) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
            $password = password_hash($_POST['parola'], PASSWORD_DEFAULT);
            $rol = 'user';
            $uniqid = uniqid();
            $stmt->bind_param('sssssss', $_POST['nume'], $_POST['prenume'], $_POST['utilizator'], $password, $rol, $_POST['email'], $uniqid);
            $stmt->execute();
            
            $from = 'noreply@blackmonk.ro';
            $subject = 'daw.blackmonk.ro - Este necesară activarea contului';
            $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
            $link_activare = 'https://daw.blackmonk.ro/activare.php?email=' . $_POST['email'] . '&cod=' . $uniqid;
            $message = '<p>Pentru a vă activa contul creat pe daw.blackmonk.ro vă rugăm să accesați acest link: <a href="' . $link_activare . '">' . $link_activare . '</a></p>';
            
            mail($_POST['email'], $subject, $message, $headers);
            
            echo 'Ai fost inregistrat cu succes!<br>Un Email cu un link necesar activării noului tău cont a fost trimis către ' . $_POST['email'] . '.<br>După activarea contului te poți autentifica <a href=autentificare.php>aici</a>!';
        } else {
            echo 'Eroare SQL!';
        }
	}
	$stmt->close();
} else {
	echo 'Eroare SQL!';
}

$db->close();

?>


