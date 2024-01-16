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
                        <h2>Administrare autori</h2>
                            
                            <?php include_once('db.php');
                            if ($stmt = $db->prepare('SELECT Id, Nume, Nationalitate FROM Autori ORDER BY NUME')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id_autor, $nume_autor, $nationalitate);
                                
                                $autori = array();
                                
                                while ($stmt->fetch()) {
                                    $autori[] = ['id_autor' => $id_autor, 'nume_autor' => $nume_autor, 'nationalitate' => $nationalitate];
                                } ?>
                                
                                <div>
                                    <p><strong>Listă autori:</strong></p>
                                    <table>
                                        <tr>
                                            <td>Autor</td>
                                            <td>Naționalitate</td>
                                        </tr> <?php
                                    foreach ($autori as $autor) { ?>
                                        <tr>
                                            <td><?php echo $autor['nume_autor']; ?></td>
                                            <td><?php echo $autor['nationalitate']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </table>
                                </div>
            
                                <div>
                                    <p><strong>Șterge un autor:</strong></p>
                                    <form action="stergeautor.php" method="post">
                                        <fieldset>
                                            <label for="autor">Autor:</label>
                                            <select name="autor" id="autor">
                                                <?php foreach ($autori as $autor) {
                                                    if ($stmt = $db->prepare('SELECT Id FROM TitluriAutori WHERE AutorId = ?')) {
                                                        $stmt->bind_param('i', $autor['id_autor']);
                                                        $stmt->execute();
                                                        $stmt->store_result();
                                                        if ($stmt->num_rows == 0) {  // verificam ca autorul sa nu fie asociat unui titlu existent ?>
                                                            <option value="<?php echo $autor['id_autor']; ?>"><?php echo $autor['nume_autor']; ?></option>
                                                        <?php }
                                                    }
                                                    else { ?>
                                                        <option value="eroare">Eroare SQL!</option>
                                                    <?php }
                                                    
                                                } ?>
                                            </select>
                                            <p>Prin bifarea check-boxului de mai jos confirmați că sunteți de acord cu ștergerea autorului selectat.</p>
                                            <input type="checkbox" id="confirmastergere" name="confirmastergere" value="confirmastergere">
                                            <label for="checkstergere">Sunt sigur</label>
                                            <input type="submit" value="Șterge autor">
                                        </fieldset>
                                    </form>
                                </div>
            
                                <div>
                                    <p><strong>Adaugă un autor:</strong></p>
                                    <form action="adaugaautor.php" method="post">
                                        <fieldset>
                                            <label for="autor">Autor:</label>
                                            <input type="text" name="nume_autor" placeholder="Nume autor" id="nume_autor" required>
                                            <label for="autor">Nationalitate:</label>
                                            <input type="text" name="nationalitate" placeholder="Naționalitate autor" id="nationalitate" required>
                                            <p>Prin bifarea check-boxului de mai jos confirmați că sunteți de acord cu adăugarea autorului.</p>
                                            <input type="checkbox" id="confirma" name="confirma" value="confirma">
                                            <label for="check">Sunt sigur</label>
                                            <input type="submit" value="Adauga autor">
                                        </fieldset>
                                    </form>
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
                        <h2>Administrare autori</h2>
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

