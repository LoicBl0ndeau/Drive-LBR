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
    <button type="button" onclick="window.location.href='http://localhost/drive_lbr/account_Manager_accueil	.php';" >Admin</button> <!-- c'est en attendant le bon menu -->
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
</script>
