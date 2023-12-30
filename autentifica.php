<?php
session_start();

include_once('db.php');

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');

if (!isset($_POST['utilizator'], $_POST['parola'])) {
    echo '
    <div class="content">
        <h2>Autentificare</h2>
        <p>Vă rugăm să introduceți atât un nume de Utilizator cât și o Parolă!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
    </div>
    </body>
    </html>
	';
    exit;
}

echo '
<div class="content">
<h2>Autentificare</h2>
';

if ($_SESSION['loggedin'] == True) {
    echo '
    <div class="content">
        <h2>Înregistrare</h2>
        <p>Sunteți deja autentificat cu user ' . $_SESSION['name'] . '!<br>Pentru a putea înregistra un alt utilizator vă rugăm să vă <a href="iesire.php">deconectați</a> mai întâi.</p>
    </div>
    </body>
    </html>
	';
    exit;
}

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
        } else {
            // Parolă greșită
            echo '
            <p>Ați introdus un nume de utilizator și/sau o parolă greșite!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
            </div>
            </body>
            </html>
            ';
        }
    } else {
        // Nume utilizator greșit
        echo '
        <p>Ați introdus un nume de utilizator și/sau o parolă greșite!<br>Pentru a reîncerca, faceți click <a href="autentificare.php">aici</a>.</p>
        </div>
        </body>
        </html>
        ';
    }

	$stmt->close();
    mysqli_close($db);
}
else {
    echo '
    <p>Eroare SQL!</p>
    </div>
    </body>
    </html>
    ';
}

?>
