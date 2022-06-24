$(document).ready(function(){

  if (sessionStorage.getItem('afficher_les_users_supprimés') == 1) {
    $('#toggle').attr('checked', 'checked');
  }
  else {
    $('#toogle').attr('checked', '');
  }

  $('#bascule').on("click",function(){
    if ($('#toggle').prop('checked')) {
      sessionStorage.setItem('afficher_les_users_supprimés', 0);
    }
    else {
      sessionStorage.setItem('afficher_les_users_supprimés', 1);
    }
    setTimeout(function(){
      $('#recherche_account_manager').submit();

    }, 300);
  });



});
