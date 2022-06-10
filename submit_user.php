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
    !isset($_POST['Nom']) || empty($_POST['Nom']) ||
		(!isset($_POST['Email']) || !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) ||
    !isset($_POST['Description']) || empty($_POST['Description'])||
    !isset($_POST['Role']) || empty($_POST['Role'])
    )
{
	echo('Il faut un Prénom, un Nom, une adresse mail, une Description et un Role valides pour soumettre le formulaire.');
    return;
}

$Prenom = $postData['Prenom'];
$Nom = $postData['Nom'];
$Email = $postData['Email'];
$Description = $postData['Description'];
$Role = $postData['Role'];

?>

<?php
try
{
	$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Ecriture de la requête
$sqlQuery = 'INSERT INTO profil(email, Nom, Prenom, Description, Role) VALUES (:email, :Nom, :Prenom, :Description, :Role)';

// Préparation
$insertRecipe = $mysqlClient->prepare($sqlQuery);

// Exécution ! l'utilisateur est maintenant en base de données
$insertRecipe->execute([
    'email' => $Email,
    'Nom' => $Nom,
    'Prenom' => $Prenom,
    'Description' => $Description,
    'Role' => $Role,
]);
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
      <?php include_once('header_AM.php'); ?>
    </header>

      <div class="container">

        <h1>Utilisateur bien ajouté</h1>

        <div class="card">

          <div class="card-body">
              <h5 class="card-title">Rappel de vos informations</h5>
              <p class="card-text"><b>Prenom</b> : <?php echo($Prenom); ?></p>
              <p class="card-text"><b>Nom</b> : <?php echo($Nom); ?></p>
              <p class="card-text"><b>Email</b> : <?php echo($Email); ?></p>
              <p class="card-text"><b>Description</b> : <?php echo strip_tags($Description); ?></p>
              <p class="card-text"><b>Rôle</b> : <?php echo($Role); ?></p>
          </div>
	        <a class="btn btn-primary" href="account_Manager.php">Retour au gestionnaire</a>
        </div>
      </div>

			<!-- Page Profil -->
			<?php include_once('mask_profil.php'); ?>

			<?php
				echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
			?>

	</body>
</html>
