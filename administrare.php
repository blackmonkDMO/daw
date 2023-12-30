<?php

session_start();

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');

echo '<div class="content">';
if ($_SESSION['loggedin'] == True) {
    if ($_SESSION['rol'] == 'admin') {
        echo '
        <h2>Administrare</h2>
        <p>Felicitări! Sunteți administrator al acestestei biblioteci!</p>
        ';
    }
    else {
        echo '
        <h2>Acces Interzis!</h2>
        <p>Nu aveți acces la această secțiune a bibliotecii!</p>
        ';
    }
}
else {
    echo '
    <h2>Administrare - autentificare necesară</h2>
    <p>Pentru a accesa această secțiune este nevoie să vă autentificați cu un cont de <strong>administrator</strong> <a href="autentificare.php">aici</a></p>
    ';
}
echo '</div>';

echo '</body>';
echo '</html>';

?>