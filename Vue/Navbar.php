<!-- Vue/Navbar.php              -->
<!DOCTYPE html>
<html>
<head>
	<title>Mon super projet de connexion</title>
</head>
<body>
	<a href="index.php?page=">Accueil</a>
	<a href="index.php?page=login">login</a>
	<a href="index.php?page=inscription">inscription</a>
	<a href="index.php?page=profil">profil</a>
	<a href="index.php?page=deconnexion">deconnexion</a>
	<a href="index.php?page=photos">ajouterPhotos</a>
	<a href="index.php?page=ajouterChambre">ajouterChambre</a>
	<a href="index.php?page=chambres">chambres</a>
	<a href="index.php?page=reservations">reservations</a>

	

	<?php
	if (isset($_SESSION['user'])) { 
?>
	<?php  echo $_SESSION['user']['Nom']; ?>
	<?php echo $_SESSION['user']['User_role']; ?>
	<?php
	}else
?>
	