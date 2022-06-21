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



	if(isset($_SESSION['random_ok_tag'], $_POST['randomformCAT']) && $_POST['randomformCAT'] == $_SESSION['random_ok_tag']){
		//echo("tst");

		if (isset($_POST['boutonvalidecat'])) {
			if(empty($_POST['input_cat'])){
				echo('nom de la catégorie vide');
			}

			else{
				require('connect.php');
				$sqlQuery = 'SELECT Nom FROM categorie';
				$recipesStatement = $PDO->prepare($sqlQuery);
				$recipesStatement->execute();
				$catego = $recipesStatement->fetchAll();

				$same_cat = 0;
							foreach ($catego as $cat) {
									if ($cat['Nom'] === $_POST['input_cat']) {
													$same_cat++;
											echo "le nom semble déjà utilisé";
									}
											else {
										//echo('oklm');
									}
							}
							//echo $same_cat;
							if($same_cat=== 0){
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
if(isset($_SESSION['random_ok_tag'], $_POST['randomformTAG']) && $_POST['randomformTAG'] == $_SESSION['random_ok_tag']){
	if (isset($_POST['boutonvalidetag'])) {
		//echo('ee');
		if(empty($_POST['input_tag'])){
			echo('nom du tag vide');
		}

		else{
			require('connect.php');
			$sqlQuery = 'SELECT Nom FROM tag';
			$recipesStatement = $PDO->prepare($sqlQuery);
			$recipesStatement->execute();
			$tags = $recipesStatement->fetchAll();

			$same_tag = 0;
						foreach ($tags as $tag) {
								if ($tag['Nom'] === $_POST['input_tag']) {
												$same_tag++;
										echo "le nom semble déjà utilisé";
								}
										else {
									//echo('oklm');
								}
						}
						//echo $same_tag;
						if($same_tag=== 0){
							require('connect.php');
							//echo('bou');
							$query = "INSERT INTO tag(Nom,Créateur) values(?,?)";
							$resultStatement = $PDO->prepare($query);
							$resultStatement->execute(array($_POST['input_tag'],$_SESSION['loggedUser']['Id_Profil']));
							$result = $resultStatement->fetchAll();

						}

					}
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
      <h1>Catégories de tags</h1>

        <div class="plus" id="plus_cat">+</div><br/>
				<?php
				require('connect.php');
				$sqlQuery = 'SELECT * FROM categorie';
				$recipesStatement = $PDO->query($sqlQuery);
				$catego = $recipesStatement->fetchAll();

							foreach ($catego as $cat) {
									echo '<div class="cat" id_cat="'.$cat['Id_Catégorie'].'">'.$cat['Nom'].'</div></br>';
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
				$sqlQuery = 'SELECT Nom from tag where Id_Catégorie=?';
				$recipesStatement = $PDO->prepare($sqlQuery);
				$recipesStatement->execute(array($id_cat[0]));
				$nametags=$recipesStatement->fetchAll();
				echo "<div class='container_tags_par_cat' id_cat='".$id_cat[0]."'>";
				foreach ($nametags as $nametag) {
					echo "<div class='tag'>".$nametag[0]."</div>";
				}
				echo "</div>";

			}
			/*for ($i=0; $i <$nbrcat[0] ; $i++) {
				$sqlQuery = 'SELECT COUNT(*) from tag WHERE Id_Categorie=;
				$recipesStatement = $PDO->query($sqlQuery);
				$nbrtag=$recipesStatement->fetch();
				echo
				for ($i=0; $i < ; $i++) {
					// code...
				}
			}*/






			?>

    </span>
  </div>
	<form method="post" id="ajoutcat" name='ajoutcat'>

			Nom de la catégorie:</br>
			<input type="text" id="input_cat" name="input_cat" placeholder='Entrer le nom ici' /></br>
			<input type="hidden" name="randomformCAT" value="<?php echo $_SESSION['random_ok_tag']; ?>" />

			<input type="submit" id="boutonvalidecat" name="boutonvalidecat" value="Valider"/>

	</form>



	<form method="post" id="ajouttag" name='ajouttag'>
		Nom du tag:</br>
		<input type="text" id="input_tag" name="input_tag" placeholder='Entrer le nom ici' /></br>
		<input type="hidden" name="randomformTAG" value="<?php echo $_SESSION['random_ok_tag']; ?>" />
		<input type="submit" id="boutonvalidetag" name="boutonvalidetag" value="Valider"/>
</form>

	<div id="mask_tag"></div>

</body>




</html>
