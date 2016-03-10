<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24"> 
   
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3><?php echo $this->lang->line('Categories'); ?>&nbsp;"<?php echo CI_Controller::$data['category_table']; ?>"&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="<?php echo site_url("adm/category/add/".CI_Controller::$data['category_table']); ?>"><?php echo $this->lang->line('Add category'); ?></a></h3>
         </div>
         <div id="cabinet_panel" class="panel-body">
            <?php 
            if(isset(CI_Controller::$data['categories'][0])){?>
               <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th style="width: 5%;"><?php echo $this->lang->line('N');?></th>
                        <th style="width: 5%;"><?php echo $this->lang->line('Logo');?></th>
                        <th><?php echo $this->lang->line('Name');?></th>
                        
                        <th style="width: 10%;"></th>
                     </tr>
                  </thead>
                  <tbody>
               <?php 
               function is_child($id){
                  foreach(CI_Controller::$data['categories'] as $i) {
                     if($i['parent'] == $id) return true;
                  }
                  return false;
               }
               
               function getView($i) { ?>
               
               <tr>
                 <td><?php echo $i['sort']; ?></td>
                 <td><img width="50" height="50" src="upload/logo/<?php echo $i['logo'] == '' ? 'noimg.jpg' : $i['logo'] ; ?>"/></td>
                 <td>
                  <?php echo $i['level']>1 ? str_repeat('&nbsp;', $i['level']*6).'<i class="fa fa-long-arrow-right">':''; ?>
                  &nbsp;<?php echo is_child($i['category_id']) ? '<i class="fa fa-level-down fa-1x"></i> '.$i['name']:$i['name']; ?>
                 </td>
                 
                 <td>
                     <a href="<?php echo site_url("adm/category/edit/{$i['category_id']}/".CI_Controller::$data['category_table']); ?>"><i class="fa fa-edit fa-fw"></i></a>
                     <a href="<?php echo site_url("adm/category/del/{$i['category_id']}/".CI_Controller::$data['category_table']); ?>"><i class="fa fa-times"></i></a>
                     <i class="fa fa-eye<?php echo $i['enabled'] == 1 ? '" title="'.('Display in public').'"' : '-slash" title="'.('No display in public').'" '; ?>></i>
                 </td>
               </tr>
                  
               <?php }
               function child($level, $parent) {
                  foreach(CI_Controller::$data['categories'] as $i) 
                  {
                     if($i['level'] > $level) continue;
                     if($i['level'] == $level && $i['parent'] == $parent)
                     {
                        getView($i);
                        child($i['level']+1, $i['category_id']);
                     }
                  }
               }
               foreach(CI_Controller::$data['categories'] as $i) {
                  if($i['level'] > 1) continue;
                  getView($i);
                  child($i['level']+1, $i['category_id']);
               }?>
                     </tbody>
                 </table>
             </div>
            <?php
            }else{ ?>
            <h3><?php echo $this->lang->line('There are no any categories');?></h3>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
