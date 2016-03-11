<?php if(!empty(CI_Controller::$data['categories'])){?> 
<div class="row">
   <div class="col-md-24 col-lg-24">
      <table border="1" style="background-color:white;" class="table-responsive table table-striped table-bordered table-hover">
      <?php
      if ( !function_exists('is_child'))
      {
      function is_child($id){
         foreach(CI_Controller::$data['categories'] as $i) {
            if($i['parent'] == $id) return true;
         }
         return false;
      }}

      function ch($id){  
         foreach (CI_Controller::$data['categories'] as $v) {
            if($v['parent'] == $id){
               echo '<li><a href="'.site_url('home/catalog/'.$v['category_id']).'">'.$v['name'].'</a></li>';
               if(is_child($v['category_id'])){
                  echo '<ul>'; 
                  ch($v['category_id']);
               }
            }
         }
         echo '</ul>';
      }
      $c=0;
      echo '<tr>';
      foreach(CI_Controller::$data['categories'] as $i){
      if( $c % 6 == 0 ) {echo '</tr><tr>';}
      if($i['parent']==0){  
      $c++;
   ?>
      <td valign="top" >
         <img width="100" height="100" src="upload/logo/<?php echo $i['logo'] == '' ? 'noimg.jpg' : $i['logo'] ; ?>">
         <a href="<?php echo site_url('home/catalog/'.$i['category_id']); ?>"><h4><?php echo $i['name']; ?> </h4></a>
         <ul style="padding:0px;list-style-type: none;">
         <?php 
            foreach (CI_Controller::$data['categories'] as $s) {
               if($s['parent'] == $i['category_id']){
                  echo '<li><a href="'.site_url('home/catalog/'.$s['category_id']).'">'.$s['name'].'</a></li>';
                  if(is_child($s['category_id'])){
                     echo '<ul>';
                     ch($s['category_id']);
                  }
               }
            }
            echo '</ul>';
         ?> 
      </td>
   
   <?php 
      } 
   }
   echo '</tr>';
  ?> 
</table>
</div>
</div>
<?php } ?> 