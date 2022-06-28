<?php
	// Initialise la session
	session_start();
	// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
	if(!isset($_SESSION["loggedUser"])){
		header("Location: login.php");
		exit();
	}

	if($_SESSION["loggedUser"]["Role"] == "Lecture")
  {
    header("Location: accueil.php");
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
				<input type="text" id="text_scearch_bar" placeholder='Tapez ".mp4;24/09/2021" par exemple.' />
				<label for="text_scearch_bar">
					<svg fill="#FFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">
						<path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/>
					</svg>
				</label>
			</div>
			<div id="container_header_right">
				<form id="form_import" method="post" enctype="multipart/form-data">
					<input type="file" id="importer_file" name="media[]" accept="video/*,image/*" multiple />
					<input type="hidden" name="randomformOK" value="<?php echo $_SESSION['random_OK']; ?>" />
				</form>
				<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
			</div>
		</header>
		<nav>
				<div></div>
			<div id="container_categories">
				<?php
				 	include("connect.php");
				 	$req = $PDO->query("SELECT * FROM categorie ORDER BY Id_Catégorie");
		 			$res = $req->fetchAll();
					$reqTags = $PDO->prepare("SELECT * FROM tag WHERE Id_Catégorie=?");
					foreach ($res as $categories) {
						echo "<div class='nom_categorie' id_cat='".$categories['Id_Catégorie']."'>".$categories['Nom']."</div>";
						$reqTags->execute(array($categories['Id_Catégorie']));
						$resTags = $reqTags->fetchAll();
						foreach ($resTags as $tag) {
							echo "<div class='nom_tag tag_de_cat_".$categories['Id_Catégorie']."' style='display: none;'>".$tag['Nom']."</div>";
						}
					}
			 	?>
			</div>
			<div>
		</div>
		</nav>
    <!-- Page Profil -->
		<?php include_once('mask_profil.php'); ?>

		<?php echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>"; ?>
		<div id="trier_par">Trier par :<input type="radio" id="radio_dates" name="radio_trie" checked /><label class="bouton_trier_par" for="radio_dates">Dates</label><input type="radio" id="radio_auteurs" name="radio_trie" /><label class="bouton_trier_par" for="radio_auteurs">Auteurs</label><input type="radio" id="radio_mes_photos" name="radio_trie" /><label class="bouton_trier_par" for="radio_mes_photos">Mes photos</label><input type="checkbox" id="checked_croissant" checked /><label id="bouton_checked_croissant" for="checked_croissant">Croissant</label></div>

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
			$compteur_container_media = 0;
			foreach ($res as $media) {
				if($media['Corbeille'] == 1){
					if($dateOlder != date_create($media['Date_de_publication'])){
						if($dateOlder == NULL){
							$dateOlder = date_create($media['Date_de_publication']);
							echo "<h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
						}
						else{
							$dateOlder = date_create($media['Date_de_publication']);
							echo "</div><h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
						}
						$compteur_container_media += 1;
					}
					if($media['Auteur_Id'] == $_SESSION['loggedUser']['Id_Profil']){
						$isMediaFromLoggedUser = 1; //True
					}
					else{
						$isMediaFromLoggedUser = 0; //False
					}
					if($_SESSION['loggedUser']['Role'] == "Invité"){
						if($isMediaFromLoggedUser == 1){
							if($dateOlder != date_create($media['Date_de_publication'])){
								if($dateOlder == NULL){
									$dateOlder = date_create($media['Date_de_publication']);
									echo "<h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
								}
								else{
									$dateOlder = date_create($media['Date_de_publication']);
									echo "</div><h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
								}
								$compteur_container_media += 1;
							}
							if(in_array($media['Type'],$extensionsImage)){ //Si c'est une image
								echo "<div class='marge' isMediaFromLoggedUser='".$isMediaFromLoggedUser."' id_media='".$media['Id_fichier']."'><img class='img_media' src='".$media['bin']."' alt='".$media['Titre']."' /></div>";
							}
							else{
								echo "<div class='marge' isMediaFromLoggedUser='".$isMediaFromLoggedUser."' id_media='".$media['Id_fichier']."'><div class='player'><video><source src='".$media['bin']."' />Your browser does not support the video tag.</video><img src='images/play.png' class='play' alt='PLAY' /></div></div>";
							}
							$reqEmail = $PDO->prepare("SELECT * FROM profil WHERE Id_Profil=?");
							$reqEmail->execute(array($media['Auteur_Id']));
							$resEmail = $reqEmail->fetchAll();
							$reqTags = $PDO->prepare("SELECT * FROM caractériser WHERE Id_fichier=?");
							$reqTags->execute(array($media['Id_fichier']));
							$resTags = $reqTags->fetchAll();
							$list_tags = "";
							$reqNomTags = $PDO->prepare("SELECT * FROM tag WHERE Id_Tag=?");
							foreach ($resTags as $tag) {
								$reqNomTags->execute(array($tag['Id_Tag']));
								$resNomTags = $reqNomTags->fetch();
								$list_tags .= $resNomTags['Nom'].", ";
							}
							$list_tags = substr($list_tags,0,-2);
							$appendInfos = "<div class='container_informations' id_media='container_inf_".$media['Id_fichier']."'><br /><h2 class='menu_informations'>Informations <span class='fermer_informations'>✖</span></h2><br />Nom: <span class='nom_fichier'>".$media['Titre']."</span><br /><br />Auteur: <span class='mail_auteurs' style='display: none;'><span class='prenom'>".$resEmail[0]['Prenom']."</span> <span class='nom'>".$resEmail[0]['Nom']."</span> (".$resEmail[0]['Description'].")</span>".$resEmail[0]['email']."<br /><br />Date d'ajout: <span class='date_ajout'>".$media['Date_de_publication']."</span><span class='date_ajout_fr'>".date('d/m/Y',strtotime($media['Date_de_publication']))."</span><br /><br />Taille: ".round(0.000001*$media['Taille'], 2)." Mo (".$media['Taille']." octets)<br /><br />Tags: <span class='liste_des_tags'>".$list_tags."</span><br /></div>";
							echo <<<END
								<script>$('body').append("{$appendInfos}")</script>
								END;
						}
					}
					else{
						if($dateOlder != date_create($media['Date_de_publication'])){
							if($dateOlder == NULL){
								$dateOlder = date_create($media['Date_de_publication']);
								echo "<h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
							}
							else{
								$dateOlder = date_create($media['Date_de_publication']);
								echo "</div><h1 style='text-align: center;' titre_associe_container_media='".$compteur_container_media."' class='titre_container_media'>".$dateOlder->format('d')." ".mois($dateOlder->format('m'))." ".$dateOlder->format('Y')."</h1><div class='container_media' titre_associe_container_media='".$compteur_container_media."'>";
							}
							$compteur_container_media += 1;
						}
						if(in_array($media['Type'],$extensionsImage)){ //Si c'est une image
							echo "<div class='marge' isMediaFromLoggedUser='".$isMediaFromLoggedUser."' id_media='".$media['Id_fichier']."'><img class='img_media' src='".$media['bin']."' alt='".$media['Titre']."' /></div>";
						}
						else{
							echo "<div class='marge' isMediaFromLoggedUser='".$isMediaFromLoggedUser."' id_media='".$media['Id_fichier']."'><div class='player'><video><source src='".$media['bin']."' />Your browser does not support the video tag.</video><img src='images/play.png' class='play' alt='PLAY' /></div></div>";
						}
						$reqEmail = $PDO->prepare("SELECT * FROM profil WHERE Id_Profil=?");
						$reqEmail->execute(array($media['Auteur_Id']));
						$resEmail = $reqEmail->fetchAll();
						$reqTags = $PDO->prepare("SELECT * FROM caractériser WHERE Id_fichier=?");
						$reqTags->execute(array($media['Id_fichier']));
						$resTags = $reqTags->fetchAll();
						$list_tags = "";
						$reqNomTags = $PDO->prepare("SELECT * FROM tag WHERE Id_Tag=?");
						foreach ($resTags as $tag) {
							$reqNomTags->execute(array($tag['Id_Tag']));
							$resNomTags = $reqNomTags->fetch();
							$list_tags .= $resNomTags['Nom'].", ";
						}
						$list_tags = substr($list_tags,0,-2);
						$appendInfos = "<div class='container_informations' id_media='container_inf_".$media['Id_fichier']."'><br /><h2 class='menu_informations'>Informations <span class='fermer_informations'>✖</span></h2><br />Nom: <span class='nom_fichier'>".$media['Titre']."</span><br /><br />Auteur: <span class='mail_auteurs' style='display: none;'><span class='prenom'>".$resEmail[0]['Prenom']."</span> <span class='nom'>".$resEmail[0]['Nom']."</span> (".$resEmail[0]['Description'].")</span>".$resEmail[0]['email']."<br /><br />Date d'ajout: <span class='date_ajout'>".$media['Date_de_publication']."</span><span class='date_ajout_fr'>".date('d/m/Y',strtotime($media['Date_de_publication']))."</span><br /><br />Taille: ".round(0.000001*$media['Taille'], 2)." Mo (".$media['Taille']." octets)<br /><br />Tags: <span class='liste_des_tags'>".$list_tags."</span><br /></div>";
						echo <<<END
							<script>$('body').append("{$appendInfos}")</script>
							END;
					}
				}
			}
	 	?>
	</body>
</html>
