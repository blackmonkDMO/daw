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

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');


echo '<div class="content">';
if ($_SESSION['loggedin'] == True) {
    if ($_SESSION['cod_activare'] == 'activat') {
        echo '
        <h2>Profil</h2>
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
        </div>
        ';
    }
    else {
        echo '<h2>Cont neactivat!</h2>';
        echo '<p>Salut! Contul ' . $_SESSION['name'] . ' nu a fost activat. Vă rugăm să verificați adresa de email folosită la înregistrare pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.<br>Alternativ, puteți șterge acest cont <a href=stergere.php>aici</a>.</p>';
    }
}
else {
    echo '<h2>Profil - autentificare necesară</h2>';
    echo '<p>Pentru a accesa această secțiune este nevoie să vă autentificați <a href="autentificare.php">aici</a>.</p>';
}
echo '</div>';

echo '</body>';
echo '</html>';

?>