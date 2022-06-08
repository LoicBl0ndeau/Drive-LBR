$(document).ready(function(){
  $('#togglePassword').on("click",function(){
    if($('#mdp').attr("type") == "password"){
      $('#mdp').attr("type","text");
    }
    else{
      $('#mdp').attr("type","password");
    }
    this.classList.toggle('bi-eye');
  });
});
