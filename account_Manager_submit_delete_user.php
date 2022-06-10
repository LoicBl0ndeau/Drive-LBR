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
    !isset($_POST['user']) || empty($_POST['user'])
    )
{
	echo('Il y a un problème');
    return;
}

$Id_Profil = $postData['user'];

//echo $Id_Profil;

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
$sqlQuery = 'DELETE FROM Profil WHERE Id_Profil=:Id_Profil';

// Préparation
$delete_user = $mysqlClient->prepare($sqlQuery);

// Exécution ! l'utilisateur est maintenant supprimé de la base de données
$delete_user->execute([
    'Id_Profil' => $Id_Profil,
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
      <?php include_once('account_Manager_header.php'); ?>
    </header>

      <div class="container">

        <h1>Utilisateur supprimé !</h1>

        <div class="card">
	        <a class="btn btn-primary" href="account_Manager_accueil.php">Retour au gestionnaire</a>
        </div>
      </div>

			<!-- Page Profil -->
			<?php include_once('mask_profil.php'); ?>

			<?php
				echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
			?>

	</body>
</html>
