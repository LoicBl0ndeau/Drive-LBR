<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<meta name="Auteurs" content="Loïc BLONDEAU;Louis BOUBERT;Martin CAPELLE;Ilies BENSLAMA" />
		<link rel="stylesheet" type="text/css" href="style/login.css" />
		<link rel="icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="js/login.js"></script>
		<title>Connexion Drive - Les Briques Rouges</title>
	</head>
  <body>
		<img src="images/Plan de travail 10LogoFullBlanc.png" alt="Logo LBR Blanc" id="logo_login" />
		<p id="info_login"></p>
		<form method="post">
			<label for="identifiant">Identifiant</label><br />
      <input type="text" class="saisie" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" /><br />
			<br />
			<label for="mdp">Mot de passe</label><br />
      <input type="password" class="saisie" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" /><i class="bi bi-eye-slash" id="togglePassword"></i><br />
			<div class="mdpOublie">
				<a href="">Mot de passe oublié ?</a><br />
			</div>
			<br />
			<br />
			<div class="boutonConnexion">
				<button type="submit" id="bouton_login">Se connecter <img src="images/rocket_red.36c56db.svg" class="rocket" /></button>
			</div>
		</form>
		<?php
			session_start();
			if (isset($_POST['identifiant']) && isset($_POST['mdp'])){
				require('connexion.php');
				//La partie ci-dessous élimine toute attaque de type injection SQL et XSS
			  $username = stripslashes($_REQUEST['identifiant']); //enlève backslash
			  $username = mysqli_real_escape_string($conn, $username); //sauve les caractères spéciaux
			  $password = stripslashes($_REQUEST['mdp']); //enlève backslash
			  $password = mysqli_real_escape_string($conn, $password); //sauve les caractères spéciaux
				//print hash('sha256', $password);
			  $query = "SELECT * FROM `profil` WHERE email='$username' and MDP='".hash('sha256', $password)."'";
			  $result = mysqli_query($conn,$query) or die(mysql_error()); //exécute une requête sur la base de données
			  $rows = mysqli_num_rows($result); //retourne le nombre de lignes.
			  if($rows==1){
					$followingdata = $result->fetch_assoc();
			    $_SESSION['loggedUser'] = [
						'email' => $followingdata['email'],
						'Nom' => $followingdata['Nom'],
						'Prenom' => $followingdata['Prenom'],
						'Description' => $followingdata['Description'],
						'Role' => $followingdata['Role']
					];
					echo "<script>$('.rocket').css('animation','3s launch');</script><meta http-equiv='refresh' content='1.5; url=accueil.php' />";
			  }else{
			    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
					echo "<script>$('#info_login').text(\"".$message."\");$('.rocket').css('animation','.5s no');</script>";
			  }
			}
		?>
  </body>
</html>
