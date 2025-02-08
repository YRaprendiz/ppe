<?php
session_start();

// Destroy the user session
session_unset();
session_destroy();

// Redirect to the homepage or login page
header("Location: ../../index.php");
exit();
?>