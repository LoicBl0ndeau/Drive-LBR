function appendToLecteur(elem,elemW,elemH){
  $('body').css("overflow","hidden");
  if(elemW > elemH){
    elem.css("max-width","100vw").css("max-height","100vh");
  }
  else{
    elem.css("max-height","100vh").css("max-width","100vw");
  }
  $('#lecteur').append(elem).css("transform","translateY(0)");
}

$(document).ready(function(){
  $('#importer_file').on("change",function(){
    $('#form_import').submit();
  });
  $('.img_media').on("click",function(){
    appendToLecteur($(this).clone().removeClass("img_media"),$(this).width(),$(this).height());
  });
  $('.player').on("click",function(){
    appendToLecteur($('video', this).clone().prop("controls", true),$('video', this).width(),$('video', this).height());
  });
  $('#lecteur').on("click",function(){
    $('#lecteur').css("transform","translateY(-130vh)");
    $('body').css("overflow","auto");
    setTimeout(function(){
      $('#lecteur').empty();
    }, 800);
  });
  $.contextMenu({
    selector: '.img_media, .player',
    zIndex: 50,
    items: {
      informations: {
        name: "Informations"
      },
      addTags: {
        name: "Ajouter des tags"
      },
      delTags: {
        name: "Supprimer des tags"
      },
      supprimer: {
        name: "Supprimer"
      },
      telecharger: {
        name: "Télécharger",
        callback: function(itemKey, opt){
          if(opt.$trigger.hasClass("player")){
            $('#download input').attr("value",opt.$trigger.find('source').attr("src"));
          }
          else{
            $('#download input').attr("value",opt.$trigger.attr("src"));
          }
          $('#download').submit();
        }
      }
    }
  });
});
