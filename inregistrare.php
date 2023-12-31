<?php session_start(); ?>

<!DOCTYPE html>

<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php');
        if ($_SESSION['loggedin'] == True) { ?>
            <div class="content">
                <h2>Înregistrare</h2>
                <p>Sunteți deja autentificat cu user <?php echo $_SESSION['name']; ?>!<br>Pentru a putea înregistra un alt utilizator vă rugăm să vă <a href="iesire.php">deconectați</a> mai întâi.</p>
            </div>
        <?php }
        else { ?>
            <div class="login">
                <h1>Înregistrare</h1>
                <form action="inregistreaza.php" method="post" autocomplete="off"><label for="nume"><i class="fa-solid fa-person"></i></label>
                    <input type="text" name="nume" placeholder="Nume" id="nume" required>
                    <label for="prenume"><i class="fa-solid fa-person"></i></label>
                    <input type="text" name="prenume" placeholder="Prenume" id="prenume" required>
                    <label for="utilizator"><i class="fas fa-user"></i></label>
                    <input type="text" name="utilizator" placeholder="Nume Utilizator (nickname)" id="utilizator" required>
                    <label for="parola"><i class="fas fa-lock"></i></label>
                    <input type="password" name="parola" placeholder="Parolă" id="parola" required>
                    <label for="email"><i class="fas fa-envelope"></i></label>
                    <input type="email" name="email" placeholder="Email" id="email" required>
                    <input type="submit" value="Înregistrează">
                </form>
            </div>
        <?php } ?>
    </body>
</html>