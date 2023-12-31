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
                echo '<a href="inregistrare.php"><i class="fa-solid fa-user-plus"></i>Înregistrare</a>';
                echo '<a href="autentificare.php"><i class="fa-solid fa-lock"></i>Autentificare</a>';
        }
        ?>
	</div>
</nav>