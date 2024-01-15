<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Promovează profil</h2>
            <div>
            <?php
            if ($_SESSION['loggedin'] == True) {     // Dacă suntem autentificați
                if ($_SESSION['rol'] == 'user') {    // și dacă userul este unul "normal" ?>
                    <p>Nu aveți acces la această secțiune a bibliotecii!.</p>
                <?php }
                elseif ($_SESSION['rol'] == 'admin') { // Dacă suntem autentificați și userul este administrator

                    if (!isset($_POST['profil'], $_POST['parola'], $_POST['confirmapromovare']) || empty($_POST['profil']) || empty($_POST['parola']) || empty($_POST['confirmapromovare'])) {  // dacă am primit un formular gol sau cu informații lipsă ?>
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
                            
                            if (password_verify($_POST['parola'], $parola)) { // Dacă parola introdusă este corectă (atenție, verificăm userul curent, nu userul care urmează a fi promovat!)
                                if ($stmt = $db->prepare('SELECT Rol FROM Conturi WHERE Utilizator = ?')) {
                                    $stmt->bind_param('s', $_POST['profil']);
                                    $stmt->execute();
                                    $stmt->bind_result($rol);
                                    $stmt->fetch();
                                    $stmt->close();

                                    if ($rol == 'user') { // dacă profilul de promovat este unul normal
                                        if ($stmt = $db->prepare('UPDATE Conturi SET Rol=? WHERE Utilizator=?')) {
                                            $rol_nou = 'admin';
                                            $stmt->bind_param('ss', $rol_nou, $_POST['profil']);
                                            $stmt->execute(); ?>
                                            <p>Am promovat profilul <strong><?php echo $_POST['profil']; ?></strong> la rol de administrator.</p>
                                            <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                                            <?php $stmt->close;
                                        }
                                        else { ?>
                                            <p>Eroare SQL!</p>
                                        <?php }
                                    }
                                    
                                    elseif ($rol == 'admin') { // dacă profilul de promovat este unul de administrator ?>
                                        <p>Userul este deja admin! Nu avem nimic de făcut.</p>
                                        <p>Pentru a reveni la administrarea profilelor click <a href="adminprofile.php">aici</a>.</p>
                                    <?php }
                                }
                                else { ?>
                                    <p>Eroare SQL!</p>
                                <?php } 
                            }
                            else { // parola introdusă nu este corectă ?>
                                <p>Parola introdusă nu este corectă! Nu putem promova profilul!</p>
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