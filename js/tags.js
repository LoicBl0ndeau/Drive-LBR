$(document).ready(function(){
  $('.cat').on("click",function(){
    $('.container_tags_par_cat').css("display","none");
    $('.container_tags_par_cat[id_cat='+$(this).attr("id_cat")+']').css("display","flex");
  });
  $('.pen_modifier_cat').on("click",function(){
    $('#modifiercat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('#input_modif_cat').attr("placeholder","Modifier: "+$(this).parent().find("label").text());
    $('#id_cat_clicked').val($(this).parent().find("label").attr("id_cat"));
    $('*:not(#mask_tag,html,body, #modifiercat,#modifiercat *)').css("filter","blur(2px)");
  });
  $('#plus_cat').on("click",function(){
    $('#ajoutcat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('*:not(#mask_tag,html,body, #ajoutcat,#ajoutcat *)').css("filter","blur(2px)");
  });
  $('#mask_tag').on("click",function(){
    $('#ajoutcat').css("transform","translate(-100vw,-50%)");
    $('#modifiercat').css("transform","translate(-100vw,-50%)");
    $('#mask_tag').css("transform","translateX(-100vw)");
    $('#ajouttag').css("transform","translate(-100vw,-50%)");
    $('*:not(html,body)').css("filter","blur(0)");
  });
  $('#plus_tag').on("click",function(){
    $('#ajouttag').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('*:not(#mask_tag,html,body, #ajouttag,#ajouttag *)').css("filter","blur(2px)");
  });
});
