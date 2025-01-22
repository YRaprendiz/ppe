<!-- Vue/UserLogin.php          -->
<div>
	<h1>Login</h1>

	<form action="Controller/UserController.php" method="POST">
		
		<label>email</label>
		<input type="email" name="email"><br>

		<label>password</label>
		<input type="password" name="password"><br>

		<input type="hidden" name="action" value="login"><br>
		<input type="submit" value="valider"><br>
	</form>

</div>