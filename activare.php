<?php

include_once('db.php');

if (isset($_GET['email'], $_GET['cod'])) {
	if ($stmt = $db->prepare('SELECT * FROM Conturi WHERE Email = ? AND CodActivare = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['cod']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			if ($stmt = $db->prepare('UPDATE Conturi SET CodActivare = ? WHERE Email = ? AND CodActivare = ?')) {
				$newcode = 'activat';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['cod']);
				$stmt->execute();
				echo 'Contul tău a fost activat! Acum te poți autentifica <a href=autentificare.php>aici</a>!';
			}
		} else {
			echo 'Eroare! Contul nu a putut fi activat (nu există, a fost deja activat, sau a apărut o altă eroare)!';
		}
	}
}

$db->close();

?>