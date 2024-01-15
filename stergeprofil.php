<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Șterge profil</h2>
            <div>
            <?php
            if ($_SESSION['loggedin'] == True) {     // Dacă suntem autentificați
                if ($_SESSION['rol'] == 'user') {    // și dacă userul este unul "normal"

                    if (!isset($_POST['profil'], $_POST['parola'], $_POST['confirmastergere']) || empty($_POST['profil']) || empty($_POST['parola']) || empty($_POST['confirmastergere'])) {  // dacă am primit un formular gol sau cu informații lipsă ?>
                        <p>A apărut o eroare! Vă rugăm să vă asigurați că ați introdus parola profilului pe care doriți să-l ștergeți și că ați confirmat acest lucru (ați bifat căsuța <strong>Sunt sigur</strong>)</p>
                        <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                    <?php }
                    else {
                        include_once('db.php');
                        if ($stmt = $db->prepare('SELECT Parola FROM Conturi WHERE Id = ? AND Utilizator = ?')) {
                            $stmt->bind_param('is', $_SESSION['id'], $_POST['profil']);
                            $stmt->execute();
                            $stmt->bind_result($parola);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if (password_verify($_POST['parola'], $parola)) { // Dacă parola introdusă este corectă
                                // TODO - trebuie ă verificăm că userul nu are împrumuturi active!
                                if ($stmt = $db->prepare('DELETE FROM Conturi WHERE Id = ?')) {
                                    $stmt->bind_param('i', $_SESSION['id']);
                                    $stmt->execute(); ?>
                                    <p>Am șters profilul <strong><?php echo $_SESSION['name']; ?></strong></p>
                                    <p>Mulțumim pentru că ați folosit serviciile <strong>Bibliotecii BMK</strong></p>
                                    <?php $stmt->close;
                                    session_destroy();
                                }
                                else { ?>
                                    <p>Eroare SQL!</p>
                                <?php }
                            }
                            else { ?>
                                <p>Parola introdusă nu este corectă! Nu putem șterge profilul!</p>
                                <p>Profilul poate fi administrat <a href=profil.php>aici</a></p>
                            <?php }
                        }
                        else { ?>
                            <p>Eroare SQL!</p>
                        <?php }
                        $db->close;
                    }
                }
                elseif ($_SESSION['rol'] == 'admin') { // Dacă suntem autentificați și userul este administrator

                    if (!isset($_POST['profil'], $_POST['parola'], $_POST['confirmastergere']) || empty($_POST['profil']) || empty($_POST['parola']) || empty($_POST['confirmastergere'])) {  // dacă am primit un formular gol sau cu informații lipsă ?>
                        <p>A apărut o eroare! Asigură-te că ai selectat/introdus toate datele corect!</p>
                        <p>Pentru a reveni la administrarea profilelor click<a href="adminprofile.php"> aici</a>.</p>
                    <?php }
                    else {
                        include_once('db.php');
                        if ($stmt = $db->prepare('SELECT Parola FROM Conturi WHERE Id = ?')) {
                            $stmt->bind_param('i', $_SESSION['id']);
                            $stmt->execute();
                            $stmt->bind_result($parola);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if (password_verify($_POST['parola'], $parola)) { // Dacă parola introdusă este corectă (atenție, verificăm userul curent, nu userul care urmează a fi șters!)
                                if ($stmt = $db->prepare('SELECT Rol FROM Conturi WHERE Utilizator = ?')) {
                                    $stmt->bind_param('s', $_POST['profil']);
                                    $stmt->execute();
                                    $stmt->bind_result($rol);
                                    $stmt->fetch();
                                    $stmt->close();

                                    if ($rol == 'user') { // dacă profilul de șters este unul normal
                                        // TODO - trebuie ă verificăm că userul nu are împrumuturi active!
                                        if ($stmt = $db->prepare('DELETE FROM Conturi WHERE Utilizator = ?')) {
                                            $stmt->bind_param('s', $_POST['profil']);
                                            $stmt->execute(); ?>
                                            <p>Am șters profilul <strong><?php echo $_POST['profil']; ?></strong></p>
                                            <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                                            <?php $stmt->close;
                                        }
                                        else { ?>
                                            <p>Eroare SQL!</p>
                                        <?php }
                                    }
                                    
                                    elseif ($rol == 'admin') { // dacă profilul de șters este unul de administrator
                                        if ($_POST['profil'] == $_SESSION['name']) { // un admin nu poate șterge contul altul admin, îl poate șterge doar pe al său
                                            if ($stmt = $db->prepare('SELECT Id FROM Conturi WHERE Rol = "admin"')) {
                                                $stmt->execute();
                                                $stmt->store_result();
                                                if ($stmt->num_rows > 1) { // dacă mai există cel puțin un cont de admin
                                                    // TODO - trebuie ă verificăm că userul nu are împrumuturi active!
                                                    if ($stmt = $db->prepare('DELETE FROM Conturi WHERE Utilizator = ?')) {
                                                        $stmt->bind_param('s', $_POST['profil']);
                                                        $stmt->execute(); ?>
                                                        <p>Mulțumim pentru că ați folosit serviciile <strong>Bibliotecii BMK</strong></p>
                                                        <?php $stmt->close;
                                                        session_destroy();
                                                    }
                                                    else { ?>
                                                        <p>Eroare SQL!</p>
                                                    <?php }
                                                }
                                                else { ?>
                                                    <p>Ești ultimul administrator, nu putem șterge acest profil!</p>
                                                    <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                                                <?php }
                                            }
                                            else { ?>
                                                <p>Eroare SQL!</p>
                                            <?php } 
                                        }
                                        else { ?>
                                            <p>Nu poți șterge profilul altui administrator!</p>
                                            <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                                        <?php }
                                    }
                                }
                                else { ?>
                                    <p>Eroare SQL!</p>
                                <?php } 
                            }
                            else { // parola introdusă nu este corectă ?>
                                <p>Parola introdusă nu este corectă! Nu putem șterge profilul!</p>
                                <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                            <?php }
                        }
                        else { ?>
                            <p>Eroare SQL!</p>
                        <?php }
                        $db->close;
                    } ?>
                <?php }
            }
            else { // Dacă nu suntem autentificați ?>
                <p>Pentru a accesa această secțiune este nevoie să vă autentificați <a href="autentificare.php">aici</a>.</p>
            <?php } ?>
            </div>
        </div>
    </body>
</html>