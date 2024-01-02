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
                        <p><strong>Detaliile profilului tău:</strong></p>
                        <table>
                        <tr>
                            <td>Nume utilizator:</td>
                            <td><?php echo $_SESSION['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Nume:</td>
                            <td><?php echo $nume; ?></td>
                        </tr>
                        <tr>
                            <td>Prenume:</td>
                            <td><?php echo $prenume; ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        </table>
                    </div>
            
                    <div>
                        <p><strong>Modifică profilul <?php echo $_SESSION['name']; ?>:</strong></p>
                        <form action="modificaprofil.php" method="post">
                            <fieldset>
                                <label for="nume">Nume:</label>
                                <input type="text" name="nume" placeholder="<?php echo $nume; ?>" id="nume">
                                <label for="prenume">Prenume:</label>
                                <input type="text" name="prenume" placeholder="<?php echo $prenume; ?>" id="prenume">
                                <label for="email">Email:</label>
                                <input type="email" name="email" placeholder="<?php echo $email; ?>" id="email">
                                <input type="submit" value="Modifică profil">
                            </fieldset>
                        </form>
                        <p>Poți modifica numele, prenumele și adresa de email asociate profilului.</p>
                        <p>În momentul modificării adresei de email, va fi nevoie să reconfirmați profilul pe adresa nouă.</p>
                        <p>Nu se poate modifica numele de utilizator (nickname-ul).</p>
                    </div>
            
                    <div>
                        <p><strong>Schimbă parola profilului <?php echo $_SESSION['name']; ?>:</strong></p>
                        <form action="schimbaparola.php" method="post">
                            <fieldset>
                                <label for="parolaveche">Parolă actuală:</label>
                                <input type="password" name="parolaveche" placeholder="Introdu parola actuală a profilului" id="parolaveche" required>
                                <label for="parolanoua">Parolă nouă:</label>
                                <input type="password" name="parolanoua" placeholder="Introdu parola pe care vrei să o setezi profilului" id="parolanoua" required>
                                <input type="submit" value="Schimbă parola">
                            </fieldset>
                        </form>
                    </div>
            
                    <div>
                        <p><strong>Șterge profilul <?php echo $_SESSION['name']; ?>:</strong></p>
                        <form action="stergeprofil.php" method="post">
                            <fieldset>
                                <label for="profil">Profil:</label>
                                <input type="text" name="profil" value="<?php echo $_SESSION['name']; ?>" id="profil" readonly required>
                                <label for="parola">Parola profilului:</label>
                                <input type="password" name="parola" placeholder="Introdu parola actuală a profilului" id="parola" required>
                                <p>Prin bifarea check-boxului de mai jos confirmați că sunteți de acrod cu ștergerea profilului. Datele profilului nu mai pot fi recuperate după ce este șters!</p>
                                <input type="checkbox" id="confirmastergere" name="confirmastergere" value="confirmastergere">
                                <label for="checkstergere">Sunt sigur</label>
                                <input type="submit" value="Șterge profil">
                            </fieldset>
                        </form>
                    </div>
                <?php
                }
                else { ?>
                    <h2>Cont neactivat!</h2>
                    <p>Salut! Contul <strong><?php echo $_SESSION['name']; ?></strong> nu a fost activat. Vă rugăm să verificați adresa de email folosită la înregistrare pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.<br>Alternativ, puteți șterge acest profil <a href=stergere.php>aici</a>.</p>
                <?php }
            }
            else { ?>
                <h2>Profil - autentificare necesară</h2>
                <p>Pentru a accesa această secțiune este nevoie să vă autentificați <a href="autentificare.php">aici</a>.</p>
            <?php } ?>
        </div>
    </body>
</html>