<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}

	// Défini le fuseau horaire à utilisateur
	date_default_timezone_set('Europe/Paris');

	// Autorisation admin
	include_once('functions.php');
	autorisation_admin();
?>

<?php

$postData = $_POST;
// on vérifie l'existence et la conformité des data
if (
    !isset($_POST['Prenom']) || empty($_POST['Prenom']) ||
    !isset($_POST['Nom']) || empty($_POST['Nom']) ||
		(!isset($_POST['Email']) || !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) ||
    !isset($_POST['MDP']) || empty($_POST['MDP']) ||
    !isset($_POST['Description']) || empty($_POST['Description'])||
    !isset($_POST['Role']) || empty($_POST['Role'])
    )
{
	echo('<link rel="stylesheet" type="text/css" href="style/style.css" />
				<div class="container">
				<div class="alert alert-danger" role="alert">
				Il faut un Prénom, un Nom, une adresse mail, une Description et un Role valides pour soumettre le formulaire.
				</div>
				<a class="btn btn-primary" onclick="history.back()">Retour au formulaire</a>
				</div>');
  return;
}

$Prenom = strip_tags($postData['Prenom']);
$Nom = strip_tags($postData['Nom']);
$Email = strip_tags($postData['Email']);
$MDP = strip_tags($postData['MDP']);
$MDP_sha256 = hash('sha256', strip_tags($postData['MDP']));
$Description = strip_tags($postData['Description']);
$Role = strip_tags($postData['Role']);


if (!check_mdp_format($MDP))
{
	echo('<link rel="stylesheet" type="text/css" href="style/style.css" />
				<div class="container">
				<div class="alert alert-danger" role="alert">
				Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial pour un total d\'au moins 8 caractères.
				</div>
				<a class="btn btn-primary" onclick="history.back()">Retour au formulaire</a>
				</div>');
	return;
}
//else
	//echo "Format correct";

?>



<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<meta name="Auteurs" content="Loïc BLONDEAU;Louis BOUBERT;Martin CAPELLE;Ilies BENSLAMA" />
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<link rel="icon" href="images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Account Manager Drive - Les Briques Rouges</title>
  </head>

  <body class="d-flex flex-column min-vh-100">

      <!-- Navigation -->
    <header>
      <?php include_once('account_Manager_header_lite.php'); ?>
    </header>

		<?php

		// On vérifie que le mail n'est pas déjà utilisé

		include_once('functions.php');
		$all_users = all_users();

		$same_email = 0;
			foreach ($all_users as $user) {
			    if ($user['email'] === $Email) {
						$same_email++;
			        //echo "le mail semble déjà utilisé";
			    }
					else {
						//echo "le mail semble ne jamais avoir été utilisé";
			      //$errorMessage = sprintf('le mail semble ne jamais avoir été utilisé');
			    }
			}
			//echo $same_email;
		?>

		<?php
		if ($same_email) {
			$errorMessage = sprintf('L\'adresse email semble déjà utilisé, l\'utilisateur n\'est pas enregistré');
		}
		else {

			include("connect.php");

			// Ecriture de la requête
			$sqlQuery = 'INSERT INTO profil(email, MDP, Nom, Prenom, Description, Role) VALUES (:email, :MDP, :Nom, :Prenom, :Description, :Role)';

			// Préparation
			$req = $PDO->prepare($sqlQuery);

			// Exécution ! l'utilisateur est maintenant en base de données
			$req->execute([
			    'email' => $Email,
					'MDP' => $MDP_sha256,
			    'Nom' => $Nom,
			    'Prenom' => $Prenom,
			    'Description' => $Description,
			    'Role' => $Role,
			]);

			//   ajout d'une ligne dans le changelog

			// Ecriture de la requête
			$sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

			// Préparation
			$req = $PDO->prepare($sqlQuery);

			// Exécution ! le changelog est maintenant mis à jour
			$req->execute([
					'Nom' => $_SESSION['loggedUser']['Id_Profil'] . " : " . $_SESSION['loggedUser']['email'],
					'Date_de_modification' => date('d-m-y H:i:s'),
					'Description' => "Création d'un compte : $Email / $Nom / $Prenom / $Description / $Role",
			]);

		// envoie du mail à l'Utilisateur

		$mail = <<<MAIL
						Bonjour $Prenom $Nom,<br /><br />
						Vous avez maintenant un compte $Role associé au mail : $Email <br /><br />
						Votre mot de passe est : $MDP <br /><br />
						Il vous sera demandé pour vous connecter au
						<a href="https://www.lesbriquesrouges.fr/" style="font-size:15px;line-height:18px;font-family:'open-sans',sans-serif;color:#000000;font-weight:normal;text-decoration:underline" target="_blank">site</a>.<br /><br />
						Dans un souci de sécurité, nous vous invitons à le modifier dès la première connexion.<br /><br />
						Nous vous remercions de votre confiance.
						MAIL;

		include_once('sendmail.php');
		sendmail($Email,$mail);

	}

		?>

    <div class="container">

			<!-- si message d'erreur on l'affiche -->
	    <?php if(isset($errorMessage)) : ?>
	        <div class="alert alert-danger" role="alert">
	            <?php echo $errorMessage; ?>
	        </div>
					<a class="btn btn-primary" onclick="history.back()">Retour au formulaire</a>

			<?php else: ?>

				<h1>Utilisateur bien ajouté</h1>

				<div class="card">

					<div class="card-body">
							<h5 class="card-title">Rappel de vos informations</h5>
							<p class="card-text"><b>Prenom</b> : <?php echo($Prenom); ?></p>
							<p class="card-text"><b>Nom</b> : <?php echo($Nom); ?></p>
							<p class="card-text"><b>Email</b> : <?php echo($Email); ?></p>
							<p class="card-text"><b>Mot de passe</b> : <?php echo($MDP); ?></p>
							<p class="card-text"><b>Description</b> : <?php echo strip_tags($Description); ?></p>
							<p class="card-text"><b>Rôle</b> : <?php echo($Role); ?></p>
					</div>
					<a class="btn btn-primary" href="account_Manager_accueil.php">Retour au gestionnaire</a>
				</div>

	    <?php endif; ?>

    </div>

		<!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php
			echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
		?>

	</body>
</html>
