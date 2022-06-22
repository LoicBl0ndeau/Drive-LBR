$(document).ready(function(){
  $('.cat').on("click",function(){
    $('.container_tags_par_cat').css("display","none");
    $('.container_tags_par_cat[id_cat='+$(this).attr("id_cat")+']').css("display","flex");
  });



  $('#plus_cat').on("click",function(){
    $('#ajoutcat').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('*:not(#mask_tag,html,body, #ajoutcat,#ajoutcat *)').css("filter","blur(2px)");
  });
  $('#mask_tag').on("click",function(){
    $('#ajoutcat').css("transform","translate(-100vw,-50%)");
    $('#mask_tag').css("transform","translateX(-100vw)");
    $('*:not(#mask_tag,html,body, #ajoutcat,#ajoutcat *)').css("filter","blur(0)");
  });
  $('#plus_tag').on("click",function(){
    $('#ajouttag').css("transform","translate(0,-50%)");
    $('#mask_tag').css("transform","translateX(0)");
    $('*:not(#mask_tag,html,body, #ajouttag,#ajouttag *)').css("filter","blur(2px)");
  });
  $('#mask_tag').on("click",function(){
    $('#ajouttag').css("transform","translate(-100vw,-50%)");
    $('#mask_tag').css("transform","translateX(-100vw)");
    $('*:not(#mask_tag,html,body, #ajouttag,#ajouttag *)').css("filter","blur(0)");
  });
  });
