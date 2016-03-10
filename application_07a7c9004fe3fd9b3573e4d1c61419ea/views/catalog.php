<div class="row">
<div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
   <h5>
      <ol class="breadcrumb">
         <li><a href="<?php echo site_url('home/catalog')?>"><?php echo $this->lang->line('Adverts'); ?></a></li>
         <?php 
          
            if( !empty(CI_Controller::$breadcrumb['parents']) ) 
            { 
               foreach(CI_Controller::$breadcrumb['parents'] as &$i)
               {
                  echo '<li><a href="'.site_url('home/catalog/'.$i['category_id']).'">'.$i['name'].'</a></li>';
               }
            }   
            if( !empty(CI_Controller::$breadcrumb['current']))
            {
               echo '<li class="active">'.CI_Controller::$breadcrumb['current']['name'].'</li>';
               //else echo '<li class="active">'.CI_Controller::$breadcrumb['current']['name'].'</li>';
            }
            //echo '<li>&nbsp;'.CI_Controller::$last_q.'</li>';
         ?>
         
      </ol>
   </h5>
</div>
</div>
 
<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
     <?php if(!empty(CI_Controller::$data['advert'])){
      foreach(CI_Controller::$data['advert'] as $i){?>
     
      <div class="panel panel-default" style="margin:2px;">
        
         <div class="panel-body">
            <a href="<?php echo site_url("home/advert/{$i['advert_id']}"); ?>">
               <div style="word-break: break-all;margin: 5px;padding: 5px;float:left;">
                  <img src="upload/img/<?php echo $i['logo']=='' ? 'noimg.jpg' : $i['logo']; ?>" width="100" height="100" />
               </div>
            
               <div style="word-break: break-all;margin: 5px;">
                  <b><?php echo mb_substr($i['title'],0,50); ?> </b>
               </div>
            </a>
            <div style="word-break: break-all;margin: 5px;padding: 5px;">
               <?php echo mb_substr($i['text'],0,200); ?> 
            </div>
            
            <div style="word-break: break-all;margin: 5px;">
               <b><?php echo $this->lang->line('Price');?>:&nbsp;</b>
               <?php echo $i['price']; ?> 
            </div>
            
            <div style="word-break: break-all;margin: 5px;">
               <b><?php echo $this->lang->line('Contacts');?>:&nbsp;</b>
               <?php echo mb_substr($i['contacts'],0,100); ?> 
               &nbsp;<p><?php echo $i['updated'];?></p>
            </div>
            
         </div>
      </div>
      
    <?php } }else{ ?>
<div class="alert alert-danger" role="alert"><h2 class="words">No results!<h2></div>
<?php } ?>  
      
      <?php $this->load->view('paging'); ?>
   </div>
</div>
<script>
if($('#sub_<?php echo CI_Controller::$data['advert'][0]['category_id'] ?>').length > 0) $('#sub_<?php echo CI_Controller::$data['advert'][0]['category_id'] ?>').toggle(500);

</script>
