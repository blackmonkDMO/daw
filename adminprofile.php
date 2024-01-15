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
                        <h2>Administrare profile</h2>
                            
                            <?php include_once('db.php');
                            if ($stmt = $db->prepare('SELECT Utilizator, Nume, Prenume, Email, Rol, CodActivare FROM Conturi')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($utilizator, $nume, $prenume, $email, $rol, $codactivare);
                                
                                $conturi = array();
                                
                                while ($stmt->fetch()) {
                                    $conturi[] = ['utilizator' => $utilizator, 'nume' => $nume, 'prenume' => $prenume, 'email' => $email, 'rol' => $rol, 'codactivare' => $codactivare];
                                } ?>
                                
                                <div>
                                    <p><strong>Listă profile</strong></p>
                                    <table>
                                        <tr>
                                            <td>Utilizator</td>
                                            <td>Nume</td>
                                            <td>Prenume</td>
                                            <td>Email</td>
                                            <td>Rol</td>
                                            <td>Stare</td>
                                        </tr> <?php
                                    foreach ($conturi as $cont) { ?>
                                        <tr>
                                            <td><?php echo $cont['utilizator']; ?></td>
                                            <td><?php echo $cont['nume']; ?></td>
                                            <td><?php echo $cont['prenume']; ?></td>
                                            <td><?php echo $cont['email']; ?></td>
                                            <td><?php echo $cont['rol']; ?></td>
                                            <td><?php if ($cont['codactivare'] == 'activat') { ?><font color=green>Activat</font><?php } else { ?><font color=red>Neactivat</font><?php } ?></td>
                                        </tr>
                                    <?php } ?>
                                    </table>
                                </div>
            
                                <div>
                                    <p><strong>Șterge un profil:</strong></p>
                                    <form action="stergeprofil.php" method="post">
                                        <fieldset>
                                            <label for="profil">Profil:</label>
                                            <select name="profil" id="profil">
                                                <?php foreach ($conturi as $cont) { 
                                                    if ($cont['rol'] == 'user') { // un admin poate șterge doar conturi normal, nu poate șterge conturile altor admini ?>
                                                        <option value="<?php echo $cont['utilizator']; ?>"><?php echo $cont['utilizator'] . ' / ' . $cont['email']; ?></option>
                                                    <?php }
                                                    
                                                } ?>
                                            </select>

                                            <label for="parola">Parola profilului tău:</label>
                                            <input type="password" name="parola" placeholder="Introdu parola contului tău de administrator pentru a șterge un profil" id="parola" required>
                                            <p>Prin bifarea check-boxului de mai jos confirmați că sunteți de acrod cu ștergerea profilului selectat. Datele profilului nu mai pot fi recuperate după ce este șters!</p>
                                            <input type="checkbox" id="confirmastergere" name="confirmastergere" value="confirmastergere">
                                            <label for="checkstergere">Sunt sigur</label>
                                            <input type="submit" value="Șterge profil">
                                        </fieldset>
                                    </form>
                                </div>
            
                                <div>
                                    <p><strong>Promovează un profil la rol de administrator:</strong></p>
                                    <form action="promoveazaprofil.php" method="post">
                                        <fieldset>
                                            <label for="profil">Profil:</label>
                                            <select name="profil" id="profil">
                                                <?php foreach ($conturi as $cont) { 
                                                    if ($cont['rol'] == 'user') { // se pot promova doar conturile cu rol user ?>
                                                        <option value="<?php echo $cont['utilizator']; ?>"><?php echo $cont['utilizator'] . ' / ' . $cont['email']; ?></option>
                                                    <?php }
                                                    
                                                } ?>
                                            </select>

                                            <label for="parola">Parola profilului tău:</label>
                                            <input type="password" name="parola" placeholder="Introdu parola contului tău de administrator pentru a promova un profil" id="parola" required>
                                            <p>Prin bifarea check-boxului de mai jos confirmați că sunteți de acord cu promovarea profilului selectat. Operația este ireversibilă! Singurul mod prin care un admin poate fi șters este dacă el însuși decide să-și șteargă profilul!</p>
                                            <input type="checkbox" id="confirmapromovare" name="confirmapromovare" value="confirmapromovare">
                                            <label for="checkpromovare">Sunt sigur</label>
                                            <input type="submit" value="Promovează profil">
                                        </fieldset>
                                    </form>
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
                        <h2>Administrare profile</h2>
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

