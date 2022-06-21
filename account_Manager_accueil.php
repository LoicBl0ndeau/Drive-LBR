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

		<?php if (empty($users)) : ?>
			<div class="container alert alert-danger" role="alert"> <?php echo 'Il n\'y a pas de résultats pour votre recherche' ?></div><br></br>
		<?php else : ?>

    <div id="table_compte">

			<table>
        <thead>
          <tr>
						<th>Nom</th>
           <th>Prenom</th>
           <th>email</th>
           <th>Role</th>
					 <th> </th>
					 <th><button type="button" name="button" id="bouton_ajouter"><a href="account_Manager_add_user.php">Ajouter</a></button></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $user) : ?>
                <tr class="tab_body">
								 	<td> <?php echo $user['Nom']?> </td>
                   <td><?php echo $user['Prenom']?></td>
                   <td><?php echo $user['email'];?></td>
                   <td><?php echo $user['Role'];?></td>
                   <td>
										 <form action="account_Manager_edit_user.php" method="post">
											 <button type="submit" name="Id_Profil" value="<?php echo $user['Id_Profil'] ?>">Modifier</button>
										 </form>
									 </td>
                   <td>
									 	<form action="account_Manager_delete_user.php" method="post">
										 	<button type="submit" name="Id_Profil" value="<?php echo $user['Id_Profil'] ?>">Supprimer</button>
                   	</form>
									</td>
                </tr>
          <?php endforeach ?>
        </tbody>
      </table>

    </div>

	<?php endif ?>

    <!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php
			echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
	 	?>
  </body>
</html>
