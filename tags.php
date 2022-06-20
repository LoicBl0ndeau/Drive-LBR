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

	echo "test";
	if(isset($_SESSION['random_ok_tag'], $_POST['randomformCAT']) && $_POST['randomformCAT'] == $_SESSION['random_ok_tag']){
		echo("tst");
		if (isset($_POST['boutonvalidecat'])) {
			echo('eeeee');
			require('connect.php');
			$query = "INSERT INTO categorie(Nom,Créateur) values(?,?)";
			$resultStatement = $PDO->prepare($query);
			$resultStatement->execute(array($_POST['input_cat'],$_SESSION['loggedUser']['Id_Profil']));
			$result = $resultStatement->fetchAll();

		}
	}
if(isset($_SESSION['random_ok_tag'], $_POST['randomformTAG']) && $_POST['randomformTAG'] == $_SESSION['random_ok_tag']){
	if (isset($_POST['boutonvalidetag'])) {
		echo('ee');
		if(empty($_POST['input_tag'])){
			echo('coco');

		require('connect.php');
		echo('bou');
		$query = "INSERT INTO tag(Nom,Créateur) values(?,?)";
		$resultStatement = $PDO->prepare($query);
		$resultStatement->execute(array($_POST['input_tag'],$_SESSION['loggedUser']['Id_Profil']));
		$result = $resultStatement->fetchAll();
		echo($_SESSION['loggedUser']['Id_Profil']);
		echo($_POST['input_tag']);
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

				$resultStatement = $PDO->query('SELECT Nom from categorie');
				$result = $resultStatement->fetchAll();

				?>


    </span>
    <span id="Tags">
      <h1>Tags</h1>

      <div class="plus" id="plus_tag">+</div><br/>

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

<?php

if (isset($_POST['boutonvalidecat'])) {

	require('connect.php');
	$query = "INSERT INTO categorie(Nom,Créateur) values(?,?)";
	$resultStatement = $PDO->prepare($query);
	$resultStatement->execute(array($_POST['input_cat'],$_SESSION['loggedUser']['Id_Profil']));
	$result = $resultStatement->fetchAll();

}

if (isset($_POST['boutonvalidetag'])) {

	require('connect.php');
	echo('bou');
	$query = "INSERT INTO tag(Nom,Créateur) values(?,?)";
	$resultStatement = $PDO->prepare($query);
	$resultStatement->execute(array($_POST['input_tag'],$_SESSION['loggedUser']['Id_Profil']));
	$result = $resultStatement->fetchAll();
	echo($_SESSION['loggedUser']['Id_Profil']);
	echo($_POST['input_tag']);

}
?>


</html>
