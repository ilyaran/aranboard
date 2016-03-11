<?php if(!empty(CI_Controller::$data['advert'])){?> 
   <div class="panel panel-default" style="">
   
      <div class="panel-body">
      
         <div style="word-break: break-all;float:left;min-height:150px;">
         
            <?php  foreach(CI_Controller::$data['advert'] as $i){?>
            <a style="float: left;border: 1px black solid;" href="<?php echo site_url("home/advert/{$i['advert_id']}"); ?>">
            <img title="<?php echo mb_substr($i['title'],0,50).' : '.mb_substr($i['text'],0,200).' - '.mb_substr($i['contacts'],0,100); ?>" src="upload/img/<?php echo $i['logo']=='' ? 'noimg.jpg' : $i['logo']; ?>" width="150" height="150" class="img-responsive1" />
            </a>
            <?php } ?>  
            
         </div>
      
      </div>
      
   </div>
<?php } ?>  
<?php $this->load->view('Widgets/category/indexpage_category_list'); ?>