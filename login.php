<?php
	// Défini le fuseau horaire à utilisateur
	date_default_timezone_set('Europe/Paris');

?>

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
				require('connect.php');
			  $query = "SELECT * FROM profil WHERE email=? and MDP=? limit 1";
			  $resultStatement = $PDO->prepare($query);
				$resultStatement->execute(array(strip_tags($_POST['identifiant']),hash('sha256', strip_tags($_POST['mdp']))));
				$result = $resultStatement->fetchAll();
				if(count($result) > 0){
					$_SESSION['loggedUser'] = [
						'Id_Profil' => $result[0]['Id_Profil'],
						'email' => $result[0]['email'],
						'Nom' => $result[0]['Nom'],
						'Prenom' => $result[0]['Prenom'],
						'Description' => $result[0]['Description'],
						'Role' => $result[0]['Role']
					];
					echo "<script>$('.rocket').css('animation','3s launch');</script><meta http-equiv='refresh' content='1.5; url=accueil.php' />";

					//   ajout d'une ligne dans le changelog
					try
					{
						$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
					}
					catch (Exception $e)
					{
									die('Erreur : ' . $e->getMessage());
					}
					// Ecriture de la requête
					$sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

					// Préparation
					$changelog_login = $mysqlClient->prepare($sqlQuery);

					// Exécution ! l'utilisateur est maintenant en base de données
					$changelog_login->execute([
							'Nom' => $_SESSION['loggedUser']['Nom'],
							'Date_de_modification' => date('d-m-y h:i:s'),
							'Description' => "Connexion du compte " . $_SESSION['loggedUser']['Id_Profil'] . " : " . $_SESSION['loggedUser']['email'] . " / " . $_SESSION['loggedUser']['Nom'] . " / " . $_SESSION['loggedUser']['Prenom'],
					]);

				}
				else{
					$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
					echo "<script>$('#info_login').text(\"".$message."\");$('.rocket').css('animation','.5s no');</script>";
				}
			}
		?>
  </body>
</html>
