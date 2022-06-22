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

//	echo "test";


//Ajouter une Catégorie de Tags
	if(isset($_SESSION['random_ok_tag'], $_POST['randomformCAT']) && $_POST['randomformCAT'] == $_SESSION['random_ok_tag']){
		//echo("tst");

		if (isset($_POST['boutonvalidecat'])) {
			if(empty($_POST['input_cat'])){
				echo '<script>alert("Nom de la catégorie vide");</script>';
			}

			else{
				require('connect.php');
				$sqlQuery = 'SELECT Nom FROM categorie';
				$recipesStatement = $PDO->prepare($sqlQuery);
				$recipesStatement->execute();
				$catego = $recipesStatement->fetchAll();

				$same_cat = 0;
							foreach ($catego as $cat) {
									if ($cat['Nom'] == $_POST['input_cat']) {
													$same_cat++;
											echo "<script>alert('Le nom semble déjà utilisé');</script>";
									}
											else {
										//echo('oklm');
									}
							}
							//echo $same_cat;
							if($same_cat== 0){
								//echo('eeeee');
								require('connect.php');
								$query = "INSERT INTO categorie(Nom,Créateur) values(?,?)";
								$resultStatement = $PDO->prepare($query);
								$resultStatement->execute(array($_POST['input_cat'],$_SESSION['loggedUser']['Id_Profil']));
								$result = $resultStatement->fetchAll();

							}

			}
		}
	}

//Ajouter un Tag
if(isset($_SESSION['random_ok_tag'], $_POST['randomformTAG']) && $_POST['randomformTAG'] == $_SESSION['random_ok_tag']){
	if (isset($_POST['boutonvalidetag'])) {
		//echo('ee');
		if(empty($_POST['input_tag'])){
			echo '<script>alert("nom du tag vide");</script>';
		}

		else{
			require('connect.php');
			$sqlQuery = 'SELECT Nom FROM tag';
			$recipesStatement = $PDO->prepare($sqlQuery);
			$recipesStatement->execute();
			$tags = $recipesStatement->fetchAll();

			$same_tag = 0;
						foreach ($tags as $tag) {
								if ($tag['Nom'] == $_POST['input_tag']) {
												$same_tag++;
										echo "<script>alert('le nom semble déjà utilisé');</script>";
								}
										else {
									//echo('oklm');
								}
						}
						//echo $same_tag;
						if($same_tag== 0){
							require('connect.php');
							//echo('bou');
							$query = "INSERT INTO tag(Nom,Créateur,Id_Catégorie) values(?,?,?)";
							$resultStatement = $PDO->prepare($query);
							$resultStatement->execute(array($_POST['input_tag'],$_SESSION['loggedUser']['Id_Profil'],$_POST['id_cat_clicked']));
							$result = $resultStatement->fetchAll();

						}

					}
	}
}

//Modifier Nom de la Catégorie
if(isset($_SESSION['random_ok_tag'], $_POST['randomformModifCAT']) && $_POST['randomformModifCAT'] == $_SESSION['random_ok_tag']){
	if(isset($_POST['boutonModifcat'])){
		if(empty($_POST['input_modif_cat'])){
			echo '<script>alert("Nom de la catégorie vide");</script>';
		}
		else{
			require('connect.php');
			$query = "UPDATE categorie SET Nom = ? WHERE Id_Catégorie=?";
			$resultStatement = $PDO->prepare($query);
			$resultStatement->execute(array($_POST['input_modif_cat'],$_POST['id_cat_clicked']));
		}
	}
}

//Supprimer Catégorie
if(isset($_SESSION['random_ok_tag'], $_POST['randomformSuppCAT']) && $_POST['randomformSuppCAT'] == $_SESSION['random_ok_tag']){
	if(isset($_POST['boutonSuppcat'])){
		require('connect.php');
		$query = "DELETE FROM categorie WHERE Id_Catégorie = ?";
		$resultStatement = $PDO->prepare($query);
		$resultStatement->execute(array($_POST['id_cat_clicked']));
	}
}

//Modifier nom du tag
if(isset($_SESSION['random_ok_tag'], $_POST['randomformModifTAG']) && $_POST['randomformModifTAG'] == $_SESSION['random_ok_tag']){
	if(isset($_POST['boutonModiftag'])){
		if(empty($_POST['input_modif_tag'])){
			echo '<script>alert("Nom du tag vide");</script>';
		}
		else if($_POST['id_tag_clicked'] == 0){
			echo '<script>alert("Vous ne pouvez pas modifier ce tag");</script>';
		}
		else{
			require('connect.php');
			$query = "UPDATE tag SET Nom = ? WHERE Id_Tag=?";
			$resultStatement = $PDO->prepare($query);
			$resultStatement->execute(array($_POST['input_modif_tag'],$_POST['id_tag_clicked']));
		}
	}
}

//Supprimer Tag
if(isset($_SESSION['random_ok_tag'], $_POST['randomformSuppTAG']) && $_POST['randomformSuppTAG'] == $_SESSION['random_ok_tag']){
	if(isset($_POST['boutonSupptag'])){
		require('connect.php');
		$query = "DELETE FROM tag WHERE Id_Tag = ?";
		$resultStatement = $PDO->prepare($query);
		$resultStatement->execute(array($_POST['id_tag_clicked']));
	}
}


	unset($_POST['randomformTAG']);
	unset($_POST['randomformCAT']);

	$_SESSION['random_ok_tag']=uniqid();
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
  <script src="js/tags.js"></script>
  <title>Drive - Les Briques Rouges</title>
</head>
<body>
  <header>
    <a href="accueil.php"><img src="images/logoLONGUEURBlanc.png" alt="logo_longueur_blanc" id="logo_longueur_blanc" /></a>

    <div id="container_header_right">


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
      <h1 style="text-align: center;margin-bottom: 10px;">Catégories de tags</h1>

        <div class="plus" id="plus_cat">+</div><br/>
				<?php
				require('connect.php');
				$sqlQuery = 'SELECT * FROM categorie';
				$recipesStatement = $PDO->query($sqlQuery);
				$catego = $recipesStatement->fetchAll();
				$penSvg = '<svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">'.
										'<path d="M0,2A2,2,0,0,1,2,0H4A2,2,0,0,1,6,2V18L3,23,0,18Z" transform="translate(18.01 2.247) rotate(45)" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="1.5"/>'.
    								'<path d="M0,1H5" transform="translate(15.536 5.429) rotate(45)" fill="none" stroke="#000" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1.5"/>'.
									'</svg>';
				foreach ($catego as $cat) {
					if($cat['Id_Catégorie'] == 0){
						echo '<div class="container_tags_options"><input type="radio" id="radio_'.$cat['Id_Catégorie'].'" name="radio_cat" /><label class="cat" for="radio_'.$cat['Id_Catégorie'].'" id_cat="'.$cat['Id_Catégorie'].'">'.$cat['Nom'].'</label></div></br>';
					}
					else{
						echo '<div class="container_tags_options"><span class="pen_modifier_cat">'.$penSvg.'</span><input type="radio" id="radio_'.$cat['Id_Catégorie'].'" name="radio_cat" /><label class="cat" for="radio_'.$cat['Id_Catégorie'].'" id_cat="'.$cat['Id_Catégorie'].'">'.$cat['Nom'].'</label><span class="delete_cat">✖</span></div></br>';
					}
				}



				?>


    </span>
    <span id="Tags">
      <h1>Tags</h1>

      <div class="plus" id="plus_tag">+</div><br/>
			<?php
			require('connect.php');
			$sqlQuery = 'SELECT Id_Catégorie from categorie';
			$recipesStatement = $PDO->query($sqlQuery);
			$nbrcat=$recipesStatement->fetchAll();
			//echo $nbrcat[0];
			foreach ($nbrcat as $id_cat) {
				//echo $id_cat[0];
				$sqlQuery = 'SELECT * from tag where Id_Catégorie=?';
				$recipesStatement = $PDO->prepare($sqlQuery);
				$recipesStatement->execute(array($id_cat[0]));
				$nametags=$recipesStatement->fetchAll();
				$moveSvg = '<svg height="20" width="20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 330 330" style="enable-background:new 0 0 330 330;" xml:space="preserve">'.
											'<path d="M325.606,154.394l-37.5-37.5c-4.289-4.291-10.744-5.572-16.347-3.252c-5.605,2.322-9.26,7.791-9.26,13.858V150H180V67.5h22.5c6.067,0,11.536-3.655,13.858-9.26c2.321-5.605,1.038-12.057-3.252-16.347l-37.5-37.5c-5.857-5.858-15.355-5.858-21.213,0l-37.5,37.5c-4.29,4.29-5.573,10.742-3.252,16.347c2.322,5.605,7.792,9.26,13.858,9.26H150V150H67.5v-22.5c0-6.067-3.655-11.537-9.26-13.858c-5.606-2.321-12.058-1.038-16.347,3.252l-37.5,37.5c-5.858,5.858-5.858,15.355,0,21.213l37.5,37.5c2.87,2.87,6.705,4.394,10.61,4.394c1.932,0,3.881-0.374,5.737-1.142c5.605-2.322,9.26-7.792,9.26-13.858V180H150v82.5h-22.5c-6.067,0-11.537,3.655-13.858,9.26c-2.321,5.605-1.038,12.057,3.252,16.347l37.5,37.5C157.322,328.536,161.161,330,165,330s7.678-1.464,10.606-4.394l37.5-37.5c4.29-4.29,5.573-10.742,3.252-16.347c-2.322-5.605-7.791-9.26-13.858-9.26H180V180h82.5v22.5c0,6.067,3.654,11.537,9.26,13.858c1.855,0.769,3.805,1.142,5.737,1.142c3.903,0,7.74-1.524,10.609-4.394l37.5-37.5C331.465,169.749,331.465,160.252,325.606,154.394z"/>'.
									 '</svg>';
				echo "<div class='container_tags_par_cat' id_cat='".$id_cat[0]."'>";
				foreach ($nametags as $nametag) {
					if($nametag['Id_Catégorie'] == 0){
						echo "<div class='container_tags_options'><div class='tag' id_tag='".$nametag['Id_Tag']."'>".$nametag['Nom']."</div></div>";
					}
					else{
						echo "<div class='container_tags_options'><span class='move_tag'>".$moveSvg."</span><div class='tag' id_tag='".$nametag['Id_Tag']."'>".$nametag['Nom']."</div><span class='delete_tag'>✖</span></div>";
					}
				}
				echo "</div>";
			}

			?>

    </span>
  </div>
	<form method="post" id="ajoutcat" name='ajoutcat'>

			Nom de la catégorie:</br>
			<input type="text" id="input_cat" name="input_cat" placeholder='Entrer le nom ici' /></br>
			<input type="hidden" name="randomformCAT" value="<?php echo $_SESSION['random_ok_tag']; ?>" />

			<input type="submit" id="boutonvalidecat" name="boutonvalidecat" value="Valider"/>

	</form>
	<form method="post" id="modifiercat" name='modifiercat'>

			Modifier le nom de la catégorie:</br>
			<input type="text" id="input_modif_cat" name="input_modif_cat" placeholder='Entrer le nouveau nom ici' /></br>
			<input type="hidden" name="randomformModifCAT" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
			<input type="hidden" class="id_cat_clicked" name="id_cat_clicked" />
			<input type="submit" name="boutonModifcat" value="Valider"/>

	</form>
	<form method="post" id="suppcat" name='suppcat'>

			Voulez-vous vraiment supprimer cette catégorie ?</br>
			<input type="hidden" name="randomformSuppCAT" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
			<input type="hidden" class="id_cat_clicked" name="id_cat_clicked" />
			<input type="submit" name="boutonSuppcat" value="Valider"/>

	</form>

	<form method="post" id="ajouttag" name='ajouttag'>
		Nom du tag:</br>
		<input type="text" id="input_tag" name="input_tag" placeholder='Entrer le nom ici' /></br>
		<input type="hidden" name="randomformTAG" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
		<input type="hidden" class="id_cat_clicked" name="id_cat_clicked" />
		<input type="submit" id="boutonvalidetag" name="boutonvalidetag" value="Valider"/>
	</form>
	<form method="post" id="modifiertag" name='modifiertag'>

			Modifier le nom du tag:</br>
			<input type="text" id="input_modif_tag" name="input_modif_tag" placeholder='Entrer le nouveau nom ici' /></br>
			<input type="hidden" name="randomformModifTAG" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
			<input type="hidden" class="id_tag_clicked" name="id_tag_clicked" />
			<input type="submit" name="boutonModiftag" value="Valider"/>

	</form>
	<form method="post" id="supptag" name='supptag'>

			Voulez-vous vraiment supprimer ce tag ?</br>
			<input type="hidden" name="randomformSuppTAG" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
			<input type="hidden" class="id_tag_clicked" name="id_tag_clicked" />
			<input type="submit" name="boutonSupptag" value="Valider"/>

	</form>
	<div id="mask_tag"></div>

</body>




</html>
