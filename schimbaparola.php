<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Schimbă parola</h2>
            <div>
            <?php
            if ($_SESSION['loggedin'] == True) {                // Dacă suntem autentificați
                if ($_SESSION['cod_activare'] == 'activat') {   // și dacă userul este activ

                    if (!isset($_POST['parolaveche'], $_POST['parolanoua']) || empty($_POST['parolaveche']) || empty($_POST['parolanoua'])) {  // dacă am primit un formular gol sau cu informații lipsă ?>
                        <p>A apărut o eroare! Vă rugăm să vă asigurați că ați introdus atât parola actuală cât și parola pe care doriți să o setați profilului</p>
                        <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                    <?php }
                    else {
                        include_once('db.php');
                        if ($stmt = $db->prepare('SELECT Parola FROM Conturi WHERE Id = ?')) {
                            $stmt->bind_param('i', $_SESSION['id']);
                            $stmt->execute();
                            $stmt->bind_result($parola_veche);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if (password_verify($_POST['parolaveche'], $parola_veche)) { // Dacă parola veche trimisă este corectă; permitem ca parola nouă să fie identică cu cea veche!
                                if (strlen($_POST['parolanoua']) > 20 || strlen($_POST['parolanoua']) < 5) { ?>
                                    <p>Nu am putut modifica parola profilului! Parola nouă trebuie să aibă între 5 și 20 de caractere!</p>
                                    <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                                <?php }
                                else {
                                    if ($stmt = $db->prepare('UPDATE Conturi SET Parola = ? WHERE Id = ?')) {
                                        $parola_noua = password_hash($_POST['parolanoua'], PASSWORD_DEFAULT);
                                        $stmt->bind_param('si', $parola_noua, $_SESSION['id']);
                                        $stmt->execute(); ?>
                                        <p>Am modificat parola pentru contul <strong><?php echo $_SESSION['name']; ?></strong></p>
                                        <p>Este nevoie să vă autentificați cu noua parolă <a href=autentificare.php>aici</a> pentru a continua.</p>
                                        <?php $stmt->close;
                                        session_destroy();
                                    }
                                    else { ?>
                                        <p>Eroare SQL!</p>
                                    <?php }
                                }
                            }
                            else { ?>
                                <p>Parola actuală nu este cea introdusă de tine! Te rugăm să introduci parola actuală corectă.</p>
                                <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                            <?php }
                        }
                        else { ?>
                            <p>Eroare SQL!</p>
                        <?php }
                        $db->close;
                    }
                }
                else { // Dacă suntem autentificați dar userul nu este activ ?>
                    <p>Salut! Contul <strong><?php echo $_SESSION['name']; ?></strong> nu a fost activat. Vă rugăm să verificați adresa de email pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.<br>Alternativ, puteți șterge acest cont <a href=stergere.php>aici</a>.</p>
                <?php }
            }
            else { // Dacă nu suntem autentificați ?>
                <p>Pentru a accesa această secțiune este nevoie să vă autentificați <a href="autentificare.php">aici</a>.</p>
            <?php } ?>
            </div>
        </div>
    </body>
</html>