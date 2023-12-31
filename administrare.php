<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include_once ('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <?php if ($_SESSION['loggedin'] == True) {
                if ($_SESSION['rol'] == 'admin') { ?>
                    <h2>Administrare</h2>
                    <p>Felicitări! Sunteți administrator al acestestei biblioteci!</p>
                <?php }
                else { ?>
                    <h2>Acces Interzis!</h2>
                    <p>Nu aveți acces la această secțiune a bibliotecii!</p>
                <?php }
            }
            else { ?>
                <h2>Administrare - autentificare necesară</h2>
                <p>Pentru a accesa această secțiune este nevoie să vă autentificați cu un cont de <strong>administrator</strong> <a href="autentificare.php">aici</a></p>
            <?php } ?>
        </div>
    </body>
</html>

