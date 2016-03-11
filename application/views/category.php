<div class="row">
 <div class="col-md-24">
      <h5>
         <ol class="breadcrumb">
         <li><a href="<?php echo site_url('home/category/')?>"><?php echo $this->lang->line('Root');?></a></li>
         <?php 
          
            if( !empty(CI_Controller::$breadcrumb['parents']) ) 
            { 
               foreach(CI_Controller::$breadcrumb['parents'] as &$i)
               {
                  echo '<li><a href="'.site_url('home/category/'.CI_Controller::$breadcrumb['current']['category_table'].'/'.$i['category_id']).'">'.$i['name'].'</a></li>';
               }
            }   
            if( !empty(CI_Controller::$breadcrumb['current']))
            {
               if( !isset(CI_Controller::$data['category_item']) ) echo '<li class="active">'.CI_Controller::$breadcrumb['current']['name'].'</li>';
               else echo '<li class="active"><a href="'.site_url('home/category/'.CI_Controller::$breadcrumb['current']['category_table'].'/'.CI_Controller::$breadcrumb['current']['category_id']).'">'.CI_Controller::$breadcrumb['current']['name'].'</a></li>';
            }
//echo '<li>&nbsp;'.CI_Controller::$last_q.'</li>';
         ?>
          </ol>
       </h5>
   </div>
</div> 

<div class="row">  
   <?php if( !isset(CI_Controller::$data['category_item']) ) {?>
   <div class="col-md-12 col-lg-12">
   <?php if(isset(CI_Controller::$data['categories'][0])) {?>
      <!-- Advanced Tables -->
      <div class="panel panel-default">
         <div class="panel-heading"><h4>Parent categories</h4></div>
         <div class="panel-body">
             <div class="table-responsive">
                 <table class="table table-bordered table-hover" id="dataTables-example">
                     <thead>
                         <tr>
                           <th>Logo</th>
                             <th width="60%">Name</th>
                             <th>Amount</th>
                         </tr>
                     </thead>
                     <tbody>
                     <?php 
                     foreach(CI_Controller::$data['categories'] as $i) {
                        if(($i['category_id'] == CI_Controller::$data['category_id'] || $i['level'] == CI_Controller::$breadcrumb['current']['level'] || CI_Controller::$data['category_id']==0)){
                        ?>
                        <tr <?php echo $i['category_id'] == CI_Controller::$data['category_id'] ? 'class="active-menu"':'';?>>
                           <td><a href="<?php echo site_url("home/category/{$i['category_table']}/{$i['category_id']}/description"); ?>"><img title="Go to Description" src="upload/logo/<?php echo $i['logo'] != '' ? $i['logo'] : 'noimg.jpg'; ?>" width="40" height="40"/></a></td>
                           <td>
                              <?php echo $i['level']>1 ? str_repeat('&nbsp;', 4*$i['level']-4).'<i class="fa fa-arrow-right fa-1x">':''; ?>&nbsp;
                              <a href="<?php echo site_url("home/category/{$i['category_table']}/{$i['category_id']}"); ?>">
                              <b style="font-size: 18px;"><?php echo $i['name'] ?></b></a>                          
                           </td>
                           <td><a href="<?php echo site_url('home/catalog/'.$i['category_id']); ?>" title="<?php echo $i['items_count'] ?> products in this category"><?php echo $i['items_count'] ?></a></td>  
                        </tr>
                      <?php } } ?> 
                      
                     </tbody>
                 </table>
             </div>
             
         </div>
      </div>
   <?php } else { echo '<h4>No results!</h4>';} ?>
   </div>

<div class="col-md-12 col-lg-12">
<?php if(isset(CI_Controller::$data['categories'][0]) && CI_Controller::$data['category_id'] > 0)
      {
         if( count(CI_Controller::$data['categories']) > 1 ) {?>
   <!-- Advanced Tables -->
   <div class="panel panel-default">
      <div class="panel-heading"><h4>Children categories</h4></div>
      <div class="panel-body">
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                      <tr>
                        <th>Logo</th>
                          <th width="60%">Name</th>
                          <th>Amount</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php foreach(CI_Controller::$data['categories'] as $i) {
                     if($i['parent'] == CI_Controller::$data['category_id']){
                     ?>                  
                  
                   <tr class="odd gradeX">
                       <td><a href="<?php echo site_url("home/category/{$i['category_table']}/{$i['category_id']}/description"); ?>"><img title="Go to Description" src="upload/logo/<?php echo $i['logo'] != '' ? $i['logo'] : 'noimg.jpg'; ?>" width="40" height="40"/></a></td>
                       <td>
                        <?php echo $i['level']>1 ? str_repeat('&nbsp;', 4*$i['level']-4).'<i class="fa fa-arrow-right fa-1x">':''; ?>&nbsp;
                        <a href="<?php echo site_url("home/category/{$i['category_table']}/{$i['category_id']}"); ?>">
                        <b style="font-size: 18px;"><?php echo $i['name'] ?></b></a>
                       
                       </td>
                       <td>
                        <a href="<?php echo site_url("home/catalog/{$i['category_table']}/{$i['category_id']}"); ?>" title="<?php echo $i['items_count'] ?> products in this category"><?php echo $i['items_count'] ?></a>
                       </td>  
                   </tr>
                   <?php }} ?> 
                   
                  </tbody>
              </table>
          </div>
          
      </div>
   </div>
<?php } else { echo '<div class="panel panel-default">
      <div class="panel-heading"><h4>Children categories</h4></div>
      <div class="panel-body"><h4>No children categories!</h4></div></div>';} 
      }
      ?>
</div>
<?php }else if(!empty(CI_Controller::$data['category_item']))
         { echo '<div class="col-md-12 col-lg-12">
         <div class="panel panel-default">
         <div class="panel-heading"><h4>Category description</h4></div>
         <div class="panel-body">'.CI_Controller::$data['category_item']['description'].'</div></div></div>';}
?>
      
      
      
   </div>


  
         
         <div class="row">
 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    <ul class="pager">
      <li><a href="javascript:history.back(1)">&larr;&mdash;</a></li>
      <li><a href="javascript:history.forward(1)">&mdash;&rarr;</a></li>
    </ul>
    
 </div>
</div> 
