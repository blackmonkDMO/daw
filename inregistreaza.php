<?php
session_start();
$is_error = False;
?>

<!DOCTYPE html>

<html>
<?php include_once ('header.php'); ?>
    <body class="loggedin">
<?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Înregistrare</h2>

<?php if (!isset($_POST['nume'], $_POST['prenume'], $_POST['utilizator'], $_POST['parola'], $_POST['email'])) { ?>
            <p>Pentru înregistrare vă rugăm să completați formularul de <a href=inregistrare.php>aici</a>!</p>
        </div>
    </body>
</html>
    <?php exit;
}

if (empty($_POST['nume']) || empty($_POST['prenume']) ||empty($_POST['utilizator']) || empty($_POST['parola']) || empty($_POST['email'])) { ?>
            <p>Nu ați completat toate datele necesare!</p>
    <?php $is_error = True;
}
            
if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț-]+$/', $_POST['nume']) == 0) { ?>
            <p>Numele <strong><?php echo $_POST['nume']; ?></strong> nu este unul valid. Numele poate conține litere mari, litere mici, cifre și caracterul "-"!</p>
    <?php $is_error = True;
}
            
if (strlen($_POST['nume']) > 50) { ?>
            <p>Numele <strong><?php echo $_POST['nume']; ?></strong> este prea lung! Vă rugăm să folosiți un nume mai scurt.</p>
    <?php $is_error = True;
}
            
if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț-]+$/', $_POST['prenume']) == 0) { ?>
            <p>Prenumele <strong><?php echo $_POST['prenume']; ?></strong> nu este unul valid. Prenumele poate conține litere mari, litere mici, cifre și caracterul "-"!</p>
    <?php $is_error = True;
}
            
if (strlen($_POST['prenume']) > 50) { ?>
            <p>Prenumele <strong><?php echo $_POST['prenume']; ?></strong> este prea lung! Vă rugăm să folosiți un prenume mai scurt.</p>
    <?php $is_error = True;
}

if (preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['utilizator']) == 0) { ?>
            <p>Numele de utilizator <strong><?php echo $_POST['utilizator']; ?></strong> nu este unul valid. Numele de utilizator poate conține litere mari, litere mici, cifre și caracterele "-" sau "_"! Nu poate conține diacritice!</p>
    <?php $is_error = True;
}
            
if (strlen($_POST['utilizator']) > 50) { ?>
            <p>Numele de utilizator <strong><?php echo $_POST['utilizator']; ?></strong> este prea lung! Vă rugăm să folosiți un nume de utilizator mai scurt.</p>
    <?php $is_error = True;
}

if (strlen($_POST['parola']) > 20 || strlen($_POST['parola']) < 5) { ?>
            <p>Parola aleasă trebuie să aibă între 5 și 20 de caractere!</p>
    <?php $is_error = True;
}
            
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { ?>
            <p>Adresa de email introdusă nu este validă!</p>
    <?php $is_error = True;
}

if (strlen($_POST['email']) > 100) { ?>
            <p>Adresa de email <strong><?php echo $_POST['email']; ?></strong> este prea lungă! Vă rugăm să folosiți o adresă de email mai scurtă.</p>
    <?php $is_error = True;
}

if ($is_error == True) { ?>
            <p>Au fost detectate una sau mai multe probleme cu datele introduse în vederea înregistrării.<br>Vă rugăm să verificați informațiile de mai sus, și să reîncercați înregistrarea <a href=inregistrare.php>aici</a>.</p>
        </div>
    </body>
</html>
<?php }

else {
    include_once('db.php');

    if ($stmt = $db->prepare('SELECT Id FROM Conturi WHERE Email = ?')) {
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) { // Email already exists
            $stmt->close();
            $db->close(); ?>
            <p>Adresa de email <strong><?php echo $_POST['email']; ?></strong> este deja folosită! Vă rugăm să folosiți o altă adresă de email. Puteți reîncerca <a href=inregistrare.php>aici</a>!</p>
        </div>
    </body>
</html>
            <?php exit;
	    }
        $stmt->close();
    }
    else { ?>
            <p>Eroare SQL!</p>
        </div>
    </body>
</html>
        <?php $db->close();
        exit;
    }

    if ($stmt = $db->prepare('SELECT Id, Parola FROM Conturi WHERE Utilizator = ?')) {
        $stmt->bind_param('s', $_POST['utilizator']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) { // Utilizator already exists ?>
            <p>Numele de utilizator <strong><?php echo $_POST['utilizator']; ?></strong> este deja folosit! Vă rugăm să alegeți altul. Puteți reîncerca <a href=inregistrare.php>aici</a>!</p>
        </div>
    </body>
</html>
            <?php $stmt->close();
            $db->close();
            exit;
        }
        else { // Utilizator doesn't exists, insert new account
            if ($stmt = $db->prepare('INSERT INTO Conturi (Nume, Prenume, Utilizator, Parola, Rol, Email, CodActivare) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
                $password = password_hash($_POST['parola'], PASSWORD_DEFAULT);
                $rol = 'user';
                $uniqid = uniqid();
                $stmt->bind_param('sssssss', $_POST['nume'], $_POST['prenume'], $_POST['utilizator'], $password, $rol, $_POST['email'], $uniqid);
                $stmt->execute();
            
                $from = 'noreply@blackmonk.ro';
                $subject = 'daw.blackmonk.ro - Este necesara activarea contului';
                $headers = 'From: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8';
                $link_activare = 'https://daw.blackmonk.ro/activare.php?email=' . $_POST['email'] . '&cod=' . $uniqid;
                $message = '<p>Pentru a vă activa contul creat pe daw.blackmonk.ro vă rugăm să accesați acest link: <a href="' . $link_activare . '">' . $link_activare . '</a></p>';
            
                mail($_POST['email'], $subject, $message, $headers); ?>

            <p>Ai fost înregistrat cu succes!<br>Un email cu un link necesar activării noului tău cont a fost trimis către <strong><?php echo $_POST['email']; ?></strong>.<br>Te rugăm să urmezi instrucțiunile prezente în respectivul email.</p>
        </div>
    </body>
</html>
                <?php $stmt->close();
                $db->close();
                exit;
            }
            else { ?>
            <p>Eroare SQL!</p>
        </div>
    </body>
</html>
                <?php $db->close();
                exit;
            }
        }
        $stmt->close();
        $db->close();
    }
    else { ?>
            <p>Eroare SQL!</p>
        </div>
    </body>
</html>
        <?php $db->close();
        exit;
    }
}

?>


