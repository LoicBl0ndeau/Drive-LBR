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
		<script src="js/changelog.js"></script>
		<title>ChangeLog Drive - Les Briques Rouges</title>

	</head>

	<body class="d-flex flex-column min-vh-100">
      <!-- Navigation -->
    <header>
      <?php include_once('changelog_header.php'); ?>
    </header>

		<div id="table_compte">

			<?php
			if (empty($changelogs))
			{
				echo "il n'y a pas de résultats pour votre recherche"."<br />";
			}
			?>

			<table>
        <thead>
          <tr>
						<th>Id_Log_</th>
						<th>Nom</th>
						<th>Date_de_modification</th>
						<th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($changelogs as $changelog) : ?>
                <tr class="tab_body">
									<td><?php echo $changelog['Id_Log_']?></td>
									<td><?php echo $changelog['Nom']?></td>
									<td><?php echo $changelog['Date_de_modification'];?></td>
									<td><?php echo $changelog['Description'];?></td>
                </tr>
          <?php endforeach ?>
        </tbody>
      </table>

    </div>

	  <!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php
			echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
	 	?>

  </body>
</html>
