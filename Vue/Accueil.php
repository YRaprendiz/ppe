<!-- Vue/Accueil.php            -->
    <div>
	<h1>page Accueil</h1>

<?php
	if (isset($_SESSION['user'])) { 
?>
	<h1>Bienvenu vous etes connecté <?php echo $_SESSION['user']['Email']; ?></h1>
<?php
	}else
?>
		<h1>Bienvenu<h1>
</div>