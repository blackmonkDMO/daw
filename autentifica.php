<?php

session_start();

if ($_SESSION['loggedin'] == True) { ?>
    <!DOCTYPE html>
    <html>
        <?php include_once ('header.php'); ?>
        <body class="loggedin">
            <?php include_once ('navtop.php'); ?>
            <div class="content">
                <h2>Autentificare</h2>
                <p>Sunteți deja autentificat cu user <strong><?php echo $_SESSION['name']; ?></strong>!<br>Pentru a vă putea autentifica cu alt user, vă rugăm să vă <a href="iesire.php">deconectați</a> mai întâi.</p>
            </div>
        </body>
    </html>
    <?php exit;
}

if (!isset($_POST['utilizator'], $_POST['parola'])) { ?>
    <!DOCTYPE html>
    <html>
        <?php include_once ('header.php'); ?>
        <body class="loggedin">
            <?php include_once ('navtop.php'); ?>
            <div class="content">
                <h2>Autentificare</h2>
                <p>Vă rugăm să introduceți atât un nume de Utilizator cât și o Parolă!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
            </div>
        </body>
    </html>
    <?php exit;
}

include_once('db.php');

if ($stmt = $db->prepare('SELECT Id, Parola, Rol, CodActivare FROM Conturi WHERE Utilizator = ?')) {
    $stmt->bind_param('s', $_POST['utilizator']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $parola, $rol, $cod_activare);
        $stmt->fetch();
        if (password_verify($_POST['parola'], $parola)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['utilizator'];
            $_SESSION['rol'] = $rol;
            $_SESSION['id'] = $id;
            $_SESSION['cod_activare'] = $cod_activare;
            //echo 'Bine ai venit ' . $_SESSION['name'] . '!';
            header('Location: index.php');
        }
        else { // Parolă greșită ?>
            <!DOCTYPE html>
            <html>
                <?php include_once ('header.php'); ?>
                <body class="loggedin">
                    <?php include_once ('navtop.php'); ?>
                    <div class="content">
                        <h2>Autentificare</h2>
                        <p>Ați introdus un nume de utilizator și/sau o parolă greșite!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
                    </div>
                </body>
            </html>
        <?php }
    }
    else { // Nume utilizator greșit ?>
        <!DOCTYPE html>
        <html>
            <?php include_once ('header.php'); ?>
            <body class="loggedin">
                <?php include_once ('navtop.php'); ?>
                <div class="content">
                    <h2>Autentificare</h2>
                    <p>Ați introdus un nume de utilizator și/sau o parolă greșite!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
                </div>
            </body>
        </html>
    <?php }

    $stmt->close();
    $db->close();;
}
else { ?>
    <html>
        <?php include_once ('header.php'); ?>
        <body class="loggedin">
            <?php include_once ('navtop.php'); ?>
            <div class="content">
                <h2>Autentificare</h2>
                <p>Eroare SQL!</p>
            </div>
        </body>
    </html>
<?php } ?>