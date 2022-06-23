$(document).ready(function(){

  if (sessionStorage.getItem('morts') == 1) {
    $('#toggle').attr('checked', 'checked');
  }
  else {
    $('#toogle').attr('checked', '');
  }

  $('#bascule').on("click",function(){
    if ($('#toggle').prop('checked')) {
      sessionStorage.setItem('morts', 0);
    }
    else {
      sessionStorage.setItem('morts', 1);
    }
    setTimeout(function(){
      $('#recherche_account_manager').submit();

    }, 300);
  });



});
