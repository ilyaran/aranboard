<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Settings').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Common');?>
         
         </div>
         <div id="cabinet_panel" class="panel-body">
             
             <div class="table-responsive">
             <form method="post"><input type="submit" />
                 <table class="table table-striped table-bordered table-hover">
                     <thead><thead style="background-color: #DCDCDC;">
                         <tr>
                             <th style="width: 50%;"><?php echo $this->lang->line('Common settings');?></th>
                             <th></th>
                             <th style="width: 25%;"></th>
                             
                         </tr>
                     </thead>
                     <tbody>
                    
                         <tr>
                             <td><?php echo $this->lang->line('Per page');?></td>
                             <td><input name="per_page" value="<?php echo set_value('per_page',$this->config->item('per_page')); ?>" /></td>
                             <td><?php echo form_error('per_page'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Number of links in pagination');?></td>
                             <td><input name="num_links" value="<?php echo set_value('num_links',$this->config->item('num_links')); ?>" /></td>
                             <td><?php echo form_error('num_links'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Moderation (0 - postmoderation, 1 - premoderation)');?></td>
                             <td><input name="moderation" value="<?php echo set_value('moderation',$this->config->item('moderation')); ?>" /></td>
                             <td><?php echo form_error('moderation'); ?></td>
                         </tr>
                          
                         <tr>
                             <td><?php echo $this->lang->line('Number of image users can upload');?></td>
                             <td><input name="num_img" value="<?php echo set_value('num_img',$this->config->item('num_img')); ?>" /></td>
                             <td><?php echo form_error('num_img'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Image normal width, px');?></td>
                             <td><input name="img_normal_width" value="<?php $imgnormal = $this->config->item('img_normal') ; echo set_value('img_normal_width',$imgnormal[0]); ?>" /></td>
                             <td><?php echo form_error('img_normal_width'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Image normal height, px');?></td>
                             <td><input name="img_normal_height" value="<?php echo set_value('img_normal_height',$imgnormal[1]); ?>" /></td>
                             <td><?php echo form_error('img_normal_height'); ?></td>
                         </tr>
                       
                         <tr>
                             <td><?php echo $this->lang->line('Image max size, kB');?></td>
                             <td><input name="img_max_size" value="<?php echo set_value('img_max_size',$this->config->item('img_max_size')); ?>" /></td>
                             <td><?php echo form_error('img_max_size'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Image max width, px');?></td>
                             <td><input name="img_max_width" value="<?php echo set_value('img_max_width',$this->config->item('img_max_width')); ?>" /></td>
                             <td><?php echo form_error('img_max_width'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Image max height, px');?></td>
                             <td><input name="img_max_height" value="<?php echo set_value('img_max_height',$this->config->item('img_max_height')); ?>" /></td>
                             <td><?php echo form_error('img_max_height'); ?></td>
                         </tr>
                        
                     </tbody>
                 </table>
                 <input type="submit" /></form>
             </div>
         </div>
     </div>
   </div>
</div>

