<?php

session_start();

echo '<!DOCTYPE html>';
echo '<html>';
include_once ('header.php');
echo '<body class="loggedin">';
include_once ('navtop.php');

if (isset($_GET['email'], $_GET['cod'])) {
    include_once('db.php');
    
	if ($stmt = $db->prepare('SELECT * FROM Conturi WHERE Email = ? AND CodActivare = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['cod']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			if ($stmt = $db->prepare('UPDATE Conturi SET CodActivare = ? WHERE Email = ? AND CodActivare = ?')) {
				$newcode = 'activat';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['cod']);
				$stmt->execute();
                echo '
                <div class="content">
                    <h2>Activare cont</h2>
                    <p>Contul tău a fost activat! Acum te poți autentifica <a href=autentificare.php>aici</a>!</p>
                </div>
                </body>
                </html>
               ';
                $stmt->close;
			}
            else {
                echo '
                <div class="content">
                    <h2>Activare cont</h2>
                    <p>Eroare SQL!</p>
                </div>
                </body>
                </html>
               ';
            }
		}
        else {
            echo '
            <div class="content">
                <h2>Activare cont</h2>
                <p>Eroare! Contul nu a putut fi activat (nu există, a fost deja activat, sau a apărut o altă eroare)!</p>
            </div>
            </body>
            </html>
            ';
		}
        $stmt->close;
	}
    else {
        echo '
        <div class="content">
            <h2>Activare cont</h2>
            <p>Eroare SQL!</p>
        </div>
        </body>
        </html>
	   ';
    }
    $db->close();
}
else {
    echo '
    <div class="content">
        <h2>Activare cont</h2>
        <p>A apărut o eroare! Poate ați accesat un link greșit?</p>
    </div>
    </body>
    </html>
	';
    exit;
}

?>