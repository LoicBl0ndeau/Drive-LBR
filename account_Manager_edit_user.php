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
    !isset($_POST['Id_Profil']) || empty($_POST['Id_Profil'])
    )
{
	echo('ça marche pas');
    return;
}

$Id_Profil = $postData['Id_Profil'];

//echo $Id_Profil;

try
{
	$mysqlClient = new PDO('mysql:host=localhost;dbname=lbr;charset=utf8', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Ecriture de la requête
$sqlQuery = 'SELECT * FROM profil WHERE Id_Profil = :Id_Profil';

// Préparation
$userStatement = $mysqlClient->prepare($sqlQuery);

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
		<title>Drive - Les Briques Rouges</title>

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
							<input type="text" class="form-control" id="Id_Profil" name="Id_Profil" aria-describedby="title-help" value="<?php echo $user['Id_Profil'] ?>" readonly="readonly">
					</div>
          <div class="mb-3">
              <label for="Prenom" class="form-label">Prenom</label>
              <input type="text" class="form-control" id="Prenom" name="Prenom" aria-describedby="title-help" value="<?php echo $user['Prenom'] ?>">
          </div>
          <div class="mb-3">
              <label for="Nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="Nom" name="Nom" aria-describedby="title-help" value="<?php echo $user['Nom'] ?>">
          </div>
          <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input type="email" class="form-control" id="Email" name="Email" aria-describedby="title-help" value="<?php echo $user['email'] ?>">
          </div>
          <div class="mb-3">
              <label for="Description" class="form-label">Description</label>
              <textarea class="form-control" placeholder="Écrivez la description ici" id="Description" name="Description" ><?php echo $user['Description'] ?></textarea>
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
