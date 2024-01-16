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
            <h2>Șterge autor</h2>
            
            <?php if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['rol'] == 'admin') {
                    if ($_SESSION['cod_activare'] == 'activat') {
                        
                        // Check-uri:
                        if (!isset($_POST['autor'], $_POST['confirmastergere'],)) { ?>
                            <div>
                                <p>Pentru a șterge un autor vă rugăm să completați formularul <strong>Șterge un autor</strong> de <a href=adminautori.php>aici</a>!</p>
                            </div></body></html>
                            <?php exit;
                        }
                        
                        if (empty($_POST['autor']) || empty($_POST['confirmastergere'])) { ?>
                            <div>
                                <p>Nu ați completat toate datele necesare!</p>
                            </div>
                            <?php $is_error = True;
                        }
                        
                        include_once('db.php');
                        
                        if ($stmt = $db->prepare('Select * from Autori WHERE Id = ?')) {
                            $stmt->bind_param('i', $_POST['autor']);
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows == 0) { // Autorul nu există există ?>
                                <div>
                                    <p>Autorul nu există!</p>
                                </div>
                                <?php $is_error = True;
                            }
                            $stmt->close();
                        }
                        else { ?>
                            <div><p>Eroare SQL!</p></div>
                            <?php $is_error = True;
                        }
                        
                        // sfârșit check-uri, verificăm dacă avem vreo eroare înainte de a continua
                        
                        if ($is_error == True) { ?>
                            <div>
                                <p>Au fost detectate una sau mai multe probleme cu datele introduse în vederea ștergerii unui autor.<br>Vă rugăm să verificați informațiile de mai sus, și să reîncercați completând formularul <strong>Șterge un autor</strong> de <a href=adminautori.php>aici</a>.</p>
                            </div>
                        <?php }
                        else { // dacă nu avem erori continuăm
                            // Ștergerea efectivă a autorului
                            
                            if ($stmt = $db->prepare('SELECT Id FROM TitluriAutori WHERE AutorId = ?')) {
                                $stmt->bind_param('i', $autor['id_autor']);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows > 0) {  // verificam ca autorul sa nu fie asociat unui titlu existent ?>
                                    <div>
                                        <p>Autorul nu poate fi șters pentru că încă are titluri asociate!.</p>
                                        <p>Pentru a reveni la administrarea autorilor click <a href="adminautori.php">aici</a>.</p>
                                    </div>
                                <?php }
                                else { //ștergem autorul:
                                    if ($stmt = $db->prepare('DELETE FROM Autori WHERE Id = ?')) {
                                        $stmt->bind_param('i', $_POST['autor']);
                                        $stmt->execute(); ?>

                                        <div>
                                            <p>Am șters Autorul cu id <strong><?php echo $_POST['autor']; ?></strong></p>
                                            <p>Pentru a reveni la administrarea autorilor click <a href="adminautori.php">aici</a>.</p>
                                        </div>

                                        <?php $stmt->close;
                                    }
                                    else { ?>
                                        <div>
                                            <p>Eroare SQL!</p>
                                        </div>
                                    <?php }
                                }
                                $stmt->close;
                            }
                            else { ?>
                                <div>
                                    <p>Eroare SQL!</p>
                                </div>
                            <?php } 
                        }
                        $db->close();
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