<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Modifică profil</h2>
            <div>
            <?php
            if ($_SESSION['loggedin'] == True) {                // Dacă suntem autentificați
                if ($_SESSION['cod_activare'] == 'activat') {   // și dacă userul este activ
                    
                    if (!isset($_POST['nume'], $_POST['prenume'], $_POST['email']) || (empty($_POST['nume']) && empty($_POST['prenume']) && empty($_POST['email']))) {  // dacă am primit un formular gol ?>
                        <p>Nu ați solicit modificarea niciunui detaliu al profilului dumneavoastră!</p>
                        <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                    <?php }
                    else {
                        include_once('db.php');
                        if ($stmt = $db->prepare('SELECT Nume, Prenume, Email FROM Conturi WHERE Id = ?')) {
                            $stmt->bind_param('i', $_SESSION['id']);
                            $stmt->execute();
                            $stmt->bind_result($nume_actual, $prenume_actual, $email_actual);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if (!empty($_POST['nume'])) { // Dacă s-a încercat schimbarea numelui
                                if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț-]+$/', $_POST['nume']) == 0) { ?>
                                    <p>Numele <strong><?php echo $_POST['nume']; ?></strong> nu este unul valid. Numele poate conține litere mari, litere mici, cifre și caracterul "-". Nu am modificat numele!</p>
                                <?php }
                                else if ($_POST['nume'] != $nume_actual) {
                                    if ($stmt = $db->prepare('UPDATE Conturi SET Nume = ? WHERE Id = ?')) {
                                        $stmt->bind_param('si', $_POST['nume'], $_SESSION['id']);
                                        $stmt->execute(); ?>
                                        <p>Am modificat nume <?php echo $nume_actual; ?> -> <?php echo $_POST['nume'] ?></p>
                                        <?php $stmt->close;
                                    }
                                    else { ?>
                                        <p>Eroare SQL!</p>
                                    <?php }
                                }
                                else { ?>
                                    <p>Numele vechi și numele nou sunt identice. Nu am operat modificarea numelui!</p>
                                <?php }
                            }
                            
                            if (!empty($_POST['prenume'])) { // Dacă s-a încercat schimbarea prenumelui
                                if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț-]+$/', $_POST['prenume']) == 0) { ?>
                                    <p>Prenumele <strong><?php echo $_POST['nume']; ?></strong> nu este unul valid. Prenumele poate conține litere mari, litere mici, cifre și caracterul "-". Nu am modificat prenumele!</p>
                                <?php }
                                else if ($_POST['prenume'] != $prenume_actual) {
                                    if ($stmt = $db->prepare('UPDATE Conturi SET Prenume = ? WHERE Id = ?')) {
                                        $stmt->bind_param('si', $_POST['prenume'], $_SESSION['id']);
                                        $stmt->execute(); ?>
                                        <p>Am modificat prenume <?php echo $prenume_actual; ?> -> <?php echo $_POST['prenume'] ?></p>
                                        <?php $stmt->close;
                                    }
                                    else { ?>
                                        <p>Eroare SQL!</p>
                                    <?php }
                                }
                                else { ?>
                                    <p>Prenumele vechi și prenumele nou sunt identice. Nu am operat modificarea prenumelui!</p>
                                <?php }
                            }
                            
                            if (!empty($_POST['email'])) { // Dacă s-a încercat schimbarea emailului
                                if ($_POST['email'] != $email_actual) {
                                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { ?>
                                        <p>Adresa de email introdusă nu este validă! Nu am modificat adresa de email</p>
                                    <?php }
                                    else if ($stmt = $db->prepare('UPDATE Conturi SET Email = ?, CodActivare = ? WHERE Id = ?')) {
                                        $uniqid = uniqid();
                                        $stmt->bind_param('ssi', $_POST['email'], $uniqid, $_SESSION['id']);
                                        $stmt->execute();
                                        
                                        session_destroy();
                                        
                                        $from = 'noreply@blackmonk.ro';
                                        $subject = 'daw.blackmonk.ro - Este necesara (re)activarea contului';
                                        $headers = 'From: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8';
                                        $link_activare = 'https://daw.blackmonk.ro/activare.php?email=' . $_POST['email'] . '&cod=' . $uniqid;
                                        $message = '<p>Ați solicitat schimbarea adresei de email asociată profilului dumneavoastră. Pentru a confirma adresa de email și a reactiva profilul vă rugăm să accesați acest link: <a href="' . $link_activare . '">' . $link_activare . '</a></p>';
            
                                        mail($_POST['email'], $subject, $message, $headers); ?>
                
                                        <p>Am modificat email <?php echo $email_actual; ?> -> <?php echo $_POST['email'] ?>.<br>Profilul trebuie acum reactivat folosind noua adresă de email.<br>Pentru asta a fost trimis un email la <?php echo $_POST['email'] ?> în care veți regăsi link-ul necesar.</p>
                                        <?php $stmt->close;
                                    }
                                    else { ?>
                                        <p>Eroare SQL!</p>
                                    <?php }
                                }
                                else { ?>
                                    <p>Email-ul vechi și email-ul nou sunt identice. Nu am operat modificarea email-ului!</p>
                                <?php }
                            }
                            
                        }
                        else { ?>
                            <p>Eroare SQL!!</p>
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