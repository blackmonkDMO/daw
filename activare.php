<?php session_start(); ?>

<!DOCTYPE html>'
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">';
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Activare cont</h2>
        
        <?php if (isset($_GET['email'], $_GET['cod'])) {
            include_once('db.php');
            if ($stmt = $db->prepare('SELECT * FROM Conturi WHERE Email = ? AND CodActivare = ?')) {
                $stmt->bind_param('ss', $_GET['email'], $_GET['cod']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0 && $_GET['cod'] != 'activat') { // mail și cod fac match pe o înregistrare din db
                    if ($stmt = $db->prepare('UPDATE Conturi SET CodActivare = ? WHERE Email = ? AND CodActivare = ?')) {
                        $newcode = 'activat';
                        $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['cod']);
                        $stmt->execute(); ?>
                        <p>Contul tău a fost activat! Acum te poți autentifica <a href=autentificare.php>aici</a>!</p>
                        <?php $stmt->close;
                    }
                    else { ?>
                        <p>Eroare SQL!</p>
                    <?php }
                }
                else {  // mail și cod nu fac match pe înregistrare din db ?>
                    <p>Eroare! Contul nu a putut fi activat (nu există, a fost deja activat, sau a apărut o altă eroare)!</p> 
                <?php }
                $stmt->close;
            }
            else { ?>
                <p>Eroare SQL!</p>
            <?php }
            $db->close();
        }
        else { ?>
            <p>A apărut o eroare! Poate ați accesat un link greșit?</p>
        <?php } ?>
        </div>
    </body>
</html>
