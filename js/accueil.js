$(document).ready(function(){
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
});
