$(document).ready(function(){
  $('#bouton_login').on("click",function(){
    $('.rocket').css("animation-name","launch");
    setTimeout(function(){
      window.location.href = "file:///C:/Users/loicb/Documents/GitHub/Drive_LBR/accueil.html";
    }, 1500);
  })
});
