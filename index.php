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
                    <div>
                        <p>Bine ai revenit <?php echo $_SESSION['name']; ?>.</p>
                    </div>
            
                    <div>
                        <ul>
                            <li>Pentru a vizualiza titlurile disponibile împreună cu autorii fiecărui titlu, click <a href=titluri.php>aici</a>.</li>
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
            else { ?>
                <h2>Motto</h2>
                <div>
                    <p>"Aceasta nu va fi niciodată o țară civilizată atâta timp cât cheltuim mai mulți bani pe guma de mestecat decât pe cărți."<br>Elbert Hubbard</p>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
