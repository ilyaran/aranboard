
<div class="row">
   <div class="col-md-24">
      
      <?php $this->load->view("Cabinet/menu") ?>
   
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php echo $this->lang->line('My adverts');?>
            &nbsp;&nbsp;<a class="btn btn-info" href="<?php echo site_url('cabinet/add'); ?>"><?php echo $this->lang->line('Add advert'); ?></a>
         </div>
         <div id="cabinet_panel" class="panel-body">
             <?php if(isset(CI_Controller::$data['advert'][0])) { ?>
             <div class="table-responsive">
                 <table class="table table-striped table-bordered table-hover">
                     <thead>
                         <tr>
                             <th style="width: 5%;"><?php echo $this->lang->line('Logo');?></th>
                             <th><?php echo $this->lang->line('Title');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Date');?></th>
                             <th style="width: 5%;"><?php echo $this->lang->line('Price');?></th>
                             <th style="width: 5%;"></th>
                         </tr>
                     </thead>
                     <tbody>
                     <?php foreach(CI_Controller::$data['advert'] as $i) { ?>
                         <tr>
                             <td><img src="upload/img/<?php echo $i['logo'] == null ? 'noimg.jpg' : $i['logo']; ?>" width="50" height="50"/></td>
                             <td><a href="<?php echo site_url("home/advert/{$i['advert_id']}"); ?>"><?php echo $i['title']; ?></a></td>
                             <td><?php echo $i['updated']; ?></td>
                             <td><?php echo $i['price']; ?></td>
                             <td>
                              
                              <a href="<?php echo site_url("cabinet/edit/{$i['advert_id']}"); ?>"><i class="fa fa-edit fa-fw"></i></a>
                              <a href="<?php echo site_url("cabinet/del/{$i['advert_id']}"); ?>"><i class="fa fa-times"></i></a>
                              <i class="fa fa-eye<?php echo $i['enabled']==1 ? '':'-slash'; ?></td>"></i>
                             </td>
                         </tr>
                         
                      <?php } ?>   

                     </tbody>
                 </table>
             </div>
            <?php }else{ ?>
            <h3><?php echo $this->lang->line('You have no adverts');?></h3>
            <?php } ?>  
         </div>
     </div>
     <?php $this->load->view('paging'); ?>
     
   </div>
</div>

