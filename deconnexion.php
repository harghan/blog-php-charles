<?php 
	require_once('includes/header.php'); 
	setcookie('connexion_cookie','',-1); //We force the expiration of the cookie to disconnect the user
	$_SESSION["connexion"]='deco'; //A notification will appear to confirm the disconnection /!\ it will appear on the index.php/!\
	header('Location:index.php'); //We go back to the index.php
?>