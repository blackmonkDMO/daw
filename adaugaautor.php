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
            <h2>Adaugă autor</h2>
            
            <?php if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['rol'] == 'admin') {
                    if ($_SESSION['cod_activare'] == 'activat') {
                        //Check-uri:
                        if (!isset($_POST['nume_autor'], $_POST['nationalitate'], $_POST['confirma'],)) { ?>
                            <div>
                                <p>Pentru a adăuga un autor vă rugăm să completați formularul <strong>Adaugă un autor</strong> de <a href=adminautori.php>aici</a>!</p>
                            </div></body></html>
                            <?php exit;
                        }
                        
                        if (empty($_POST['nume_autor']) || empty($_POST['nationalitate']) || empty($_POST['confirma'])) { ?>
                            <div>
                                <p>Nu ați completat toate datele necesare!</p>
                            </div>
                            <?php $is_error = True;
                        }
                        
                        if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț -]+$/', $_POST['nume_autor']) == 0) { ?>
                            <div>
                                <p>Numele <strong><?php echo $_POST['nume_autor']; ?></strong> nu este unul valid. Numele autorului poate conține litere mari, litere mici, cifre, caracterul "-" și spații!</p>
                            </div>
                            <?php $is_error = True;
                        }
                        
                        if (preg_match('/^[a-zA-Z0-9ĂăÎîȘșȚț-]+$/', $_POST['nationalitate']) == 0) { ?>
                            <div>
                                <p>Naționalitatea <strong><?php echo $_POST['nationalitate']; ?></strong> nu este una validă. Naționalitatea poate conține litere mari, litere mici, cifre și caracterul "-"!</p>
                            </div>
                            <?php $is_error = True;
                        }
                        
                        if ($is_error == True) { ?>
                            <div>
                                <p>Au fost detectate una sau mai multe probleme cu datele introduse în vederea adăugării unui autor.<br>Vă rugăm să verificați informațiile de mai sus, și să reîncercați completând formularul <strong>Adaugă un autor</strong> de <a href=adminautori.php>aici</a>.</p>
                            </div>
                        <?php }
                        else {
                            //Addăugare efectivă a autorului
                            include_once('db.php');
                            
                            if ($stmt = $db->prepare('INSERT INTO Autori (Nume, Nationalitate) VALUES (?, ?)')) {
                                $stmt->bind_param('ss', $_POST['nume_autor'], $_POST['nationalitate']);
                                $stmt->execute();
                                $stmt->close(); ?>
                                <div>
                                    <p>Am adăugat autorul <strong><?php echo $_POST['nume_autor'] ?></strong> cu naționalitatea <strong><?php echo $_POST['nationalitate']; ?></strong>.</p>
                                    <p>Puteți reveni la pagina de administrare autori <a href="adminautori.php">aici</a>.</p>
                                </div>
                            <?php }
                            else { ?>
                                <div><p>Eroare SQL!</p></div>
                            <?php }
                            $db->close();
                        }
                    }
                    else { ?>
                        <div>
                            <p>Acest profil are drepturi de administrator, însă nu a fost activat.<br> Vă rugăm verificați adresa de email asociată profilului pentru link-ul de activare!</p>
                        </div>
                    <?php }
                }
                else { ?>
                    <div>
                        <p>Nu aveți acces la această secțiune a bibliotecii!</p>
                    </div>
                <?php }
            }
            else { ?>
                <div>
                    <p>Pentru a accesa această secțiune este nevoie să vă autentificați cu un profil de <strong>administrator</strong> <a href="autentificare.php">aici</a></p>
                </div>
            <?php } ?>
        </div>
    </body>
</html>