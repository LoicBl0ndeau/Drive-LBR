function mois(month){
  switch (month) {
    case 1:
      month = "Janvier";
    break;
    case 2:
      month = "Février";
    break;
    case 3:
      month = "Mars";
    break;
    case 4:
      month = "Avril";
    break;
    case 5:
      month = "Mai";
    break;
    case 6:
      month = "Juin";
    break;
    case 7:
      month = "Juillet";
    break;
    case 8:
      month = "Août";
    break;
    case 9:
      month = "Septembre";
    break;
    case 10:
      month = "Octobre";
    break;
    case 11:
      month = "Novembre";
    break;
    case 12:
      month = "Décembre";
    break;
  }
  return month;
}

function tagQuery(){
  if($('#text_scearch_bar').val() != ''){
    var tagsSelection = $('#text_scearch_bar').val().split(';');
    var datesQuery = [];
    var extensionsQuery = [];
    var auteursQuery = [];
    var extensionsAutorisees = ['.ogm', '.wmv', '.mpg', '.webm', '.ogv', '.mov', '.asx', '.mpeg', '.mp4', '.m4v', '.avi','.jpg', '.jpeg', '.gif', '.png', '.tiff', '.pjp', '.jfif', '.bmp', '.svg', '.xbm', '.dib', '.jxl', '.svgz', '.webp', '.ico', '.tif', '.pjpeg', '.avif'];
    for (var i = 0; i < tagsSelection.length; i++) {
      if(tagsSelection[i].match(/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/) != null){
        datesQuery.push(tagsSelection[i]);
      }
      else if(extensionsAutorisees.indexOf(tagsSelection[i].toLowerCase()) != -1){
        extensionsQuery.push(tagsSelection[i].toLowerCase());
      }
      else{
        auteursQuery.push(tagsSelection[i].toLowerCase());
      }
    }
    for (var i = 0; i < $('.container_informations').length; i++) {
      var extension = $($('.container_informations')[i]).find(".nom_fichier").text().split('.');
      extension = "."+extension[extension.length-1];
      extension = extension.toLowerCase();
      var date = $($('.container_informations')[i]).find(".date_ajout_fr").text();
      var auteur = [$($('.container_informations')[i]).find(".prenom").text().toLowerCase(),$($('.container_informations')[i]).find(".nom").text().toLowerCase(),$($('.container_informations')[i]).find(".prenom").text().toLowerCase()+" "+$($('.container_informations')[i]).find(".nom").text().toLowerCase(),$($('.container_informations')[i]).find(".nom").text().toLowerCase()+" "+$($('.container_informations')[i]).find(".prenom").text().toLowerCase()];
      if(extensionsQuery.length == 0){
        var selectionnerExtension = true;
      }
      else{
        var selectionnerExtension = false;
        if(extensionsQuery.indexOf(extension) != -1){
          selectionnerExtension = true;
        }
      }
      if(datesQuery.length == 0){
        var selectionnerDate = true;
      }
      else{
        var selectionnerDate = false;
        if(datesQuery.indexOf(date) != -1){
          selectionnerDate = true;
        }
      }
      if(auteursQuery.length == 0){
        var selectionnerAuteur = true;
      }
      else{
        var selectionnerAuteur = false;
        for (var j = 0; j < auteur.length; j++) {
          if(auteursQuery.indexOf(auteur[j]) != -1){
            selectionnerAuteur = true;
          }
        }
      }
      if(selectionnerExtension === true && selectionnerDate === true && selectionnerAuteur === true){
        $('.marge[id_media='+$($('.container_informations')[i]).attr("id_media").replace("container_inf_","")+']').css("display","block");
      }
      else{
        $('.marge[id_media='+$($('.container_informations')[i]).attr("id_media").replace("container_inf_","")+']').css("display","none");
      }
    }
  }
  else{
    $('.marge').css("display","block");
  }
  for (var i = 0; i < $('.container_media').length; i++) { //pour savoir si il faut ajouter ou effacer le titre d'une catégorie de média s'il ne contient plus rien.
    var compteurMedia = 0;
    for (var j = 0; j < $($('.container_media')[i]).find('.marge').length; j++) {
      if($($($('.container_media')[i]).find('.marge')[j]).css("display") == "none"){
        compteurMedia++;
      }
    }
    if(compteurMedia == $($('.container_media')[i]).find('.marge').length){
      $('.titre_container_media[titre_associe_container_media='+$($('.container_media')[i]).attr("titre_associe_container_media")+']').css("display","none");
    }
    else{
      $('.titre_container_media[titre_associe_container_media='+$($('.container_media')[i]).attr("titre_associe_container_media")+']').css("display","block");
    }
  }
}

function selectionDesTags(){
  if($('.tag_clicked').length != 0){
    var tagsSelection = [];
    for (var i = 0; i < $('.tag_clicked').length; i++) { //On récupère les tags sélectionnés
      tagsSelection.push($($('.tag_clicked')[i]).text());
    }
    for (var i = 0; i < $('.container_informations').length; i++) {
      var tagsAssocies = $($('.container_informations')[i]).find(".liste_des_tags").text().split(', ');
      var selectionner = false;
      for (var j = 0; j < tagsAssocies.length; j++) {
        if(tagsSelection.indexOf(tagsAssocies[j]) != -1){
          selectionner = true;
        }
      }
      if(selectionner === false){
        $('.marge[id_media='+$($('.container_informations')[i]).attr("id_media").replace("container_inf_","")+']').css("display","none");
      }
      else{
        $('.marge[id_media='+$($('.container_informations')[i]).attr("id_media").replace("container_inf_","")+']').css("display","block");
      }
    }
  }
  else{
    $('.marge').css("display","block");
  }
  for (var i = 0; i < $('.container_media').length; i++) { //pour savoir si il faut ajouter ou effacer le titre d'une catégorie de média s'il ne contient plus rien.
    var compteurMedia = 0;
    for (var j = 0; j < $($('.container_media')[i]).find('.marge').length; j++) {
      if($($($('.container_media')[i]).find('.marge')[j]).css("display") == "none"){
        compteurMedia++;
      }
    }
    if(compteurMedia == $($('.container_media')[i]).find('.marge').length){
      $('.titre_container_media[titre_associe_container_media='+$($('.container_media')[i]).attr("titre_associe_container_media")+']').css("display","none");
    }
    else{
      $('.titre_container_media[titre_associe_container_media='+$($('.container_media')[i]).attr("titre_associe_container_media")+']').css("display","block");
    }
  }
}

function trier_par_dates(){
  $('.marge').css("display","flex");
  $('.titre_container_media').css("display","flex");
  var dates = [];
  for (var i = 0; i < $('.marge').length; i++) {
    if(dates.indexOf($($('.container_informations')[i]).find('.date_ajout').text()) == -1){
      dates.push($($('.container_informations')[i]).find('.date_ajout').text());
    }
  }
  dates.sort();
  if($('#checked_croissant').is(':checked') === false){
    dates.reverse();
  }
  $('.titre_container_media').remove();
  var media_dates = "";
  var compteur_container_media = 0;
  for (var i = 0; i < dates.length; i++) {
    media_dates += "<h1 style='text-align: center;' titre_associe_container_media='"+compteur_container_media+"' class='titre_container_media'>"+new Date(dates[i]).getDate()+" "+mois(parseInt(new Date(dates[i]).getMonth()+1))+" "+new Date(dates[i]).getFullYear()+"</h1><div class='container_media' titre_associe_container_media='"+compteur_container_media+"'>";
    for (var j = 0; j < $('.marge').length; j++) {
      for (var k = 0; k < $('.marge').length; k++) {
        if($($('.marge')[j]).attr("id_media") == $($('.container_informations')[k]).attr("id_media").replace("container_inf_","") && $($('.container_informations')[k]).find('.date_ajout').text() == dates[i]){
          media_dates += $("<div>").append($($('.marge')[j]).clone()).html();
        }
      }
    }
    media_dates += "</div>";
    compteur_container_media++;
  }
  $('.container_media').remove();
  $(media_dates).insertAfter($('#trier_par'));
  selectionDesTags();
  tagQuery();
  $('#text_scearch_bar').attr("placeholder",'Tapez ".mp4;24/09/2021" par exemple.');
  $('.img_media').on("click",img_media_open);
  $('.player').on("click",player_open);
}

function trier_par_auteurs(){
  $('.marge').css("display","flex");
  $('.titre_container_media').css("display","flex");
  var auteurs = [];
  for (var i = 0; i < $('.marge').length; i++) {
    if(auteurs.indexOf($($('.container_informations')[i]).find('.mail_auteurs').text()) == -1){
      auteurs.push($($('.container_informations')[i]).find('.mail_auteurs').text());
    }
  }
  auteurs.sort();
  if($('#checked_croissant').is(':checked') === false){
    auteurs.reverse();
  }
  $('.titre_container_media').remove();
  var media_auteur = "";
  var compteur_container_media = 0;
  for (var i = 0; i < auteurs.length; i++) {
    media_auteur += "<h1 style='text-align: center;' titre_associe_container_media='"+compteur_container_media+"' class='titre_container_media'>"+auteurs[i]+"</h1><div class='container_media' titre_associe_container_media='"+compteur_container_media+"'>";
    for (var j = 0; j < $('.marge').length; j++) {
      for (var k = 0; k < $('.marge').length; k++) {
        if($($('.marge')[j]).attr("id_media") == $($('.container_informations')[k]).attr("id_media").replace("container_inf_","") && $($('.container_informations')[k]).find('.mail_auteurs').text() == auteurs[i]){
          media_auteur += $("<div>").append($($('.marge')[j]).clone()).html();
        }
      }
    }
    media_auteur += "</div>";
    compteur_container_media++;
  }
  $('.container_media').remove();
  $(media_auteur).insertAfter($('#trier_par'));
  selectionDesTags();
  tagQuery();
  $('#text_scearch_bar').attr("placeholder",'Tapez ".mp4;Nom" par exemple.');
  $('.img_media').on("click",img_media_open);
  $('.player').on("click",player_open);
}

function trier_par_mesPhotos(){
  $('.marge[isMediaFromLoggedUser="0"]').css("display","none");
  for (var i = 0; i < $('.container_media').length; i++) { //pour savoir si il faut effacer le titre d'une catégorie de média car il ne contient plus rien.
    var compteurMedia = 0;
    for (var j = 0; j < $($('.container_media')[i]).find('.marge').length; j++) {
      if($($($('.container_media')[i]).find('.marge')[j]).css("display") == "none"){
        compteurMedia++;
      }
    }
    if(compteurMedia == $($('.container_media')[i]).find('.marge').length){
      $('.titre_container_media[titre_associe_container_media='+$($('.container_media')[i]).attr("titre_associe_container_media")+']').css("display","none");
    }
  }
}

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
  $('#container_categories').on("wheel", function(evt){
    if(evt.originalEvent.wheelDeltaX == 0){
      evt.preventDefault();
      if(evt.originalEvent.wheelDelta <= 0){
        $('#container_categories').scrollLeft($('#container_categories').scrollLeft()+15);
      }
      else{
        $('#container_categories').scrollLeft($('#container_categories').scrollLeft()-15);
      }
    }
  });
  $('label[for=text_scearch_bar]').on("click",tagQuery);
  $('#text_scearch_bar').on("keypress",function(e){
    if(e.which == 13) {
      tagQuery();
    }
  });
  $('#text_scearch_bar').on("keydown",function(e){
    if($('#text_scearch_bar').val() == '') {
      tagQuery();
    }
  });
  $('.fermer_ajouter_tags').on("click",function(){
    $('.ajouter_tags').css("transform","translateX(-100vw)");
  });
  $('.fermer_supprimer_tags').on("click",function(){
    $('.supprimer_tags').css("transform","translateX(-100vw)");
  });
  $('#importer_file').on("change",function(){
    $('#form_import').submit();
  });
  $('.fermer_informations').on("click",function(){
    $(this).parent().parent().css("transform","translateX(-130%)");
  });
  $('.img_media').on("click",img_media_open);
  $('.player').on("click",player_open);
  $('.nom_categorie').on("click",function(){
    if($(this).hasClass('cat_entered')){
      $('.nom_categorie:not([id_cat='+$(this).attr("id_cat")+'])').css("display","inline");
      $('.tag_de_cat_'+$(this).attr("id_cat")).css("display","none");
      if(!($('.tag_de_cat_'+$(this).attr("id_cat")).hasClass('tag_clicked'))){
        $(this).removeClass('cat_clicked');
      }
    }
    else{
      $('.nom_categorie:not([id_cat='+$(this).attr("id_cat")+'])').css("display","none");
      $('.tag_de_cat_'+$(this).attr("id_cat")).css("display","inline");
      $(this).addClass('cat_clicked');
    }
    $(this).toggleClass('cat_entered');
  });
  $('.nom_tag').on("click",function(){
    $(this).toggleClass('tag_clicked');
    selectionDesTags();
  });

  $('#checked_croissant').on("click",function(){
    if($('#checked_croissant').is(':checked')){
      $('#checked_croissant+label').text('Croissant');
    }
    else{
      $('#checked_croissant+label').text('Décroissant');
    }
    for (var i = 0; i < $('.container_media').length; i++) {
      $($('.container_media')[i]).insertAfter($('#trier_par'));
      $($('.titre_container_media')[i]).insertAfter($('#trier_par'));
    }
  });
  $('#radio_dates').on("click",trier_par_dates);
  $('#radio_auteurs').on("click",trier_par_auteurs);
  $('#radio_mes_photos').on("click",trier_par_mesPhotos);
if(sessionStorage.getItem('role')=='Admin'){
  $.contextMenu({
    selector: '.img_media, .player',
    zIndex: 50,
    items: {
      informations: {
        name: "Informations",
        callback: function(itemKey, opt){
          $('.container_informations').css("transform","translateX(-130%)");
          $('[id_media=container_inf_'+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0px)");
        }
      },
      addTags: {
        name: "Ajouter des tags",
        callback: function(itemKey, opt){
          $('.ajouter_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
      },
      delTags: {
        name: "Supprimer des tags",
        callback: function(itemKey, opt){
          $('.supprimer_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
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
}
else if(sessionStorage.getItem('role')=='Lecture'){
  $.contextMenu({
    selector: '.img_media, .player',
    zIndex: 50,
    items: {
      informations: {
        name: "Informations",
        callback: function(itemKey, opt){
          $('.container_informations').css("transform","translateX(-130%)");
          $('[id_media=container_inf_'+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0px)");
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
}

else if(sessionStorage.getItem('role')=='Ecriture'){
  $.contextMenu({
    selector: '.img_media, .player',
    zIndex: 50,
    items: {
      informations: {
        name: "Informations",
        callback: function(itemKey, opt){
          $('.container_informations').css("transform","translateX(-130%)");
          $('[id_media=container_inf_'+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0px)");
        }
      },
      addTags: {
        name: "Ajouter des tags",
        callback: function(itemKey, opt){
          $('.ajouter_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
      },
      delTags: {
        name: "Supprimer des tags",
        callback: function(itemKey, opt){
          $('.supprimer_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
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
}
else if(sessionStorage.getItem('role')=='Invité'){
  $.contextMenu({
    selector: '.img_media, .player',
    zIndex: 50,
    items: {
      informations: {
        name: "Informations",
        callback: function(itemKey, opt){
          $('.container_informations').css("transform","translateX(-130%)");
          $('[id_media=container_inf_'+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0px)");
        }
      },
      addTags: {
        name: "Ajouter des tags",
        callback: function(itemKey, opt){
          $('.ajouter_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
      },
      delTags: {
        name: "Supprimer des tags",
        callback: function(itemKey, opt){
          $('.supprimer_tags[id_fichier='+opt.$trigger.parent().attr("id_media")+']').css("transform","translateX(0)");
          $('input[name=id_fichier]').val(opt.$trigger.parent().attr("id_media"));
        }
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
}

});
