//***** Parameters
var temp_sub = $('.parameter_sub').html();
var temp_parameter = $('.parameter').html();
function parameter_add(){
   //var temp_parameter = $('.parameter').html();
   if($('.parameter').is(':hidden'))$('.parameter').show();
   else $('#par_panel').append('<div class="panel-body parameter">'+temp_parameter+'</div>');
   numeration();
   //temp_sub = $('.parameter_sub').html();
}

function parameter_sub_add(obj){
   //var temp_sub = $('.parameter_sub').html();
   $(obj).parents('.parameter_values').append('<div class="parameter_sub">'+temp_sub+'</div>');
   numeration();
}

function parameter_del(obj){
   $(obj).parent().remove();
   numeration();
}

function numeration(){
   $(".parameter_name").each(function(index){
      $(this).attr('name','parameter_key['+index+']');
      $(this).parent().next('div').find('.parameter_item').each(function(i){
         $(this).attr('name','parameter_value['+index+'][]');
      });
   });
}
//******************** End Parameters
function category_params(categoryId){
  if(categoryId == undefined) var categoryId = '0';
   $.ajax({
      beforeSend: function(){$("#loader_params").show();}, 
      url: "index.php/adm/product/category_params/" + categoryId,
      dataType: "html"
   }).done(function( msg ) {
      $("#loader_params").hide();
      $("#params").html(msg);  
   }).fail(function() { $("#params").html('<h1>Ошибка сервера</h1>'); }); 
}

function checkname(){
   var str=document.getElementById('first_name').value;
   var filter=/^[А-ЯA-Z]{2,}( +)?([А-ЯA-Z]{2,})?( +)?$/i;
   if (filter.test(str)) {document.getElementById('name_div').style.visibility="hidden"; document.getElementById('name_pic').style.visibility="visible";} else {document.getElementById('name_pic').style.visibility="hidden"; document.getElementById('name_div').style.visibility="visible";}}
function checksurname(){
   var str=document.getElementById('last_name').value;
   var filter=/^[А-ЯA-Z]{2,}( +)?([А-ЯA-Z]{2,})?( +)?$/i;
   if (filter.test(str)) {document.getElementById('surname_div').style.visibility="hidden"; document.getElementById('surname_pic').style.visibility="visible";} else {document.getElementById('surname_pic').style.visibility="hidden"; document.getElementById('surname_div').style.visibility="visible";}}
function checkmail(){
   var str=document.getElementById('email').value;
   var filter=/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i;
   if (filter.test(str)) {document.getElementById('mail_div').style.visibility="hidden"; document.getElementById('mail_pic').style.visibility="visible";} else {document.getElementById('mail_pic').style.visibility="hidden"; document.getElementById('mail_div').style.visibility="visible";}}
function checkphone(){
   var str=document.getElementById('phone').value;
   var filter=/^(?:8|\+7)? ?\(\d{1,5}\)? ?\d{1,5}\-\d{2}\-\d{2}$/;
   if (str != "") {document.getElementById('phone_div').style.visibility="hidden"; document.getElementById('phone_pic').style.visibility="visible";} else {document.getElementById('phone_pic').style.visibility="hidden"; document.getElementById('phone_div').style.visibility="visible";}}

function open_window(link,w,h){
  var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
  newWin = window.open(link,'newWin',win);
  newWin.focus();
}

function confirmDelete(){
  temp = window.confirm('');
  if (temp){
      window.location="index.php?killuser=yes";
  }
}

function validate_custinfo(){
   var strFName=document.getElementById('first_name').value;
   var filterFName=/^[А-ЯA-Z]{2,}( +)?([А-ЯA-Z]{2,})?( +)?$/i;
   if (!filterFName.test(strFName)){
      alert("Пожалуйста, введите Ваши ФИО");
      return false;
   }
   var strSName=document.getElementById('last_name').value;
   var filterSName=/^[А-ЯA-Z]{2,}( +)?([А-ЯA-Z]{2,})?( +)?$/i;
   if (!filterSName.test(strSName)) {
      alert("Пожалуйста, введите Ваши ФИО");
      return false;
   }
   var strEmail=document.getElementById('email').value;
   var filterEmail=/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i;
   if (!filterEmail.test(strEmail)) {
      alert("Пожалуйста, введите email");
      return false;
   }
   var strPhone=document.getElementById('phone').value;
   var filterPhone=/^(?:8|\+7)? ?\(\d{1,5}\)? ?\d{1,5}\-\d{2}\-\d{2}$/;
   if (str ="" ){
      alert("Пожалуйста, введите номер телефона");
      return false;
   }
   return true;
}