<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}
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

  </head>

  <body class="d-flex flex-column min-vh-100">
      <!-- Navigation -->
    <header>
      <?php include_once('header_AM.php'); ?>
    </header>

    <div class="container">

      <h1>Ajouter un utilisateur</h1>

      <form action="submit_user.php" method="POST">
          <div class="mb-3">
              <label for="Prenom" class="form-label">Prenom</label>
              <input type="text" class="form-control" id="Prenom" name="Prenom" aria-describedby="title-help">
          </div>
          <div class="mb-3">
              <label for="Nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="Nom" name="Nom" aria-describedby="title-help">
          </div>
          <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input type="email" class="form-control" id="Email" name="Email" aria-describedby="title-help">
          </div>
          <div class="mb-3">
              <label for="Description" class="form-label">Description</label>
              <textarea class="form-control" placeholder="Écrivez la description ici" id="Description" name="Description"></textarea>
          </div>
          <div class="mb-3">
              <label for="Role" class="form-label">Visiteur</label>
              <input type="radio" name="Role" value="Visiteur">
              <label for="Role" class="form-label">Editeur</label>
              <input type="radio" name="Role" value="Editeur">
              <label for="Role" class="form-label">Invité</label>
              <input type="radio" name="Role" value="Invité">
              <label for="Role" class="form-label">Admin</label>
              <input type="radio" name="Role" value="Admin">
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
