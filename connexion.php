<?php
	require_once('includes/header.php'); 
		
	//IF the Form containing Email & Mdp is filled
	if(var_post('email') && var_post('mdp')){
		$email=mysql_real_escape_string(var_post('email')); //Form values is stocked with POST method
		$mdp=mysql_real_escape_string(var_post('mdp'));
		$sql=mysql_query("SELECT id,email FROM utilisateurs WHERE email='".$email."' AND mdp='".$mdp."'"); //The Query try to retrieve the login and the pass in the Database
		
		//IF the query return something, meaning that the user exist
		if(mysql_fetch_array($sql)) { 
			$sid=md5($email.time()); // A sid is generated (md5 hash of a  mix of login and actual time)
			setcookie('connexion_cookie',$sid,time()+3600); //the sid is stocked in a cookie
			$update="UPDATE utilisateurs SET sid='".$sid."' WHERE email='".$email."'"; 
			mysql_query($update); // The query put the sid in the database
			$_SESSION["connexion"]='co'; //Notification to confirm the user is connected /!\ will appear on index.php /!\
			header('Location:index.php'); //Redirect to index.php
			exit();
			
		//if the query don't return something, meaning that the user doesn't exist OR he missed his login or pass
		}else{
			$_SESSION["connexion"]='no_user'; //Notification that the user isn't connected
			header('Location:connexion.php'); //Redirect to connection.php /!
			exit();
		}
		
	}
	//IF the user isn't connected yet the form is loaded
	if($connecte==false){
?>
		<h2>Connexion</h2>

		<p>Saisissez les identifiants choisis lors de votre inscription</p>

		<form action="connexion.php" method="post" id="form_connexion">

			<fieldset>
				<div class="clearfix">
					<label for="email">Email</label>
					<div class="input">
						<input id="email" name="email" size="30" type="email" value="" />
					</div>
				</div>
				
				<div class="clearfix">
					<label for="mdp">Mot de passe</label>
					<div class="input">
						<input id="mdp" name="mdp" size="15" type="password"/>
					</div>
				</div>
				
				<div class="form-actions">
					<input class="btn btn-large btn-primary" id="submit" type="submit" value="Se connecter" />
				</div>
			</fieldset>
		</form>

<?php 
	//IF the user is already connected, he will be automatically redirected to the index.php
	}else {
		header('Location:index.php');
	}

	include ('includes/footer.php');
?>   