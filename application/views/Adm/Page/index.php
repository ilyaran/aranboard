<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Pages');?>
         &nbsp;&nbsp;<a class="btn btn-info" href="<?php echo site_url('adm/page/add'); ?>"><?php echo $this->lang->line('Add page'); ?></a>
         </div>
         <div id="cabinet_panel" class="panel-body">
             <?php if(isset(CI_Controller::$data['page'][0])) { ?>
             <div class="table-responsive">
                 <table class="table table-striped table-bordered table-hover">
                     <thead>
                         <tr>
                             <th style="width: 5%;"><?php echo $this->lang->line('Page Id');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Sort Index');?></th>
                             <th style="width: 15%;">Url</th>
                             <th><?php echo $this->lang->line('Title');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Display');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Date');?></th>
                             <th style="width: 5%;"></th>
                         </tr>
                     </thead>
                     <tbody>
                     <?php foreach(CI_Controller::$data['page'] as $i) { ?>
                         <tr>
                             <td><a href="<?php echo site_url('home/statics/'.$i['page_id']); ?>"><?php echo $i['page_id']; ?></a></td>
                             <td><?php echo $i['sort']; ?></td>
                             <td><a href="<?php echo $i['url']; ?>"><?php echo $i['url']; ?></a></td>
                             
                             <td><a href="<?php echo site_url("home/statics/{$i['page_id']}"); ?>"><?php echo $i['title']; ?></a></td>
                             <td><input name="status" type="checkbox" value="1" <?php echo $i['display']==1 ? 'checked="checked"' : ''; ?> /></td>
                             <td><?php echo $i['page_time']; ?></td>
                             <td>
                              <a href="<?php echo site_url("adm/page/edit/{$i['page_id']}"); ?>"><i class="fa fa-edit fa-fw"></i></a>
                              <a href="<?php echo site_url("adm/page/del/{$i['page_id']}"); ?>"><i class="fa fa-times"></i></a>
                             </td>
                         </tr>
                      <?php } ?>
                     </tbody>
                 </table>
             </div>
            <?php }else{ ?>
            <h3><?php echo $this->lang->line('No pages');?></h3>
            <?php } ?>  
         </div>
     </div>
     <?php $this->load->view('paging'); ?>
     
   </div>
</div>

