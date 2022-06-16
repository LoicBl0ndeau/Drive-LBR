function img_media_open(){
  $('.img_media').off("click",img_media_open);
  $('.player').off("click",player_open);
  appendToLecteur($(this).clone().removeClass("img_media"),$(this).width(),$(this).height());
}

function player_open(){
  $('.player').off("click",player_open);
  $('.img_media').off("click",img_media_open);
  appendToLecteur($('video', this).clone().prop("controls", true),$('video', this).width(),$('video', this).height());
}

function appendToLecteur(elem,elemW,elemH){
  $('body').css("overflow","hidden");
  if(elemW > elemH){
    elem.css("max-width","100vw").css("max-height","100vh");
  }
  else{
    elem.css("max-height","100vh").css("max-width","100vw");
  }
  $('#lecteur').append(elem).css("transform","translateY(0)");
  setTimeout(function(){
    $('#lecteur').on("click",fermerLecteur);
  }, 800);
}

function fermerLecteur(){
  $('#lecteur').off("click",fermerLecteur);
  $('#lecteur').css("transform","translateY(-130vh)");
  $('body').css("overflow","auto");
  setTimeout(function(){
    $('#lecteur').empty();
    $('.img_media').on("click",img_media_open);
    $('.player').on("click",player_open);
  }, 800);
}

$(document).ready(function(){
  $('#importer_file').on("change",function(){
    $('#form_import').submit();
  });
  $('.img_media').on("click",img_media_open);
  $('.player').on("click",player_open);
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
        name: "Supprimer",
        callback: function(itemKey, opt){
          if(opt.$trigger.hasClass("player")){
            $('#delete input[name=delete]').attr("value",opt.$trigger.find('source').attr("src"));
          }
          else{
            $('#delete input[name=delete]').attr("value",opt.$trigger.attr("src"));
          }
          $('#delete').submit();
        }
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
