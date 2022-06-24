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
		<script src="js/changelog.js"></script>
		<title>Stockage Drive - Les Briques Rouges</title>

	</head>

	<body class="d-flex flex-column min-vh-100">
      <!-- Navigation -->
    <header>
      <?php include_once('stockage_header.php'); ?>
    </header>

		<div id="table_compte">

			<table>
        <thead>
          <tr>
						<th>Utilisateur</th>
						<th>espace utilisé</th>
          </tr>
        </thead>
        <tbody>
					<tr class='tab_body'>
						<td>Total</td>
						<td><?php echo round(0.000001*$Total[0],2) . " Mo"; ?></td>
					</tr>


					<?php if (empty($users)) : ?>
					</tbody>
				</table>

			</div>

			<div class="container alert alert-danger" role="alert"> <?php echo 'Il n\'y a pas de résultats pour votre recherche' ?></div><br></br>

					<?php else : ?>

						<?php
						      foreach ($users as $person)
									{
						        $query = 'SELECT SUM(Taille) FROM fichier WHERE Auteur_Id=?';
						        $req = $PDO->prepare($query);
						        $req->execute(array($person['Id_Profil']));
						        $Tay = $req->fetchAll();
						        foreach($Tay as $tays)
										{
											echo "<tr class='tab_body'>";
							          echo"<td>".$person['Id_Profil']." : ".$person['email']."</td>";
							          echo"<td>".round(0.000001*$tays[0],2)." Mo</td>";
							        echo"</tr>";
										}
						      }
						?>

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
