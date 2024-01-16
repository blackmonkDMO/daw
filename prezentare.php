<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body class="loggedin">
        <?php include_once ('navtop.php'); ?>
        <div class="content">
            <h2>Prezentare proiect - Biblioteca BMK</h2>
            <div>
                <p>Aplicația <strong>Biblioteca BMK</strong> se vrea a fi un portal de prezentare a cărților disponibile pentru împrumut către utilizatori, cu posibilitatea de a gestiunea împrumuturile respective.</p>
                <p>Până în acest moment, sunt funcționale următoarele funcții:</p>
                <ul>
                    <li>Formular de înregistrare cu email de confirmare</li>
                    <li>Formular de autentificare</li>
                    <li>Două categorii de utilizatori:
                        <ul>
                            <li>user - utilizator normal:
                                <ul>
                                    <li>poate vizualiza titlurile și autorii disponibili în bibliotecă</li>
                                    <li>își poate modifica detaliile profilului: nume, prenume, email, parolă</li>
                                    <li>la modificarea adresei de email este necesară reactivarea profilului cu ajutorul unui link transmis pe noua adresă de email</li>
                                    <li>își poate șterge profilul</li>
                                    <li>nu are acces la alte secțiuni ale aplicației</li>
                                </ul>
                            </li>
                            <li>admin - administrator al aplicației/bibliotecii:
                                <ul>
                                    <li>are acces la toate secțiunile la care are acess și un utilizator normal</li>
                                    <li>are acces la tool-uri de administrare:
                                        <ul>
                                            <li>administrare profile:
                                                <ul>
                                                    <li>poate vizualiza profilele existente</li>
                                                    <li>poate șterge un profil al unui utilizator normal, dar nu poate șterge profilul unui alt admin</li>
                                                    <li>poate promova un utilizator la rangul de admin</li>
                                                </ul>
                                            </li>
                                            <li>administrare autori:
                                                <ul>
                                                    <li>poate vizualiza autorii existenți</li>
                                                    <li>poate șterge un autor, dar doar dacă acest autor nu are titluri asociate</li>
                                                    <li>poate adăuga autori</li>
                                                </ul>
                                            </li>
                                            <li>administrare titluri:
                                                <ul>
                                                    <li>poate vizualiza titlurile existente</li>
                                                    <li><font color=red>nu sunt implementate încă funcții de adăugare, asociere, eliminare sau ștergere pentru titluri</font></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>își poate șterge profilul, dar doar dacă mai există minim un administrator înregistrat în aplicație</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <p>Baza de date din spatele aplicației are în acest moment următoarea structură:</p>
                <p><code>
                        CREATE OR REPLACE TABLE Autori (</br>
                        Id INT NOT NULL AUTO_INCREMENT,</br>
                        Nume VARCHAR(70) NOT NULL,</br>
                        Nationalitate VARCHAR(100) NOT NULL,</br>
                        PRIMARY KEY(Id)</br>
                    );</br>
                    </br>
                    CREATE OR REPLACE TABLE Titluri (</br>
                        Id INT NOT NULL AUTO_INCREMENT,</br>
                        Titlu VARCHAR(50) NOT NULL,</br>
                        PRIMARY KEY(Id)</br>
                    );</br>
                    </br>
                    CREATE OR REPLACE TABLE TitluriAutori (</br>
                        Id INT NOT NULL AUTO_INCREMENT,</br>
                        AutorId INT NOT NULL,</br>
                        TitluId  INT NOT NULL,</br>
                        FOREIGN KEY (AutorId) REFERENCES Autori(Id),</br>
                        FOREIGN KEY (TitluId) REFERENCES Titluri(Id),</br>
                        PRIMARY KEY(Id)</br>
                    );</br>
                    </br>
                    CREATE OR REPLACE TABLE Conturi (</br>
                        Id INT NOT NULL AUTO_INCREMENT,</br>
                        Nume VARCHAR(50) NOT NULL,</br>
                        Prenume VARCHAR(50) NOT NULL,</br>
                        Utilizator VARCHAR(50) NOT NULL,</br>
                        Parola VARCHAR(255) NOT NULL,</br>
                        Rol VARCHAR(50) NOT NULL,</br>
                        Email VARCHAR(100) NOT NULL,</br>
                        CodActivare VARCHAR(50) NOT NULL,</br>
                        PRIMARY KEY (Id),</br>
                        UNIQUE (Utilizator),</br>
                        UNIQUE (Email)</br>
                    );</br>
                </code></p>
            </div>
        </div>
    </body>
</html>
