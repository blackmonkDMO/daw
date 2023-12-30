<?php

session_start();

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');

if ($_SESSION['loggedin'] == True) {
    echo '
    <div class="content">
        <h2>Autentificare</h2>
        <p>Sunteți deja autentificat cu user ' . $_SESSION['name'] . '!<br>Pentru a vă putea autentifica cu alt user, vă rugăm să vă <a href="iesire.php">deconectați</a> mai întâi.</p>
    </div>
    ';
}
else {
    echo '
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
    ';
}

echo '</body>';
echo '</html>';

?>