<?php

session_start();

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');

echo '<div class="content">';
if ($_SESSION['loggedin'] == True) {
    if ($_SESSION['cod_activare'] == 'activat') {
        echo '<h2>Acasă</h2>';
        echo '<p>Bine ai revenit ' . $_SESSION['name'] . '.</p>';
    }
    else {
        echo '<h2>Cont neactivat!</h2>';
        echo '<p>Salut! Contul ' . $_SESSION['name'] . ' nu a fost activat. Vă rugăm să verificați adresa de email folosită la înregistrare pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.<br>Alternativ, puteți șterge acest cont <a href=stergere.php>aici</a>.</p>';
        }
    }
else {
    echo '<h2>Motto</h2>';
    echo '<p>"Aceasta nu va fi niciodată o țară civilizată atâta timp cât cheltuim mai mulți bani pe guma de mestecat decât pe cărți."<br>Elbert Hubbard</p>';
}
echo '</div>';

echo '</body>';
echo '</html>';

?>