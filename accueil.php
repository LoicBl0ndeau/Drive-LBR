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
?>
<?php //delete
	if(isset($_SESSION['random_OK'], $_POST['randomdeleteOK']) && $_POST['randomdeleteOK'] == $_SESSION['random_OK']){
		include("connect.php");
		$req = $PDO->prepare("UPDATE fichier SET Corbeille = 1 WHERE bin=?");
		$req->execute(array($_POST['delete']));
	}
	unset($_POST['randomdeleteOK']);
?>
<?php // importer des photos
	if(isset($_SESSION['random_OK'], $_POST['randomformOK']) && $_POST['randomformOK'] == $_SESSION['random_OK']){ // Protection contre "actualiser la page"
		$total_count = count($_FILES['media']['name']);
		for( $i=0 ; $i < $total_count ; $i++ ) {
		  if(isset($_FILES['media']) && $_FILES['media']['error'][$i] == 0){
				if($_FILES['media']['size'][$i] <= 10000000000){ //max 10Go
			    include("connect.php");
					$allowedExtensions = ['ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi','jpg', 'jpeg', 'gif', 'png', 'tiff', 'pjp', 'jfif', 'bmp', 'svg', 'xbm', 'dib', 'jxl', 'svgz', 'webp', 'ico', 'tif', 'pjpeg', 'avif'];
					$extension = strtolower(pathinfo($_FILES['media']['name'][$i])['extension']);
					if(in_array($extension, $allowedExtensions)){ //on vérifie que l'extension est un média
						$req=$PDO->query("SHOW TABLE STATUS FROM lbr LIKE 'fichier'");
						$res = $req->fetch();
						$Id_fichier = $res['Auto_increment'];
						mkdir("upload/".$Id_fichier, 0700);
						$nomFichier = basename($_FILES["media"]["name"][$i]);
						$chemin = "upload/".$Id_fichier."/".$nomFichier;
						move_uploaded_file($_FILES["media"]["tmp_name"][$i], $chemin);
						$date = date('Y-m-d H:i:s',filemtime($chemin));
						$req=$PDO->prepare("insert into fichier(Type,Titre,Auteur_Id,Taille,Date_de_publication,bin) values(?,?,?,?,?,?)");
			    	$req->execute(array($_FILES["media"]["type"][$i],$_FILES["media"]["name"][$i],$_SESSION['loggedUser']['Id_Profil'],$_FILES["media"]["size"][$i],$date,$chemin));
					}
					else{
						echo "<script>alert('Erreur, mauvaise extension: .".$extension."');</script>";
					}
				}
				else{
					echo "<script>alert('Erreur, fichier trop volumineux');</script>";
				}
			}
			else{
				echo "<script>alert('Erreur lors de l'upload. Erreur n°".$_FILES['media']['error'][$i]."');</script>";
			}
		}
	}
	unset($_POST['randomformOK']);
	// Protection contre "actualiser la page" ou envoi depuis l'extérieur (vol de formulaire)
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
		<script src="js/accueil.js"></script>
		<title>Drive - Les Briques Rouges</title>
	</head>
  <body>
		<form method="post" id="download"><input type="hidden" name="src_download" /></form>
		<form method="post" id="delete" enctype="multipart/form-data"><input type="hidden" name="delete" /><input type="hidden" name="randomdeleteOK" value="<?php echo $_SESSION['random_OK']; ?>" /></form>
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

				<?php if($_SESSION["loggedUser"]["Role"]!="Visiteur") : ?> <!-- Si on est visiteur alors pas accès à l'importation des fichiers -->
				<label for="importer_file" id="importer">
					<svg fill="#FFFF" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512" width="27px" height="27px">
	      		<path d="m153.7,171.5l81.9-88.1v265.3c0,11.3 9.1,20.4 20.4,20.4 11.3,0 20.4-9.1 20.4-20.4v-265.3l81.9,88.1c7.7,8.3 20.6,8.7 28.9,1.1 8.3-7.7 8.7-20.6 1.1-28.9l-117.3-126.2c-11.5-11.6-25.6-5.2-29.9,0l-117.3,126.2c-7.7,8.3-7.2,21.2 1.1,28.9 8.2,7.6 21.1,7.2 28.8-1.1z"/>
	      		<path d="M480.6,341.2c-11.3,0-20.4,9.1-20.4,20.4V460H51.8v-98.4c0-11.3-9.1-20.4-20.4-20.4S11,350.4,11,361.6v118.8    c0,11.3,9.1,20.4,20.4,20.4h449.2c11.3,0,20.4-9.1,20.4-20.4V361.6C501,350.4,491.9,341.2,480.6,341.2z"/>
					</svg>
					Importer
				</label>

			<?php endif ?>
				<form id="form_import" method="post" enctype="multipart/form-data">
					<input type="file" id="importer_file" name="media[]" accept="video/*,image/*" multiple />
					<input type="hidden" name="randomformOK" value="<?php echo $_SESSION['random_OK']; ?>" />
				</form>
				<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
			</div>
		</header>

    <!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>"; ?>
		<input class="favorite styled" type="button" value="ajouter un tag" onclick="window.location.href ='tags.php'"/>
		<div id="trier_par">Trier par :</div>
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
				if($media['Corbeille'] == 0){
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
