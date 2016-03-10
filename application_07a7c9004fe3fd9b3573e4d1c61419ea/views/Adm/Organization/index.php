<div class="row">
   <?php $this->load->view('Adm/Widgets/breadcrumb'); ?>
</div>

<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading"><?php echo $this->lang->line('Organizations');?>
         &nbsp;&nbsp;<a class="btn btn-info" href="<?php echo site_url('adm/organization/add'); ?>"><?php echo $this->lang->line('Add organization'); ?></a>
         </div>
         <div id="cabinet_panel" class="panel-body">
             <?php if(isset(CI_Controller::$data['organization'][0])) { ?>
             <div class="table-responsive">
                 <table class="table table-striped table-bordered table-hover">
                     <thead>
                         <tr>
                             <th style="width: 5%;"><?php echo $this->lang->line('Logo');?></th>
                             <th><?php echo $this->lang->line('Title');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Moder');?>&nbsp;<input type="checkbox" onchange="" /></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Date');?></th>
                             <th style="width: 5%;"></th>
                         </tr>
                     </thead>
                     <tbody>
                     <?php foreach(CI_Controller::$data['organization'] as $i) { ?>
                         <tr>
                             <td><img src="upload/img/<?php echo $i['logo'] == null ? 'noimg.jpg' : $i['logo']; ?>" width="50" height="50"></td>
                             <td><a href="<?php echo site_url("home/organization/{$i['advert_id']}"); ?>"><?php echo $i['title']; ?></a></td>
                             <td><input name="status" type="checkbox" value="1" <?php echo $i['status']==1 ? 'checked="checked"' : ''; ?> /></td>
                             <td><?php echo $i['updated']; ?></td>
                             
                             <td>
                              
                              <a href="<?php echo site_url("adm/organization/edit/{$i['organization_id']}"); ?>"><i class="fa fa-edit fa-fw"></i></a>
                              <a href="<?php echo site_url("adm/organization/del/{$i['organization_id']}"); ?>"><i class="fa fa-times"></i></a>
                              
                             </td>
                         </tr>
                         
                      <?php } ?>   

                     </tbody>
                 </table>
             </div>
            <?php }else{ ?>
            <h3><?php echo $this->lang->line('No organizations');?></h3>
            <?php } ?>  
         </div>
     </div>
     <?php $this->load->view('paging'); ?>
     
   </div>
</div>

<script>
var index_page = '<?php echo $this->config->item('index_page');?>'; 
var page = 0;

function catalog_list(page){ 
   var postData = {};
   
   if($("#search").length > 0) postData.search = $("#search").val();
   if($("#sort").length > 0) postData.sort = $("#sort").val();
   if($("#category_options").length > 0) postData.category_id = $("#category_options option:selected").val(); 
   if($("#per_page").length > 0) postData.per_page = $("#per_page").val();
   
   $.ajax({
     beforeSend: function(){$("#loader").show();}, 
     type: "POST",
     url: index_page + "/adm/organization/ajax_catalog/" + page,
     data: postData,
     dataType: "html"
   }).done(function( msg ) {
      $("#loader").hide();
      $("#content").html(msg);
   }).fail(function() { $("#content").html('<h1>Server Error!</h1>'); });         
}


</script>