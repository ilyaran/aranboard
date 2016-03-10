<div class="row">
<div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
   <h5>
      <ol class="breadcrumb">
         <li><a href="<?php echo site_url('adm/advert/index/advert')?>"><?php echo $this->lang->line("Adverts");?></a></li>
         <?php 
          
            if( !empty(CI_Controller::$breadcrumb['parents']) ) 
            { 
               foreach(CI_Controller::$breadcrumb['parents'] as &$i)
               {
                  echo '<li><a href="'.site_url('adm/advert/index/advert/'.$i['category_id']).'">'.$i['name'].'</a></li>';
               }
            }   
            if( !empty(CI_Controller::$breadcrumb['current']))
            {
               echo '<li class="active"><a href="'.site_url('adm/advert/index/advert/'.CI_Controller::$breadcrumb['current']['category_id']).'">'.CI_Controller::$breadcrumb['current']['name'].'</a></li>';
            }
            //echo '<li>&nbsp;'.CI_Controller::$last_q.'</li>';
         ?>
      </ol>             
   </h5> 
</div>
</div>

<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading"><?php echo $this->lang->line("Adverts");?>
         &nbsp;&nbsp;<a class="btn btn-info" href="<?php echo site_url("adm/advert/add"); ?>"><?php echo $this->lang->line("Add advert"); ?></a>
         <input type="submit" form = "in_list" style="float: right;" />
         </div>
         <div id="cabinet_panel" class="panel-body">
             <?php if(isset(CI_Controller::$data['advert'][0])) { ?>
             <div class="table-responsive">
                 <form action="<?php echo site_url("adm/advert/in_list/advert");?>" method="post" id="in_list" name="in_list">
                 <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th style="width: 5%;"><?php echo $this->lang->line('Logo');?></th>
                           <th><?php echo $this->lang->line('Title');?></th>
                           <th style="width: 5%;">
                              <select onchange="check_status(this.value)">
                                 <option value="0" ><?php echo $this->lang->line('Nonchecked'); ?></option>
                                 <option value="1" ><?php echo $this->lang->line('Checked'); ?></option>
                                 <option value="2" ><?php echo $this->lang->line('Doubtful'); ?></option>
                                 <option value="3" ><?php echo $this->lang->line('Bad'); ?></option>
                              </select>
                              <?php echo $this->lang->line('Status');?>
                           </th>
                           <th style="width: 5%;"><?php echo $this->lang->line('Date');?></th>
                           
                           <th style="width: 5%;"><?php echo $this->lang->line('Price');?></th>
                           
                           <th style="width: 5%;">
                              <input value="0" type="checkbox" onchange="check_del(this)" />&nbsp;
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach(CI_Controller::$data['advert'] as $i) { ?>
                        <tr>
                           <td><img src="upload/img/<?php echo $i['logo'] == null ? 'noimg.jpg' : $i['logo']; ?>" width="50" height="50"></td>
                           <td><a href="<?php echo site_url("home/advert/{$i['advert_id']}"); ?>"><?php echo $i['title']; ?></a></td>
                           <td>
                              <input type="hidden" value="-1" name="status[<?php echo $i['advert_id']; ?>]" />
                              <select class="status_item" onchange="$(this).prev('input').val(this.value);"  >
                                 <option value="0" <?php if($i['status'] == 0) echo 'selected'; ?> ><?php echo $this->lang->line('Nonchecked'); ?></option>
                                 <option value="1" <?php if($i['status'] == 1) echo 'selected'; ?> ><?php echo $this->lang->line('Checked'); ?></option>
                                 <option value="2" <?php if($i['status'] == 2) echo 'selected'; ?> ><?php echo $this->lang->line('Doubtful'); ?></option>
                                 <option value="3" <?php if($i['status'] == 3) echo 'selected'; ?> ><?php echo $this->lang->line('Bad'); ?></option>
                              </select>
                           </td>
                           
                           <td><?php echo $i['updated']; ?></td>
                           
                           <td><?php echo $i['price']; ?></td>
                           
                           <td>
                           
                           <a href="<?php echo site_url("adm/advert/edit/{$i['advert_id']}/advert"); ?>"><i class="fa fa-edit fa-fw"></i></a>
                           <a href="<?php echo site_url("adm/advert/del/advert/{$i['advert_id']}"); ?>"><i class="fa fa-times"></i></a>
                           
                           <input class="del_item" name="del[]" value="<?php echo $i['advert_id']; ?>" title="<?php echo $this->lang->line('Check for delete this item');?>" type="checkbox" value="1" />
                           </td>
                        </tr>
                         
                      <?php } ?>   

                     </tbody>
                 </table>
                 <input type="submit" form = "in_list" style="float: right;" />
                 </form>
             </div>
            <?php }else{ ?>
            <h3><?php echo $this->lang->line("No adverts");?></h3>
            <?php } ?>  
         </div>
     </div>
     <?php $this->load->view('paging'); ?>
     
   </div>
</div>
