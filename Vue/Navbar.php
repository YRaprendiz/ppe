<!-- Vue/Navbar.php              -->
<!DOCTYPE html>
<html>
<head>
	<title>Hotel</title>
</head>
<body>
	<a href="index.php?page=">*|Accueil| </a>

	<a href="index.php?page=login">*|Login| </a><!--Public -->
	<a href="index.php?page=inscription">*|Inscription| </a><!--Public -->
	<a href="index.php?page=listUsers">*|List Users| </a><!--Admin -->
		<!--<a href="index.php?page=">----------</a>-->
	
	<a href="index.php?page=photos">*|Ajouter Photos| </a><!-- Admin-->
	<a href="index.php?page=photosList">*|List Photos| </a>	<!-- Public-->
	<!--<a href="index.php?page=">----------</a>-->

	<a href="index.php?page=chambreForm">*|Chambre Form| </a><!-- Admin-->
	<a href="index.php?page=chambresList">*|List Chambres| </a><!--Public -->
	<!--<a href="index.php?page=">----------</a>-->

	<a href="index.php?page=profil">*|Profil| </a><!-- Client-->
	<a href="index.php?page=deconnexion">*|Deconnexion| </a><!-- uSER CONNECTE -->
	<!--<a href="index.php?page=">----------</a>-->
	<!-- -->

	<?php
	if (isset($_SESSION['user'])) { 
?>
	<?php  echo $_SESSION['user']['Nom']; ?>,<?php echo $_SESSION['user']['User_role']; ?>
	<?php
	}else
?>
	