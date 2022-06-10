<?php // importer des photos
	if(isset($_SESSION['random_ok_pdp'], $_POST['randomformOKpdp']) && $_POST['randomformOKpdp'] == $_SESSION['random_ok_pdp']){ // Protection contre "actualiser la page"


		  if(isset($_FILES['photodeprofil']) && $_FILES['photodeprofil']['error'] == 0){
				if($_FILES['photodeprofil']['size'] <= 1000000000){ //max 1Go
			    include("connect.php");
					$allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'tiff', 'pjp', 'jfif', 'bmp', 'svg', 'xbm', 'dib', 'jxl', 'svgz', 'webp', 'ico', 'tif', 'pjpeg', 'avif'];
					$extension = strtolower(pathinfo($_FILES['photodeprofil']['name'])['extension']);
					if(in_array($extension, $allowedExtensions)){ //on vérifie que l'extension est un média

						//mkdir("pdp/".$_SESSION['loggedUser']['email'], 0700);
						$nomFichier = basename($_FILES["photodeprofil"]["name"]);
						move_uploaded_file($_FILES["photodeprofil"]["tmp_name"], "pdp/".$_SESSION['loggedUser']['email']."/".$nomFichier);
						$req=$PDO->prepare("UPDATE profil set pdp=? where email=?");
			    	$req->execute(array("pdp/".$_SESSION['loggedUser']['email']."/".$nomFichier,$_SESSION['loggedUser']['email']));
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
				echo "<script>alert('Erreur lors de l'upload. Erreur n°".$_FILES['photodeprofil']['error']."');</script>";
			}
		}

	unset($_POST['randomformOKpdp']);
	// Protection contre "actualiser la page" ou envoi depuis l'extérieur (vol de formulaire)
	$_SESSION['random_ok_pdp'] = uniqid(); // nombre aléatoire unique
?>



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
      <label for="changer_pdp" id="pdp">
          <img src="upload/11/logo test.png" alt="pdp_utilisateur" id="pdp_profil" />
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
    <span>31<br />photos</span>
    <span></span>
    <span>5<br />vidéos</span>
  </div>
  <div id="container_profil_buttons">
    <button type="button">Mon profil</button>
    <button type="button" onclick="window.location.href='http://localhost/drive_lbr/account_Manager.php';" >Admin</button> <!-- c'est en attendant le bon menu -->
    <button type="button">Corbeille</button>
  </div>
</div>

<script type="text/javascript">
  $('#pdp_user').on("click",function(){
    $('#profil').css("transform","translate(0,-50%)");
    $('#mask_profil').css("transform","translateX(0)");
    $('*:not(#mask_profil,html,body, #profil,#profil *)').css("filter","blur(2px)");
  });
  $('#mask_profil').on("click",function(){
    $('#profil').css("transform","translate(100vw,-50%)");
    $('#mask_profil').css("transform","translateX(100vw)");
    $('*:not(#mask_profil,html,body, #profil,#profil *)').css("filter","blur(0)");
  });
  $('#container_deconnexion *').on("click",function(){
    window.location.replace("logout.php");
  });
  $('#changer_pdp').on("change",function(){
    alert("test");
    $('#form_profil').submit();
  });
</script>
