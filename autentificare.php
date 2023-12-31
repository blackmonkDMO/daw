<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php');
        if ($_SESSION['loggedin'] == True) { ?>
            <div class="content">
                <h2>Autentificare</h2>
                <p>Sunteți deja autentificat cu user <strong><?php echo $_SESSION['name']; ?></strong>!<br>Pentru a vă putea autentifica cu alt user, vă rugăm să vă <a href="iesire.php">deconectați</a> mai întâi.</p>
            </div>
        <?php }
        else { ?>
            <div class="login">
                <h1>Autentificare</h1>
                <form action="autentifica.php" method="post">
                    <label for="utilizator"><i class="fas fa-user"></i></label>
                    <input type="text" name="utilizator" placeholder="Utilizator" id="utilizator" required>
                    <label for="parola"><i class="fas fa-lock"></i></label>
                    <input type="password" name="parola" placeholder="Parolă" id="parola" required>
                    <input type="submit" value="Intră">
                </form>
            </div>
        <?php } ?>
    </body>
</html>
