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

if (
    !isset($_POST['Id_Profil']) || empty($_POST['Id_Profil'])
    )
{
	echo('ça marche pas');
    return;
}

$Id_Profil = $postData['Id_Profil'];

//echo $Id_Profil;

include("connect.php");

// Ecriture de la requête
$sqlQuery = 'SELECT * FROM profil WHERE Id_Profil = :Id_Profil';

// Préparation
$userStatement = $PDO->prepare($sqlQuery);

// Exécution ! l'utilisateur est maintenant en base de données
$userStatement->execute([
    'Id_Profil' => $Id_Profil
]);
$edit_users = $userStatement->fetchAll();

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

      <h1>Modifier un utilisateur</h1>

			<?php foreach ($edit_users as $user): ?>

	      <form action="account_Manager_submit_edit_user.php" method="POST">
					<div class="mb-3">
							<label for="Id_Profil" class="form-label">Id_Profil</label>
							<input type="text" class="form-control" id="Id_Profil" name="Id_Profil" value="<?php echo $user['Id_Profil'] ?>" readonly="readonly">
					</div>
          <div class="mb-3">
              <label for="Prenom" class="form-label">Prenom</label>
              <input type="text" class="form-control" id="Prenom" name="Prenom" value="<?php echo $user['Prenom'] ?>">
          </div>
          <div class="mb-3">
              <label for="Nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo $user['Nom'] ?>">
          </div>
          <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $user['email'] ?>">
          </div>
					<div class="mb-3">
              <label for="MDP" class="form-label">Mot de passe</label>
              <input type="text" class="form-control" id="MDP" name="MDP">
							<input type="checkbox" name="MDP_changed" value="1">Modifier le mot de passe</input>
          </div>
          <div class="mb-3">
              <label for="Description" class="form-label">Description</label>
              <textarea class="form-control" placeholder="Écrivez la description ici" id="Description" name="Description" ><?php echo $user['Description'] ?></textarea>
          </div>
          <div class="mb-3">
							<input type="radio" name="Role" value="Visiteur">
              <label for="Role" class="form-label">Visiteur</label>

              <input type="radio" name="Role" value="Editeur">
              <label for="Role" class="form-label">Editeur</label>

              <input type="radio" name="Role" value="Invité">
              <label for="Role" class="form-label">Invité</label>

              <input type="radio" name="Role" value="Admin">
              <label for="Role" class="form-label">Admin</label>

          </div>
          <button type="submit" class="btn btn-primary">Valider</button>
	      </form>

			<?php endforeach; ?>
      <br />
    </div>


    <!-- Page Profil -->
    <?php include_once('mask_profil.php'); ?>

    <?php
      echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
    ?>

  </body>
</html>
