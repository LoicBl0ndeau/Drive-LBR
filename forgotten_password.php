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
			<label for="identifiant_bis">Confirmation de l'identifiant</label><br />
      <input type="text" class="saisie" id="identifiant_bis" name="identifiant_bis" placeholder="Confirmez votre identifiant" /><br />
			<div class="mdpOublie">
				<a href="login.php">Retour à la page de connexion</a><br />
			</div>
			<br />
			<br />
			<div class="boutonConnexion">
				<button type="submit" id="bouton_login">Envoyer un mail<img src="images/rocket_red.36c56db.svg" class="rocket" /></button>
			</div>
		</form>
		<?php

			$postData = $_POST;

			if (isset($_POST['identifiant']) && isset($_POST['identifiant_bis']))
      {
				$identifiant = strip_tags($postData['identifiant']);
				$identifiant_bis = strip_tags($postData['identifiant_bis']);

        if ($identifiant===$identifiant_bis)
        {
          require('connect.php');
  			  $query = "SELECT * FROM profil WHERE email=? limit 1";
  			  $resultStatement = $PDO->prepare($query);
  				$resultStatement->execute(array(strip_tags($_POST['identifiant'])));
  				$result = $resultStatement->fetchAll();
  				if(count($result) > 0)
          {
  					$users['FP_User'] = [
  						'Id_Profil' => $result[0]['Id_Profil'],
  						'email' => $result[0]['email'],
  						'Nom' => $result[0]['Nom'],
  						'Prenom' => $result[0]['Prenom'],
  						'Description' => $result[0]['Description'],
  						'Role' => $result[0]['Role']
  					];

						foreach ($users as $user) {
              $Id_Profil = $user['Id_Profil'];
  						$email = $user['email'];
  						$Nom = $user['Nom'];
  						$Prenom = $user['Prenom'];
  						$Description = $user['Description'];
  						$Role = $user['Role'];
            }

						$message = "Un mail a été envoyé à $email";
            echo "<script>$('#info_login').text(\"".$message."\");$('.rocket').css('animation','3s launch');</script><meta http-equiv='refresh' content='5; url=login.php' />";

						$comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/[\'\/~`\!@#$%^&*()_-+={}[]|;:"<>,.?]/';
						$pass = array();
						$combLen = strlen($comb) - 1;
						for ($i = 0; $i < 8; $i++) {
								$n = rand(0, $combLen);
								$pass[] = $comb[$n];
						}
						$MDP = implode($pass);
            $MDP_sha256 = hash('sha256', strip_tags($MDP));


            include("connect.php");

            // ajout d'une ligne dans le changelog
            // Ecriture de la requête
            $sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

            // Préparation
            $changelog_login = $PDO->prepare($sqlQuery);

            // Exécution ! l'utilisateur est maintenant en base de données
            $changelog_login->execute([
                'Nom' => $Id_Profil . " : " . $email,
                'Date_de_modification' => date('d-m-y H:i:s'),
                'Description' => "Récupération du mot de passe du compte " . $Id_Profil . " : " . $email . " / " . $Nom . " / " . $Prenom,
              ]);

            // envoie du mail à l'Utilisateur

        		$mail = <<<MAIL
            Bonjour $Prenom $Nom,<br /><br />
            Nous avons mis à jour le mot de passe de votre compte associé au mail : $email <br /><br />
            Votre mot de passe est : $MDP <br /><br />
            Il vous sera demandé pour vous connecter au
            <a href="https://www.lesbriquesrouges.fr/" style="font-size:15px;line-height:18px;font-family:'open-sans',sans-serif;color:#000000;font-weight:normal;text-decoration:underline" target="_blank">site</a>.<br /><br />
            Dans un souci de sécurité, nous vous invitons à le modifier dès la première connexion.<br /><br />
            Nous vous remercions de votre confiance.
            MAIL;

        		include_once('sendmail.php');
        		sendmail($email,$mail,$MDP_sha256);
  				}
          else
          {
            $message = "Le nom d'utilisateur ne possède pas de compte.";
            echo "<script>$('#info_login').text(\"".$message."\");$('.rocket').css('animation','.5s no');</script>";
          }
        }
        else
        {
          $message = "Les noms d'utilisations sont différents.";
          echo "<script>$('#info_login').text(\"".$message."\");$('.rocket').css('animation','.5s no');</script>";
        }
			}
		?>
  </body>
</html>
