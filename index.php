<?php

session_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Biblioteca BMK</title>
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
                echo 'Bine ai revenit, !';
            }
            else {
                echo '<h2>Motto</h2>';
                echo '<p>"Aceasta nu va fi niciodată o țară civilizată atâta timp cât cheltuim mai mulți bani pe guma de mestecat decât pe cărți."<br>Elbert Hubbard</p>';
            }
            ?>
		</div>
	</body>
</html>