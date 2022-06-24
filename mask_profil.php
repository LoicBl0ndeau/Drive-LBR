<?php // importer des photos
	if(isset($_SESSION['random_ok_pdp'], $_POST['randomformOKpdp']) && $_POST['randomformOKpdp'] == $_SESSION['random_ok_pdp']){ // Protection contre "actualiser la page"


		  if(isset($_FILES['photodeprofil']) && $_FILES['photodeprofil']['error'] == 0){
				if($_FILES['photodeprofil']['size'] <= 1000000000){ //max 1Go
			    include("connect.php");
					$allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'tiff', 'pjp', 'jfif', 'bmp', 'svg', 'xbm', 'dib', 'jxl', 'svgz', 'webp', 'ico', 'tif', 'pjpeg', 'avif'];
					$extension = strtolower(pathinfo($_FILES['photodeprofil']['name'])['extension']);
					if(in_array($extension, $allowedExtensions)){ //on vérifie que l'extension est un média
						if(!file_exists("pdp/".$_SESSION['loggedUser']['email'])){
							mkdir("pdp/".$_SESSION['loggedUser']['email'], 0700);
						}
						$nomFichier = basename($_FILES["photodeprofil"]["name"]);
						$path_pdp = "pdp/".$_SESSION['loggedUser']['email']."/".$nomFichier;
						move_uploaded_file($_FILES["photodeprofil"]["tmp_name"], $path_pdp);
						$req=$PDO->prepare("SELECT * FROM profil where email=?");
			    	$req->execute(array($_SESSION['loggedUser']['email']));
						$res = $req->fetchAll()[0]['pdp'];
						if($res != "images/pdp_user.jpg"){
							unlink($res);
						}
						$req=$PDO->prepare("UPDATE profil set pdp=? where email=?");
			    	$req->execute(array($path_pdp,$_SESSION['loggedUser']['email']));
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
				echo "<script>alert('Erreur lors de l\'upload. Erreur n°".$_FILES['media']['error'][$i].". Voir https://www.php.net/manual/fr/features.file-upload.errors.php');</script>";
			}
		}

	unset($_POST['randomformOKpdp']);
	// Protection contre "actualiser la page" ou envoi depuis l'extérieur (vol de formulaire)
	$_SESSION['random_ok_pdp'] = uniqid(); // nombre aléatoire unique
?>

<?php

$postData = $_POST;

if (
	isset($_POST['new_Prenom']) && !empty($_POST['new_Prenom']) &&
	isset($_POST['new_Nom']) && !empty($_POST['new_Nom'])
	)
{
	if ($_POST['new_Prenom'] != $_SESSION['loggedUser']['Prenom']) {
		//echo "vous avez modifié votre Prénom";

		$new_Prenom = strip_tags($postData['new_Prenom']);

		include("connect.php");

		// Ecriture de la requête
		$sqlQuery = 'UPDATE profil SET Prenom = :Prenom WHERE Id_Profil = :Id_Profil';

		// Préparation
		$edited_user = $PDO->prepare($sqlQuery);

		// Exécution ! l'utilisateur est maintenant en base de données
		$edited_user->execute([
				'Id_Profil' => $_SESSION['loggedUser']['Id_Profil'],
				'Prenom' => $new_Prenom,
		]);

		$_SESSION['loggedUser']['Prenom'] = $new_Prenom;

		//   ajout d'une ligne dans le changelog
		// Ecriture de la requête
		$sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

		// Préparation
		$edited_user = $PDO->prepare($sqlQuery);

		// Exécution ! l'utilisateur est maintenant en base de données
		$edited_user->execute([
				'Nom' => $_SESSION['loggedUser']['Id_Profil'] . " : " . $_SESSION['loggedUser']['email'],
				'Date_de_modification' => date('d-m-y H:i:s'),
				'Description' => "Modification interne du Prenom par : $new_Prenom",
		]);

	}
	if ($_POST['new_Nom'] != $_SESSION['loggedUser']['Nom']) {
		//echo "vous avez modifié votre Nom";

		$new_Nom = strip_tags($postData['new_Nom']);

		include("connect.php");

		// Ecriture de la requête
		$sqlQuery = 'UPDATE profil SET Nom = :Nom WHERE Id_Profil = :Id_Profil';

		// Préparation
		$edited_user = $PDO->prepare($sqlQuery);

		// Exécution ! l'utilisateur est maintenant en base de données
		$edited_user->execute([
				'Id_Profil' => $_SESSION['loggedUser']['Id_Profil'],
				'Nom' => $new_Nom,
		]);

		$_SESSION['loggedUser']['Nom'] = $new_Nom;

		//   ajout d'une ligne dans le changelog
		// Ecriture de la requête
		$sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

		// Préparation
		$edited_user = $PDO->prepare($sqlQuery);

		// Exécution ! l'utilisateur est maintenant en base de données
		$edited_user->execute([
				'Nom' => $_SESSION['loggedUser']['Id_Profil'] . " : " . $_SESSION['loggedUser']['email'],
				'Date_de_modification' => date('d-m-y H:i:s'),
				'Description' => "Modification interne du Nom par : $new_Nom",
		]);

	}
}

if (
	isset($_POST['old_MDP']) && !empty($_POST['old_MDP']) &&
	isset($_POST['new_MDP']) && !empty($_POST['new_MDP']) &&
	isset($_POST['new_MDP_confirmation']) && !empty($_POST['new_MDP_confirmation'])
	)
{
	include_once('functions.php');
	if (!check_mdp_format($_POST['new_MDP']) || !check_mdp_format($_POST['new_MDP_confirmation']))
	{
		echo '<script>alert("Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial pour un total d\'au moins 8 caractères.")</script>';
	}
	else
	{
		include("connect.php");

		// Ecriture de la requête
		$sqlQuery = 'SELECT MDP from profil WHERE Id_Profil = :Id_Profil';

		// Préparation
		$edited_user = $PDO->prepare($sqlQuery);

		// Exécution ! l'utilisateur est maintenant en base de données
		$edited_user->execute([
				'Id_Profil' => $_SESSION['loggedUser']['Id_Profil']
		]);

		$actual_MDPs = $edited_user->fetchAll();

		$old_MDP = hash('sha256', strip_tags($postData['old_MDP']));
		$new_MDP = hash('sha256', strip_tags($postData['new_MDP']));
		$new_MDP_confirmation = hash('sha256', strip_tags($postData['new_MDP_confirmation']));

		foreach ($actual_MDPs as $actual_MDP)
		{
			if (($old_MDP == $actual_MDP['MDP']) && ($new_MDP == $new_MDP_confirmation))
			{
				//echo '<script>alert("on accepte le mdp")</script>';
				include("connect.php");

				// Ecriture de la requête
				$sqlQuery = 'UPDATE profil SET MDP = :MDP WHERE Id_Profil = :Id_Profil';

				// Préparation
				$edited_user = $PDO->prepare($sqlQuery);

				// Exécution ! l'utilisateur est maintenant en base de données
				$edited_user->execute([
				    'Id_Profil' => $_SESSION['loggedUser']['Id_Profil'],
						'MDP' => $new_MDP
				]);

				//   ajout d'une ligne dans le changelog
				// Ecriture de la requête
				$sqlQuery = 'INSERT INTO log_(Nom, Date_de_modification, Description) VALUES (:Nom, :Date_de_modification, :Description)';

				// Préparation
				$edited_user = $PDO->prepare($sqlQuery);

				// Exécution ! l'utilisateur est maintenant en base de données
				$edited_user->execute([
						'Nom' => $_SESSION['loggedUser']['Id_Profil'] . " : " . $_SESSION['loggedUser']['email'],
						'Date_de_modification' => date('d-m-y H:i:s'),
						'Description' => "Modification interne du mot de passe",
				]);

			}
			elseif ($old_MDP != $actual_MDP['MDP'])
			{
				echo '<script>alert("L\'ancien mot de passe n\'est pas le bon !")</script>';
			}
			elseif ($new_MDP != $new_MDP_confirmation) {
				echo '<script>alert("La confirmation du nouveau mot de passe n\'est pas concluante !")</script>';
			}
			else {
				echo '<script>alert("Condition(s) manquante !!!!!!!! ")</script>';
			}
		}
	}
}

?>



<div id="mask_profil"></div>
<div id="profil">
  <div id="container_profil_top">
		<div style="display: flex;justify-content: space-between;">
			<a href="accueil.php" style="margin: 5px;">
				<svg version="1.1" fill="#FFFF" width="24" height="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 251.479 251.479" style="enable-background:new 0 0 251.479 251.479;" xml:space="preserve">
					<path d="M209.355,135.551c-4.143,0-7.5,3.358-7.5,7.5v76.109H49.634v-76.109c0-4.142-3.357-7.5-7.5-7.5c-4.143,0-7.5,3.358-7.5,7.5v83.609c0,4.142,3.357,7.5,7.5,7.5h167.221c4.143,0,7.5-3.358,7.5-7.5v-83.609C216.855,138.909,213.497,135.551,209.355,135.551z" />
					<path d="M249.282,137.748L131.035,19.515c-2.928-2.929-7.677-2.928-10.606,0L2.197,137.748c-2.929,2.929-2.929,7.678,0,10.606c1.465,1.464,3.385,2.197,5.304,2.197c1.92,0,3.839-0.732,5.304-2.197l112.929-112.93l112.943,112.93c2.928,2.929,7.677,2.928,10.607-0.001C252.211,145.425,252.211,140.676,249.282,137.748z"/>
				</svg>
			</a>
			<a id="container_deconnexion">
	      <span>Déconnexion</span>
	      <svg fill="none" height="24" stroke-width="1.5" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12H19M19 12L16 15M19 12L16 9" stroke="#FFFF" stroke-linecap="round" stroke-linejoin="round"/>
	        <path d="M19 6V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V18" stroke="#FFFF" stroke-linecap="round" stroke-linejoin="round"/>
	      </svg>
	    </a>
		</div>
    <div id="container_pdp_profil">
      <label for="changer_pdp" id="pdp">
          <img src="<?php include("connect.php");$req=$PDO->prepare("SELECT * FROM profil where email=?");$req->execute(array($_SESSION['loggedUser']['email']));$res = $req->fetchAll()[0]['pdp'];echo $res; ?>" alt="pdp_utilisateur" id="pdp_profil" />
					<?php echo "<script>$('#pdp_user').attr('src','".$res."');</script>" ?>
      </label>
      <form id="form_profil" method="post" enctype="multipart/form-data">
        <input type="file" id="changer_pdp" name="photodeprofil" accept="image/*" />
        <input type="hidden" name="randomformOKpdp" value="<?php echo $_SESSION['random_ok_pdp']; ?>" />
      </form>

    </div>
    <p id="name"></p>
    <p id="role"></p>
  </div>
  <div id="container_profil_stats">
    <span>
			<?php
				$req=$PDO->prepare("SELECT * FROM fichier where Auteur_Id=?");
				$req->execute(array($_SESSION['loggedUser']['Id_Profil']));
				$res = $req->fetchAll();
				$compteur = 0;
				$extensionsImage = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/tiff', 'image/bmp', 'image/svg+xml', 'image/x-xbitmap', 'image/jxl', 'image/webp', 'image/x-icon', 'image/avif'];
				foreach ($res as $imgs) {
					if(in_array($imgs['Type'],$extensionsImage)){
						$compteur++;
					}
				}
				echo $compteur;
			?>
			<br />photos
		</span>
    <span></span>
    <span>
			<?php
				$req=$PDO->prepare("SELECT * FROM fichier where Auteur_Id=?");
				$req->execute(array($_SESSION['loggedUser']['Id_Profil']));
				$res = $req->fetchAll();
				$compteur = 0;
				$extensionsImage = ['video/ogg','video/x-ms-wmv','video/mpeg','video/webm','video/quicktime','video/x-ms-asf','video/mp4','video/avi'];
				foreach ($res as $imgs) {
					if(in_array($imgs['Type'],$extensionsImage)){
						$compteur++;
					}
				}
				echo $compteur;
			?>
			<br />vidéos
		</span>
		<span></span>
		<span>
			<?php $req=$PDO->prepare("SELECT SUM(Taille) FROM fichier where Auteur_Id=?");
			$req->execute(array($_SESSION["loggedUser"]["Id_Profil"]));
			$res = $req->fetch();
			echo round(0.000001*$res[0],2).'</br>Mo';


			 ?>
  </div>
  <div id="container_profil_buttons">
    <button id="mon_profil" type="button">Mon profil</button>

<?php if($_SESSION["loggedUser"]["Role"]=="Admin") : ?>
    <button type="button" onclick="window.location.href='account_Manager_accueil.php';" >Gestionnaire de compte</button> <!-- c'est en attendant le bon menu -->
		<button type="button" onclick="window.location.href='changelog.php';" >Historique de modification</button> <!-- c'est en attendant le bon menu -->
		<button type="button" onclick="window.location.href='stockage.php';">Stockage</button>
<?php endif ?>
    <button type="button" onclick="window.location.href='corbeille.php'">Corbeille</button>
  </div>
	<span id="container_profil_page">
		<form method="post">
			<div class="mb-3">
					<label for="Prenom" class="form-label">Prenom</label>
					<input type="text" class="form-control_PP" id="Prenom" name="new_Prenom" value="<?php echo $_SESSION['loggedUser']['Prenom'] ?>">
			</div>
			<div class="mb-3">
					<label for="Nom" class="form-label">Nom</label>
					<input type="text" class="form-control_PP" id="Nom" name="new_Nom" value="<?php echo $_SESSION['loggedUser']['Nom'] ?>">
			</div>
			<input type="checkbox" name="MDP_changed" id="btn_modifier_le_mdp" value="1">Modifier le mot de passe</input>
			<div class="mb-3" id="modifier_le_mdp">
					<label for="old_MDP" class="form-label">Ancien Mot de passe</label>
					<input type="password" class="form-control_PP" id="old_MDP" name="old_MDP">
					<label for="new_MDP" class="form-label">Nouveau Mot de passe</label>
					<input type="password" class="form-control_PP" id="new_MDP" name="new_MDP">
					<label for="new_MDP_confirmation" class="form-label">Confirmation du nouveau Mot de passe</label>
					<input type="password" class="form-control_PP" id="new_MDP_confirmation" name="new_MDP_confirmation">
			</div>
			<div style="display: flex;justify-content: space-between;">
				<button type="submit">Valider</button>
				<button id="mon_profil_escape" type="button">Retour</button>
			</div>
		</form>
	</span>
</div>

<script type="text/javascript">
  $('#pdp_user').on("click",function(){
    $('#profil').css("transform","translate(0,-50%)");
    $('#mask_profil').css("transform","translateX(0)");
		$('#container_profil_page').css("display","none");
    $('*:not(#mask_profil,html,body, #container_header_right, header, #profil,#profil *)').css("filter","blur(2px)");
  });
  $('#mask_profil').on("click",function(){
    $('#profil').css("transform","translate(100vw,-50%)");
    $('#mask_profil').css("transform","translateX(100vw)");
    $('*:not(#mask_profil,html,body, #profil,#profil *)').css("filter","");
  });
	$('#mon_profil').on("click",function(){
    $('#container_profil_page').css("display","flex");
		$('#modifier_le_mdp').css("display","none");
		$('#container_profil_buttons').css("display","none");
  });
	$('#mon_profil_escape').on("click",function(){
    $('#container_profil_page').css("display","none");
		$('#container_profil_buttons').css("display","flex");
  });


  $('#container_deconnexion *').on("click",function(){
    window.location.replace("logout.php");
  });
  $('#changer_pdp').on("change",function(){
    $('#form_profil').submit();
  });

	$('#btn_modifier_le_mdp').on('click', function(){
	  isChecked = $(this).is(':checked')

	  if(isChecked){
	    $('#modifier_le_mdp').css("display","block");
	  }
	  else{
	    $('#modifier_le_mdp').css("display","none");
	  }
	});


</script>
