$(document).ready(function(){
  $('.cat').on("click",function(){
    $('.container_tags_par_cat').css("display","none");
    $('.container_tags_par_cat[id_cat='+$(this).attr("id_cat")+']').css("display","flex");
  });
  $('.pen_modifier_cat').on("click",function(){
    $('#modifiercat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('#input_modif_cat').attr("placeholder","Modifier: "+$(this).parent().find("label").text());
    $('.id_cat_clicked').val($(this).parent().find("label").attr("id_cat"));
    $('*:not(#mask_tag,html,body, #modifiercat,#modifiercat *)').css("filter","blur(2px)");
  });
  $('.tag').on("click",function(){
    $('.id_tag_clicked').val($(this).attr("id_tag"));
    $('#modifiertag').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('#input_modif_tag').attr("placeholder","Modifier: "+$(this).text());
    $('*:not(#mask_tag,html,body, #modifiertag,#modifiertag *)').css("filter","blur(2px)");
  });
  $('.delete_cat').on("click",function(){
    $('#suppcat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('.id_cat_clicked').val($(this).parent().find("label").attr("id_cat"));
    $('*:not(#mask_tag,html,body, #suppcat,#suppcat *)').css("filter","blur(2px)");
  });
  $('.delete_tag').on("click",function(){
    $('#supptag').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('.id_tag_clicked').val($(this).parent().find("div").attr("id_tag"));
    $('*:not(#mask_tag,html,body, #supptag,#supptag *)').css("filter","blur(2px)");
  });
  $('#plus_cat').on("click",function(){
    $('#ajoutcat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('*:not(#mask_tag,html,body, #ajoutcat,#ajoutcat *)').css("filter","blur(2px)");
  });
  $('#mask_tag').on("click",function(){
    $('#ajoutcat').css("transform","translate(-100vw,-50%)");
    $('#supptag').css("transform","translate(-100vw,-50%)");
    $('#modifiercat').css("transform","translate(-100vw,-50%)");
    $('#mask_tag').css("transform","translateX(-100vw)");
    $('#ajouttag').css("transform","translate(-100vw,-50%)");
    $('#suppcat').css("transform","translate(-100vw,-50%)");
    $('#modifiertag').css("transform","translate(-100vw,-50%)");
    $('*:not(html,body)').css("filter","blur(0)");
  });
  $('#plus_tag').on("click",function(){
    if($('input[name="radio_cat"]:checked+label').attr("id_cat")){
      $('.id_cat_clicked').val($('input[name="radio_cat"]:checked+label').attr("id_cat"));
      $('#ajouttag').css("transform","translate(0,-50%)");
      $('#mask_tag').css("transform","translateX(0)");
      $('*:not(#mask_tag,html,body, #ajouttag,#ajouttag *)').css("filter","blur(2px)");
    }
    else{
      alert("Veuillez d'abord sélectionner une catégorie");
    }
  });
});
