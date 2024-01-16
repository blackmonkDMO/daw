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
                    <h2>Titluri</h2>
                    <div>
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
                                <p>Vă prezentăm mai jos lista de titluri disponibile, împreună cu autorul(ii) fiecăreia dintre ele:</p>
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
                            <li>Pentru a vizualiza titlurile disponibile pentru fiecare autor în parte, click <a href=autorititluri.php>aici</a>.</li>
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
