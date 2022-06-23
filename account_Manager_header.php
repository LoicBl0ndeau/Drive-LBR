<?php
    include_once('account_Manager_variables.php');
?>

<a href="accueil.php"><img src="images/logoLONGUEURBlanc.png" alt="logo_longueur_blanc" id="logo_longueur_blanc" /></a>




<form method="post" id="recherche_account_manager" class="recherche_account_manager">
  <div id="scearch_bar">
    <input type="text" id="text_scearch_bar" placeholder="Tapez le nom d'un utilisateur" name="recherche"/>
    <button type="submit" id="bouton_submit" class="invisible"></button>
    <label for="bouton_submit">
      <!-- c'est la loupe -->
      <svg fill="#FFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">
	       <path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/>
       </svg>
     </label>
   </div>
   <div id="bascule_account_manager">
     <!-- c'est la bascule -->
     <input type="checkbox" id="toggle" class="checkbox invisible" name="null">
     <label for="toggle" id="bascule" class="bascule"></label>
     <span class="tooltiptext">Afficher les utilisateurs supprimés</span>
   </div>
</form>


<div id="container_header_right">
	<img src="images/pdp_user.jpg" alt="pdp_utilisateur" id="pdp_user" />
</div>
