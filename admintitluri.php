<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <?php if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['rol'] == 'admin') {
                    if ($_SESSION['cod_activare'] == 'activat') { ?>
                        <h2>Administrare titluri</h2>
                            
                            <?php include_once('db.php');
                            
                            if ($stmt = $db->prepare('SELECT Id, Titlu FROM Titluri ORDER BY Titlu')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id_titlu, $titlu);
                                
                                $titluri = array();
                                
                                while ($stmt->fetch()) {
                                    $titluri[] = ['id_titlu' => $id_titlu, 'titlu' => $titlu];
                                } ?>
                                
                                <div>
                                    <p><strong>Listă titluri:</strong></p>
                                    <table>
                                        <tr>
                                            <td>Titlu</td>
                                            <td>Autori</td>
                                        </tr>
                                        
                                        <?php foreach ($titluri as $tit) {
                                            $autori = array();
                                            
                                            if ($stmt = $db->prepare('SELECT Nume FROM TitluriAutori LEFT join Autori on AutorId = Autori.Id WHERE TitluId = ? ORDER BY Nume')) {
                                                $stmt->bind_param('i', $tit['id_titlu']);
                                                $stmt->execute();
                                                $stmt->store_result();
                                                $stmt->bind_result($nume_autor);
                                                
                                                while ($stmt->fetch()) {
                                                    $autori[] = ['nume_autor' => $nume_autor];
                                                }
                                            }
                                            else {
                                                $autori[] = ['nume_autor' => 'Eroare SQL!'];
                                            } ?>
                                            
                                            <tr>
                                                <td><?php echo $tit['titlu']; ?></td>
                                                <td>
                                                    <?php foreach ($autori as $autor) { echo $autor['nume_autor'] . '</br>';} ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
            
                                <div>
                                    <p><strong>Adaugă titlu</strong></p>
                                    <p>TODO - Formular pentru a adăuga un titlu nou + backend-ul adaugatitlu.php.</p>
                                </div>
            
                                <div>
                                    <p><strong>Asociază autor la titlu</strong></p>
                                    <p>TODO - Formular pentru a asocia un autor la un titlu + backendu-ul asociazatitluautor.php.</p>
                                </div>
            
                                <div>
                                    <p><strong>Elimină autor de la titlu</strong></p>
                                    <p>TODO - Formular pentru a elimina un autor de la un titlu + backendu-ul eliminatitluautor.php.</p>
                                </div>
            
                                <div>
                                    <p><strong>Șterge titlu</strong></p>
                                    <p>TODO - Formular pentru a șterge un titlu + backend-ul stergetitlu.php. HINT: vrem când ștergem un titlu să-l eliminăm din tabela Titluri, dar vrem să curățăm și toate asocierile din tabela TitluriAutori</p>
                                </div>
            
                                <div>
                                    <p><strong><a href=administrare.php>Înapoi la administrare</a></strong></p>
                            </div>
            
                            <?php $stmt->close();
                                
                            }
                            else { ?>
                                <p>Eroare SQL!!</p>
                            <?php }
                            $db->close; ?>
                            
                        </div>
                    <?php }
                    else { ?>
                        <h2>Administrare titluri</h2>
                        <div>
                            <p>Acest profil are drepturi de administrator, însă nu a fost activat.<br> Vă rugăm verificați adresa de email asociată profilului pentru link-ul de activare!</p>
                        </div>
                    <?php }
                }
                else { ?>
                    <h2>Acces Interzis!</h2>
                    <div>
                    <p>Nu aveți acces la această secțiune a bibliotecii!</p>
                    </div>
                <?php }
            }
            else { ?>
                <h2>Administrare - autentificare necesară</h2>
                <div>
                    <p>Pentru a accesa această secțiune este nevoie să vă autentificați cu un profil de <strong>administrator</strong> <a href="autentificare.php">aici</a></p>
                </div>
            <?php } ?>
        </div>
    </body>
</html>

