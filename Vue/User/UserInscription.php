<!-- Vue/Inscription.php            -->
<div>
	<h1>Inscription</h1>

	<form action="Controller/UserController.php" method="POST">
		
		<label>nom</label>
		<input type="text" name="nom"><br>

		<label>prenom</label>
		<input type="text" name="prenom"><br>

		<label>email</label>
		<input type="email" name="email"><br>

		<label>password</label>
		<input type="password" name="password"><br>

		<input type="hidden" name="action" value="inscription"><br>
		<input type="submit" value="valider"><br>
	</form>

</div>