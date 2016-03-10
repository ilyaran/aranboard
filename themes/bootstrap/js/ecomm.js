/**
   $('.lid').on('click',function(){
      $(this).children('.uld').toggle(500);
   });
*/

function filter_data(){
   var search_params = ""; 
   var n, v;
   $("input[type='checkbox']:checked").each(function(index){
      n =  $(this).parent('.panel-body').prev('.panel-heading').children('.filterName').text();
      v = $(this).next('span').text();
      
      if( (search_params.indexOf(n)+1) ) search_params += '&' + v;
      else search_params += '?' + n + '&' + v;         
   });        
   search_params = search_params.substr(1);
   return search_params;
}

function catalog_list(page){ 
   if(page == undefined) page=0;
   var sort = $("#sort").val();
   var cat = $("#category_options option:selected").val();
   var search = $("#search").val();
   var price_min = $("#search-price-less").val();
   var price_max = $("#search-price-more").val();
   var per_page = $("#per_page").val();
   var filter = '';
   if($("#filter").text().replace(" ","") != '') var filter = filter_data();
   $.ajax({
     beforeSend: function(){$("#loader_home").show();$("#content").hide(200);}, 
     type: "POST",
     url: "index.php/home/ajax_catalog/"+page,
     data: {'search':search,'category_id':cat ,'sort':sort,'price_min':price_min,'price_max':price_max,'filter':filter,'per_page':per_page},
     dataType: "html"
   }).done(function( msg ) {
   $("#loader_home").hide();
   $("#content").show(200);
   $("#content").html(msg);  
   }).fail(function() { $("#content").html('<h1>Ошибка сервера</h1>'); });         
}

function comments_list(pg){ 
   if(pg == undefined) page=0;
   var id = $("#id").val().toString();
   $.ajax({
      beforeSend: function(){$("#loader_comm").show();}, 
      type: "POST",
      url: "index.php/home/comment_list/"+id+'/'+page,
      dataType: "html"
   }).done(function( msg ) {
      $("#loader_comm").hide();
      $("#comment_list").html(msg); 
   }).fail(function() { $("#comment_list").html('<h1>Ошибка сервера</h1>'); });         
}

function add_comment(){ 
   var author = $("#comment_author").val();
   var text = $("#comment_text").val();
   var email = $("#comment_email").val();
   var id = $("#id").val().toString();
   var captcha = $("#recaptcha_response_field").val();
   $.ajax({
      beforeSend: function(){$("#loader_comm").show();}, 
      type: "POST",
      url: "index.php/Home/comment_add/"+id,
      data: {'comment_author':author,'comment_text':text ,'comment_email':email,'recaptcha_response_field':captcha,'recaptcha_challenge_field':captcha},
      dataType: "html"
   }).done(function( msg ) {
      $("#loader_comm").hide();
      if(msg.substr(0,19)=='<div class="error">'){
         $("#error_comment_add").html(msg);
      }else{
         $("#comment_list").html(msg);
         $("#error_comment_add").html('');
      }   
   }).fail(function(){$("#comment_list").html('<h1>Ошибка сервера</h1>');});
}

function add_to_cart(id){
   var q=$("#number_"+id).val();
   if(q <= 0) q = 1;
   $.ajax({
      beforeSend:function(){$("#loader_"+id).show();}, 
      type: "POST",
      url: "index.php/home/cart_set/"+id,
      data: {'number':q},
      dataType: "json"
   }).done(function( msg ) {
      $("#loader_"+id).hide();
      $("#cart_num").html(msg['total_items']);
      $("#cart_sum").html(msg['total']);
   }).fail(function() { $("#loader_"+id).show().html('Ошибка сервера'); });         
}

function show_tabs(tab){
   var tabs = ['description','pictures','comments','brand'];
   var nav = {};
   var id_tab = $(tab).attr('id').substr(4);
   for (i in tabs){
      nav = $("#nav_"+tabs[i]);
      if( nav.length>0 ) {
         if( id_tab != tabs[i] ) {  
            if(nav.hasClass('disabled')) nav.removeClass('disabled');
            if($("#"+tabs[i]))$("#"+tabs[i]).hide();
         }else{
            if(!nav.hasClass('disabled'))nav.addClass('disabled');
            if($("#"+tabs[i]))$("#"+tabs[i]).show();
         }
      }
   }
}