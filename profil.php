<?php

session_start();

include_once('db.php');

$stmt = $db->prepare('SELECT Nume, Prenume, Parola, Email FROM Conturi WHERE Id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($nume, $prenume, $parola, $email);
$stmt->fetch();
$stmt->close();

mysqli_close($db);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profil</title>
        <script src="https://kit.fontawesome.com/e9d05e6757.js" crossorigin="anonymous"></script>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
    
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Biblioteca BMK</h1>
                <?php
                if ($_SESSION['loggedin'] == True) {
                    echo '<a href="index.php"><i class="fa-solid fa-house"></i>Acasă</a>';
                    echo '<a href="profil.php"><i class="fas fa-user-circle"></i>Profil</a>';
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="administrare.php"><i class="fa-solid fa-hammer"></i>Administrare</a>';
                    }
                    echo '<a href="iesire.php"><i class="fa-solid fas fa-sign-out-alt"></i>Ieșire</a>';
                }
                else {
                    echo '<a href="index.php"><i class="fa-solid fa-house"></i>Acasă</a>';
                    echo '<a href="autentificare.php"><i class="fa-solid fa-lock"></i>Autentificare</a>';
                }
                ?>
			</div>
		</nav>
        <div class="content">
            <?php
            if ($_SESSION['loggedin'] == True) {
                echo '<h2>Profil</h2>
                <div>
                    <p>Detaliile contului tău sunt:</p>
				    <table>
                        <tr>
                            <td>Nume:</td>
                            <td>' . $nume . '</td>
                        </tr>
                        <tr>
                            <td>Prenume:</td>
                            <td>' . $prenume . '</td>
                        </tr>
                        <tr>
                            <td>Nume utilizator:</td>
                            <td>' . $_SESSION['name'] . '</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>' . $email . '</td>
                        </tr>
                    </table>
                </div>';
            }
            else {
                echo '<h2>Profil - autentificare necesară</h2>';
                echo '<p>Pentru a accesa această secțiune este nevoie să vă autentificați <a href="autentificare.php">aici</a></p>';
            }
            ?>
		</div>
	</body>
</html>