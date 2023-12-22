<?php
session_start();

include_once('db.php');

if (!isset($_POST['utilizator'], $_POST['parola'])) {
	exit('Vă rugăm să introduceți atât un nume de Utilizator cât și o Parolă!');
}

if ($stmt = $db->prepare('SELECT Id, Parola, Rol, CodActivare FROM Conturi WHERE Utilizator = ?')) {
	$stmt->bind_param('s', $_POST['utilizator']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $parola, $rol, $cod_activare);
        $stmt->fetch();
        if (password_verify($_POST['parola'], $parola)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['utilizator'];
            $_SESSION['rol'] = $rol;
            $_SESSION['id'] = $id;
            $_SESSION['cod_activare'] = $cod_activare;
            //echo 'Bine ai venit ' . $_SESSION['name'] . '!';
            header('Location: index.php');
        } else {
            // Parolă greșită
            echo 'Ați introdus un nume de utilizator și/sau o parolă greșite!';
        }
    } else {
        // Nume utilizator greșit
        echo 'Ați introdus un nume de utilizator și/sau o parolă greșite!';
    }

	$stmt->close();
    mysqli_close($db);
}

?>

