<div class="row">
<div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
   <h5>
      <ol class="breadcrumb">
         <li><a href="<?php echo site_url('home/organizations')?>"><?php echo $this->lang->line('Organizations'); ?></a></li>
         <?php 
          
            if( !empty(CI_Controller::$breadcrumb['parents']) ) 
            { 
               foreach(CI_Controller::$breadcrumb['parents'] as &$i)
               {
                  echo '<li><a href="'.site_url('home/organizations/'.$i['category_id']).'">'.$i['name'].'</a></li>';
               }
            }   
            if( !empty(CI_Controller::$breadcrumb['current']))
            {
               echo '<li class="active"><a href="'.site_url('home/organizations/'.CI_Controller::$breadcrumb['current']['category_id']).'">'.CI_Controller::$breadcrumb['current']['name'].'</a></li>';
            }

         ?>
         
      </ol>
   </h5>
</div>
</div>

<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      <div class="panel panel-default">
         <div class="panel-heading" style="word-break: break-all;">
         <?php echo CI_Controller::$data['organization']['title']; ?>   
         </div>
         <div class="panel-body">
            <div style="word-break: break-all;margin: 5px;border: 1px blue solid;padding: 5px;">
            
            <?php echo CI_Controller::$data['organization']['text']; ?> 
            
            </div>
            
            <div style="word-break: break-all;margin: 5px;">
               <b><?php echo $this->lang->line('Contacts');?>:&nbsp;</b>
               <?php echo CI_Controller::$data['organization']['contacts']; ?> 
            </div>
            <div style="word-break: break-all;margin: 5px;">
               <b><?php echo $this->lang->line('Published');?>:&nbsp;</b>
               <?php echo CI_Controller::$data['organization']['updated'].' : '.CI_Controller::$data['organization']['author']; ?>
            </div>
            <hr />
         
            <?php 
            if(is_array(CI_Controller::$data['img']))
            {
               foreach(CI_Controller::$data['img'] as $i)
               {
                  echo '<div><img src="upload/img/'.$i.'"  style="margin:auto;" class="img-responsive img-raunded" /></div>'; 
               }
            
            }
            
            ?> 
      
         </div>
      </div>
   </div>
</div>

