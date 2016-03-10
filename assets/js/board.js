var index_page = $('#index_page').val(); 

function catalog_list(page){
   if(page == undefined) page = 0;
   var postData = {};
   var category_table = 'advert';
   if($("input[name='category_table']:checked").length > 0){
      category_table = $("input[name='category_table']:checked").val();
   }
   if($("#search").length > 0) postData.search = $("#search").val();
   if($("#price_from").length > 0) postData.price_from = $("#price_from").val();
   if($("#price_to").length > 0) postData.price_to = $("#price_to").val();
   if($("#sort").length > 0) postData.sort = $("#sort").val();
   if($("#category_options").length > 0) postData.category_id = $("#category_options option:selected").val(); 
   if($("#per_page").length > 0) postData.per_page = $("#per_page").val();
   
   $.ajax({
     beforeSend: function(){$("#loader").show();}, 
     type: "POST",
     url: index_page + "/home/ajax_catalog/" + category_table + "/" + page,
     data: postData,
     dataType: "html"
   }).done(function( msg ) {
      $("#loader").hide();
      $("#content").html(msg);  
   }).fail(function() { $("#content").html('<h1>Server Error!</h1>'); });         
}

function send_message(){
   if($("#advert_comment").length > 0){
      postData.message = $("#advert_comment").val();
      if(postData.message.length < 5){alert('At least 5 symbols');return false;}
      $.ajax({
        beforeSend: function(){$("#loader").show();},
        type: "POST",
        url: index_page + "/cabinet/message_add/",
        data: postData,
        dataType: "html"
      }).done(function( msg ) {
         $("#loader").hide();
         alert(msg);  
      }).fail(function() { alert('Server Error!'); });
   } 
}