<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Înregistrare</title>
		<script src="https://kit.fontawesome.com/e9d05e6757.js" crossorigin="anonymous"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Înregistrare</h1>
			<form action="inregistreaza.php" method="post" autocomplete="off">
                <label for="nume"><i class="fa-solid fa-person"></i></label>
				<input type="text" name="nume" placeholder="Nume" id="nume" required>
                <label for="prenume"><i class="fa-solid fa-person"></i></label>
				<input type="text" name="prenume" placeholder="Prenume" id="prenume" required>
				<label for="utilizator"><i class="fas fa-user"></i></label>
				<input type="text" name="utilizator" placeholder="Nume Utilizator (nickname)" id="utilizator" required>
				<label for="parola"><i class="fas fa-lock"></i></label>
				<input type="password" name="parola" placeholder="Parolă" id="parola" required>
				<label for="email"><i class="fas fa-envelope"></i></label>
				<input type="email" name="email" placeholder="Email" id="email" required>
				<input type="submit" value="Înregistrează">
			</form>
		</div>
	</body>
</html>
