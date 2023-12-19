<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Autentificare</title>
		<script src="https://kit.fontawesome.com/e9d05e6757.js" crossorigin="anonymous"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Autentificare</h1>
			<form action="autentifica.php" method="post">
				<label for="utilizator">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="utilizator" placeholder="Utilizator" id="utilizator" required>
				<label for="parola">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="parola" placeholder="Parolă" id="parola" required>
				<input type="submit" value="Intră">
			</form>
		</div>
	</body>
</html>