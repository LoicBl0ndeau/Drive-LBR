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
      <?php include_once('account_Manager_header.php'); ?>
    </header>

    <div class="container">

      <h1>Ajouter un utilisateur</h1>

      <form action="account_Manager_submit_user.php" method="POST">
          <div class="mb-3">
              <label for="Prenom" class="form-label">Prenom</label>
              <input type="text" class="form-control" id="Prenom" name="Prenom">
          </div>
          <div class="mb-3">
              <label for="Nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="Nom" name="Nom">
          </div>
          <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input type="email" class="form-control" id="Email" name="Email">
          </div>
					<div class="mb-3">
              <label for="MDP" class="form-label">Mot de passe</label>
              <input type="text" class="form-control" id="MDP" name="MDP">
          </div>
          <div class="mb-3">
              <label for="Description" class="form-label">Description</label>
              <textarea class="form-control" placeholder="Écrivez la description ici" id="Description" name="Description"></textarea>
          </div>
					<div class="mb-3">
							<input type="radio" name="Role" value="Lecture">
              <label for="Role" class="form-label">Lecture</label>

              <input type="radio" name="Role" value="Ecriture">
              <label for="Role" class="form-label">Ecriture</label>

              <input type="radio" name="Role" value="Invité">
              <label for="Role" class="form-label">Invité</label>

              <input type="radio" name="Role" value="Admin">
              <label for="Role" class="form-label">Admin</label>

          </div>
          <button type="submit" class="btn btn-primary">Valider</button>
      </form>
      <br />
    </div>


    <!-- Page Profil -->
    <?php include_once('mask_profil.php'); ?>

    <?php
      echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
    ?>

  </body>
</html>
