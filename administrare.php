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
                        <h2>Administrare</h2>
                        <div>
                            <p>Sunteți administrator al acestei biblioteci!</p>
                            <ul>
                                <li><a href=adminprofile.php>Administrează profile</a></li>
                                <li><a href=adminautori.php>Administrează autori</a></li>
                                <li><a href=admintitluri.php>Administrează titluri</a></li>
                            </ul>
                        </div>
                    <?php }
                    else { ?>
                        <h2>Administrare</h2>
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

