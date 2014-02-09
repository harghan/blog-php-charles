<?php 

	mysql_connect('localhost','root',''); //Database connection
	mysql_select_db('bloghello'); //Database selection
	session_start();

	$connecte=false; //Until the user isn't recognized in the database, the connection isn't allowed
	
	//Cookie managing
	if(isset($_COOKIE['connexion_cookie'])){ 
		$cookie=mysql_real_escape_string($_COOKIE['connexion_cookie']); //Retrieving the cookie with get method
		$req=mysql_query("SELECT count(*) as 'connect' FROM utilisateurs WHERE sid='".$cookie."';"); //Looking on the database who is trying to connect
		$conn=mysql_fetch_array($req,MYSQL_ASSOC);
	
		//If the user is recognized, the connection is allowed
		if ($conn['connect'] == 1) { 
			$connecte=true;
			$req=mysql_query("SELECT email FROM utilisateurs WHERE sid='".$cookie."';");
			$mail=mysql_fetch_array($req,MYSQL_ASSOC);
			echo "<div class='alert'>Bonjour ".$mail['email'].", vous etes log en tant qu'administrateur</div>"; //notification is the user is connected
		}
	}
?>