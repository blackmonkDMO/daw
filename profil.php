<?php session_start();

include_once('db.php');

$stmt = $db->prepare('SELECT Nume, Prenume, Parola, Email FROM Conturi WHERE Id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($nume, $prenume, $parola, $email);
$stmt->fetch();
$stmt->close();

$db->close;

?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <?php
            if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['cod_activare'] == 'activat') { ?>
                    <h2>Profil</h2>
                    <div>
                        <p>Detaliile contului tău sunt:</p>
                        <table>
                        <tr>
                            <td>Nume:</td>
                            <td><?php echo $nume; ?></td>
                        </tr>
                        <tr>
                            <td>Prenume:</td>
                            <td><?php echo $prenume; ?></td>
                        </tr>
                        <tr>
                            <td>Nume utilizator:</td>
                            <td><?php echo $_SESSION['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        </table>
                    </div>
                <?php
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
            ?>
        </div>
    </body>
</html>