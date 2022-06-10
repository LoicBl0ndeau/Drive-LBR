<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}
?>

<?php

$postData = $_POST;

if (
  !isset($_POST['Prenom']) || empty($_POST['Prenom']) ||
  !isset($_POST['Prenom']) || empty($_POST['Prenom']) ||
  !isset($_POST['Nom']) || empty($_POST['Nom']) ||
	(!isset($_POST['Email']) || !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) ||
  !isset($_POST['Description']) || empty($_POST['Description'])||
  !isset($_POST['Role']) || empty($_POST['Role'])
  )
{
  echo('Il faut un Prénom, un Nom, une adresse mail, une Description et un Role valides pour soumettre le formulaire.');
  return;
}

$Id_Profil = $postData['Id_Profil'];
$Prenom = $postData['Prenom'];
$Nom = $postData['Nom'];
$Email = $postData['Email'];
$Description = $postData['Description'];
$Role = $postData['Role'];

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
		<title>Drive - Les Briques Rouges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body class="d-flex flex-column min-vh-100">

      <!-- Navigation -->
    <header>
      <?php include_once('account_Manager_header.php'); ?>
    </header>

		<?php

		// Validation du formulaire
		$same_email = 0;
			foreach ($users as $user) {
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
			try
			{
				$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
			}
			catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}

			// Ecriture de la requête
			$sqlQuery = 'UPDATE profil SET email = :email, Nom = :Nom, Prenom = :Prenom, Description = :Description, Role = :Role WHERE Id_Profil = :Id_Profil';

			// Préparation
			$edited_user = $mysqlClient->prepare($sqlQuery);

			// Exécution ! l'utilisateur est maintenant en base de données
			$edited_user->execute([
			    'Id_Profil' => $Id_Profil,
			    'email' => $Email,
			    'Nom' => $Nom,
			    'Prenom' => $Prenom,
			    'Description' => $Description,
			    'Role' => $Role,
			]);
		}
		
		?>

    <div class="container">

			<!-- si message d'erreur on l'affiche -->
	    <?php if(isset($errorMessage)) : ?>
	        <div class="alert alert-danger" role="alert">
	            <?php echo $errorMessage; ?>
	        </div>
					<a class="btn btn-primary" href="account_Manager_accueil.php">Retour au gestionnaire</a>

			<?php else: ?>

        <h1>Utilisateur bien modifié</h1>

        <div class="card">

          <div class="card-body">
              <h5 class="card-title">Rappel de vos informations</h5>
              <p class="card-text"><b>Prenom</b> : <?php echo($Prenom); ?></p>
              <p class="card-text"><b>Nom</b> : <?php echo($Nom); ?></p>
              <p class="card-text"><b>Email</b> : <?php echo($Email); ?></p>
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
