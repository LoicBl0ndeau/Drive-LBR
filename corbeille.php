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
?>
<?php //restore
	if(isset($_SESSION['random_OK'], $_POST['randomrestoreOK']) && $_POST['randomrestoreOK'] == $_SESSION['random_OK']){
		include("connect.php");
		$req = $PDO->prepare("UPDATE fichier SET Corbeille = 0 WHERE bin=?");
		$req->execute(array($_POST['restore']));
	}
	unset($_POST['randomrestoreOK']);
?>
<?php //delete
	if(isset($_SESSION['random_OK'], $_POST['randomdeleteOK']) && $_POST['randomdeleteOK'] == $_SESSION['random_OK']){
		include("connect.php");
		$req = $PDO->prepare("DELETE FROM fichier WHERE bin=?");
		$req->execute(array($_POST['delete']));
		unlink($_POST['delete']);
	}
	unset($_POST['randomdeleteOK']);
?>
<?php //download
	if(isset($_POST['src_download'])){
		$file = $_POST['src_download'];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
	$_SESSION['random_OK'] = uniqid(); // nombre aléatoire unique
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
		<script src="js/contextmenu/jquery.contextMenu.js"></script>
		<script src="js/contextmenu/jquery.ui.position.min.js"></script>
		<link rel="stylesheet" href="js/contextmenu/jquery.contextMenu.min.css" />
		<script src="js/corbeille.js"></script>
		<title>Corbeille Drive - Les Briques Rouges</title>
	</head>
  <body>
		<form method="post" id="download"><input type="hidden" name="src_download" /></form>
		<form method="post" id="delete" enctype="multipart/form-data"><input type="hidden" name="delete" /><input type="hidden" name="randomdeleteOK" value="<?php echo $_SESSION['random_OK']; ?>" /></form>
		<form method="post" id="restore" enctype="multipart/form-data"><input type="hidden" name="restore" /><input type="hidden" name="randomrestoreOK" value="<?php echo $_SESSION['random_OK']; ?>" /></form>
		<div id="lecteur"></div>
		<header>
			<a href="accueil.php"><img src="images/logoLONGUEURBlanc.png" alt="logo_longueur_blanc" id="logo_longueur_blanc" /></a>
			<div id="scearch_bar">
				<input type="text" id="text_scearch_bar" placeholder='Tapez ".mp4;2021" par exemple.' />
				<label for="text_scearch_bar">
					<svg fill="#FFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">
						<path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/>
					</svg>
				</label>
			</div>
			<div id="container_header_right">
				<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
			</div>
		</header>

    <!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>"; ?>
		<?php
			function mois($mois) {
				switch ($mois) {
					case 1:
						$mois = "Janvier";
					break;
					case 2:
						$mois = "Février";
					break;
					case 3:
						$mois = "Mars";
					break;
					case 4:
						$mois = "Avril";
					break;
					case 5:
						$mois = "Mai";
					break;
					case 6:
						$mois = "Juin";
					break;
					case 7:
						$mois = "Juillet";
					break;
					case 8:
						$mois = "Août";
					break;
					case 9:
						$mois = "Septembre";
					break;
					case 10:
						$mois = "Octobre";
					break;
					case 11:
						$mois = "Novembre";
					break;
					case 12:
						$mois = "Décembre";
					break;
				}
		 		return $mois;
			}
			$req = $PDO->query("SELECT * FROM fichier ORDER BY Date_de_publication");
			$res = $req->fetchAll();
			$extensionsImage = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/tiff', 'image/bmp', 'image/svg+xml', 'image/x-xbitmap', 'image/jxl', 'image/webp', 'image/x-icon', 'image/avif'];
			$dateOlder = NULL;
			foreach ($res as $media) {
				if($media['Corbeille'] == 1){
					if($dateOlder != date_create($media['Date_de_publication'])){
						if($dateOlder == NULL){
							$dateOlder = date_create($media['Date_de_publication']);
							echo "<h1 style='text-align: center;'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media'>";
						}
						else{
							$dateOlder = date_create($media['Date_de_publication']);
							echo "</div><h1 style='text-align: center;'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media'>";
						}
					}
					if(in_array($media['Type'],$extensionsImage)){ //Si c'est une image
						echo "<div class='marge'><img class='img_media' src='".$media['bin']."' alt='".$media['Titre']."' /></div>";
					}
					else{
						echo "<div class='marge'><div class='player'><video><source src='".$media['bin']."' />Your browser does not support the video tag.</video><img src='images/play.png' class='play' alt='PLAY' /></div></div>";
					}
				}
			}
	 	?>
	</body>
</html>
