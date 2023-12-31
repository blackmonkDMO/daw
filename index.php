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
                    <h2>Acasă</h2>
                    <p>Bine ai revenit <?php echo $_SESSION['name']; ?>.</p>
                <?php }
                else { ?>
                    <h2>Cont neactivat!</h2>
                    <p>Salut! Contul <?php echo $_SESSION['name']; ?> nu a fost activat. Vă rugăm să verificați adresa de email folosită la înregistrare pentru link-ul necesar activării.<br>Puteți face logout <a href=iesire.php>aici</a>.<br>Alternativ, puteți șterge acest cont <a href=stergere.php>aici</a>.</p>
                <?php }
            }
            else { ?>
                <h2>Motto</h2>
                <p>"Aceasta nu va fi niciodată o țară civilizată atâta timp cât cheltuim mai mulți bani pe guma de mestecat decât pe cărți."<br>Elbert Hubbard</p>
            <?php } ?>
        </div>
    </body>
</html>
