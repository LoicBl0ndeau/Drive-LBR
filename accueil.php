<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}
?>
<?php // importer des photos
  if(isset($_FILES["image"])){
      include("connect.php");
      $req=$PDO->prepare("insert into fichier(Type,Titre,Taille,bin) values(?,?,?,?)");
      $req->execute(array($_FILES["image"]["type"],$_FILES["image"]["name"],$_FILES["image"]["size"],file_get_contents($_FILES["image"]["tmp_name"])));
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
		<script src="js/accueil.js"></script>
		<title>Drive - Les Briques Rouges</title>
	</head>
  <body>
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
				<label for="importer_file" id="importer">
					<svg fill="#FFFF" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512" width="27px" height="27px">
	      		<path d="m153.7,171.5l81.9-88.1v265.3c0,11.3 9.1,20.4 20.4,20.4 11.3,0 20.4-9.1 20.4-20.4v-265.3l81.9,88.1c7.7,8.3 20.6,8.7 28.9,1.1 8.3-7.7 8.7-20.6 1.1-28.9l-117.3-126.2c-11.5-11.6-25.6-5.2-29.9,0l-117.3,126.2c-7.7,8.3-7.2,21.2 1.1,28.9 8.2,7.6 21.1,7.2 28.8-1.1z"/>
	      		<path d="M480.6,341.2c-11.3,0-20.4,9.1-20.4,20.4V460H51.8v-98.4c0-11.3-9.1-20.4-20.4-20.4S11,350.4,11,361.6v118.8    c0,11.3,9.1,20.4,20.4,20.4h449.2c11.3,0,20.4-9.1,20.4-20.4V361.6C501,350.4,491.9,341.2,480.6,341.2z"/>
					</svg>
					Importer
					<form id="form_import" method="post" enctype="multipart/form-data">
						<input type="file" id="importer_file" name="image" />
					</form>
				</label>
				<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
			</div>
		</header>
		<div id="mask_profil"></div>
		<div id="profil">
			<div id="container_profil_top">
				<a id="container_deconnexion">
					<span>Déconnexion</span>
					<svg fill="none" height="24" stroke-width="1.5" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12H19M19 12L16 15M19 12L16 9" stroke="#FFFF" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M19 6V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V18" stroke="#FFFF" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
				<div id="container_pdp_profil">
					<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_profil" />
				</div>
				<p id="name"></p>
				<p id="role"></p>
			</div>
			<div id="container_profil_stats">
				<span>31<br />photos</span>
				<span></span>
				<span>5<br />vidéos</span>
			</div>
			<div id="container_profil_buttons">
				<button type="button">Mon profil</button>
				<button type="button">ChangeLog</button>
				<button type="button">Corbeille</button>
			</div>
		</div>
		<?php
			echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
	 	?>
  </body>
</html>
