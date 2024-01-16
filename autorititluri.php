<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <?php
            if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['cod_activare'] == 'activat') { ?>
                    <h2>Titlurile fiecărui autor</h2>
                    <div>
                        <?php include_once('db.php');

                        if ($stmt = $db->prepare('SELECT Id, Nume FROM Autori ORDER BY Nume')) {
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($id_autor, $nume_autor);

                            $autori = array();

                            while ($stmt->fetch()) {
                                $autori[] = ['id_autor' => $id_autor, 'nume_autor' => $nume_autor];
                            } ?>

                            <div>
                                <p>Vă prezentăm mai jos lista de titluri disponibile pentru fiecare autor în parte:</p>
                                <table>
                                    <tr>
                                        <td>Autor</td>
                                        <td>Titluri</td>
                                    </tr>

                                    <?php foreach ($autori as $autor) {
                                        $titluri = array();

                                        if ($stmt = $db->prepare('SELECT Titlu FROM TitluriAutori LEFT join Titluri on TitluId = Titluri.Id WHERE AutorId = ? ORDER BY Titlu')) {
                                            $stmt->bind_param('i', $autor['id_autor']);
                                            $stmt->execute();
                                            $stmt->store_result();
                                            $stmt->bind_result($titlu);

                                            while ($stmt->fetch()) {
                                                $titluri[] = ['titlu' => $titlu];
                                            }
                                        }
                                        else {
                                            $autori[] = ['titlu' => 'Eroare SQL!'];
                                        } ?>

                                        <tr>
                                            <td><?php echo $autor['nume_autor']; ?></td>
                                            <td>
                                                <?php foreach ($titluri as $titlu) { echo $titlu['titlu'] . '</br>';} ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        <?php $stmt->close();
                        }
                        else { ?>
                            <p>Eroare SQL!!</p>
                        <?php }
                        $db->close; ?>
                    </div>
                    <div>
                        <ul>
                            <li>Pentru a reveni acasă, click <a href=index.php>aici</a>.</li>
                            <li>Pentru a vizualiza titlurile disponibile împreună cu autorii fiecărui titlu, click <a href=autorititluri.php>aici</a>.</li>
                        </ul>
                    </div>
                <?php }
                else { ?>
                    <h2>Cont neactivat!</h2>
                    <div>
                        <p>Salut! Contul <strong><?php echo $_SESSION['name']; ?></strong> nu a fost activat. Vă rugăm să verificați adresa de email folosită la înregistrare pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.</p>
                    </div>
                <?php }
            }
            else {
                header('Location: index.php');
            } ?>
        </div>
    </body>
</html>
