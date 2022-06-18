<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}
	if(!isset($_SESSION["src_informations"])){
		header("Location: accueil.php");
		exit();
	}
	// Défini le fuseau horaire à utilisateur
	date_default_timezone_set('Europe/Paris');
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
		<title>Informations Drive - Les Briques Rouges</title>
	</head>
  <body>
		<header>
			<a href="accueil.php"><img src="images/logoLONGUEURBlanc.png" alt="logo_longueur_blanc" id="logo_longueur_blanc" /></a>
			<div id="container_header_right">
				<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
			</div>
		</header>
		<div id="container_informations_media">
			<?php
				include("connect.php");
				$req = $PDO->prepare("SELECT * FROM fichier WHERE bin=?");
				$req->execute(array($_SESSION['src_informations']));
				$res = $req->fetch();
				$extensionsImage = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/tiff', 'image/bmp', 'image/svg+xml', 'image/x-xbitmap', 'image/jxl', 'image/webp', 'image/x-icon', 'image/avif'];
				if(in_array($res['Type'],$extensionsImage)){
					echo "<img class='media-informations' style='max-width: 100%;max-height: 100%;' src='".$_SESSION['src_informations']."' alt='".$res['Titre']."' />";
				}
				else {
					echo "<video class='media-informations' style='max-width: 100%;max-height: 100%;' controls><source src='".$_SESSION['src_informations']."' />Your browser does not support the video tag.</video>";
				}
			?>
			<div id="container_informations">
				<h2>Informations</h2>
				Nom: <?php echo $res['Titre']; ?><br />
				Auteur:
				<?php
					$req = $PDO->prepare("SELECT email FROM profil WHERE Id_Profil=?");
					$req->execute(array($res['Auteur_Id']));
					$email = $req->fetch();
					echo $email['email'];
				?>
				<br />
				Date d'ajout: <?php echo date('d/m/Y',strtotime($res['Date_de_publication'])); ?><br />
				Taille: <?php echo round(0.000001*$res['Taille'], 2)." Mo (".$res['Taille']." octets)"; ?><br />
				Tags: <br />
			</div>
		</div>



		<!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>"; ?>
	</body>
</html>
