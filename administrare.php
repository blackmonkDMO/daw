<?php

session_start();

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
                if ($_SESSION['loggedin'] == True && $_SESSION['cod_activare'] == 'activat') {
                    echo '<a href="index.php"><i class="fa-solid fa-house"></i>Acasă</a>';
                    echo '<a href="profil.php"><i class="fas fa-user-circle"></i>Profil</a>';
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="administrare.php"><i class="fa-solid fa-hammer"></i>Administrare</a>';
                    }
                    echo '<a href="iesire.php"><i class="fa-solid fas fa-sign-out-alt"></i>Ieșire</a>';
                }
                else {
                    echo '<a href="index.php"><i class="fa-solid fa-house"></i>Acasă</a>';
                    echo '<a href="inregistrare.php"><i class="fa-solid fa-user-plus"></i></i>Înregistrare</a>';
                    echo '<a href="autentificare.php"><i class="fa-solid fa-lock"></i>Autentificare</a>';
                }
                ?>
			</div>
		</nav>
        <div class="content">
            <?php
            if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<h2>Administrare</h2>
                    <p>Felicitări! Sunteți administrator al acestestei biblioteci!</p>';
                }
                else {
                    echo '<h2>Acces Interzis!</h2>
                    <p>Nu aveți acces la această secțiune a bibliotecii!</p>';
                }
            }
            else {
                echo '<h2>Administrare - autentificare necesară</h2>';
                echo '<p>Pentru a accesa această secțiune este nevoie să vă autentificați cu un cont de <strong>administrator</strong> <a href="autentificare.php">aici</a></p>';
            }
            ?>
		</div>
	</body>
</html>
