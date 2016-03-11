<div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
   <h5>
      <ol class="breadcrumb">
         <li><a href="<?php echo site_url('adm/advert/index')?>">Home</a></li>
         <?php 
          
            if( !empty(CI_Controller::$breadcrumb['parents']) ) 
            { 
               foreach(CI_Controller::$breadcrumb['parents'] as &$i)
               {
                  echo '<li><a href="'.site_url('adm/advert/index/'.$i['category_id']).'">'.$i['name'].'</a></li>';
               }
            }   
            if( !empty(CI_Controller::$breadcrumb['current']))
            {
               echo '<li class="active"><a href="'.site_url('adm/advert/index/'.CI_Controller::$breadcrumb['current']['category_id']).'">'.CI_Controller::$breadcrumb['current']['name'].'</a></li>';
            }
            echo '<li>&nbsp;'.CI_Controller::$last_q.'</li>';
         ?>
      </ol>             
   </h5> 
</div>