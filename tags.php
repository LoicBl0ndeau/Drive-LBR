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
						$req=$PDO->prepare("insert into fichier(Type,Titre,Auteur,Taille,Date_de_publication,bin) values(?,?,?,?,?,?)");
			    	$req->execute(array($_FILES["media"]["type"][$i],$_FILES["media"]["name"][$i],$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom'],$_FILES["media"]["size"][$i],$date,$chemin));
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
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="Auteurs" content="Loïc BLONDEAU;Louis BOUBERT;Martin CAPELLE;Ilies BENSLAMA" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
  <link rel="icon" href="images/favicon.ico" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/tags.js"></script>
  <title>Drive - Les Briques Rouges</title>
</head>
<body>
  <header>
    <a href="accueil.php"><img src="images/logoLONGUEURBlanc.png" alt="logo_longueur_blanc" id="logo_longueur_blanc" /></a>

    <div id="container_header_right">
      <label for="importer_file" id="importer">
        <svg fill="#FFFF" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512" width="27px" height="27px">
          <path d="m153.7,171.5l81.9-88.1v265.3c0,11.3 9.1,20.4 20.4,20.4 11.3,0 20.4-9.1 20.4-20.4v-265.3l81.9,88.1c7.7,8.3 20.6,8.7 28.9,1.1 8.3-7.7 8.7-20.6 1.1-28.9l-117.3-126.2c-11.5-11.6-25.6-5.2-29.9,0l-117.3,126.2c-7.7,8.3-7.2,21.2 1.1,28.9 8.2,7.6 21.1,7.2 28.8-1.1z"/>
          <path d="M480.6,341.2c-11.3,0-20.4,9.1-20.4,20.4V460H51.8v-98.4c0-11.3-9.1-20.4-20.4-20.4S11,350.4,11,361.6v118.8    c0,11.3,9.1,20.4,20.4,20.4h449.2c11.3,0,20.4-9.1,20.4-20.4V361.6C501,350.4,491.9,341.2,480.6,341.2z"/>
        </svg>
        Importer
      </label>
      <form id="form_import" method="post" enctype="multipart/form-data">
        <input type="file" id="importer_file" name="media[]" accept="video/*,image/*" multiple />
        <input type="hidden" name="randomformOK" value="<?php echo $_SESSION['random_OK']; ?>" />
      </form>
      <img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
    </div>
  </header>

  <!-- Page Profil -->
  <?php include_once('mask_profil.php'); ?>

  <?php
    echo "<script>$('#name').text('".$_SESSION['loggedUser']['Prenom']." ".$_SESSION['loggedUser']['Nom']."');$('#role').text('".$_SESSION['loggedUser']['Role']."');</script>";
  ?>
  <div id="container_tags">
    <span id="catégories_de_tags">
      <h1>Catégories de tags</h1>

        <div class="plus" id="plus_cat">+</div><br/>


    </span>
    <span id="Tags">
      <h1>Tags</h1>

      <div class="plus" id="plus_tags">+</div><br/>

    </span>
  </div>

	<div id="ajoutcat">
		
	</div>
	<div id="mask_tag"></div>

</body>
</html>
