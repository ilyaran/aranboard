<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Settings').'&nbsp;&rarr;&nbsp;'.$this->lang->line('System');?>
         
         </div>
         <div id="cabinet_panel" class="panel-body">
             
             <div class="table-responsive">
             <form method="post"><input type="submit" />
                 <table class="table table-striped table-bordered table-hover">
                     <thead><thead style="background-color: #DCDCDC;">
                         <tr>
                             <th style="width: 50%;"><?php echo $this->lang->line('System settings');?></th>
                             <th></th>
                             <th style="width: 25%;"></th>
                             
                         </tr>
                     </thead>
                     <tbody>
                    
                          <tr>
                             <td><?php echo $this->lang->line('Logo Name');?></td>
                             <td><input name="logo_name" value="<?php echo set_value('logo_name',$this->config->item('logo_name')); ?>" /></td>
                             <td><?php echo form_error('logo_name'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Theme');?></td>
                             <td><input name="theme" value="<?php echo set_value('theme',$this->config->item('theme_public')); ?>" /></td>
                             <td><?php echo form_error('theme'); ?></td>
                         </tr>
                         
                         
                        
                      
                     </tbody>
                     
                     
                 </table>
                 <input type="submit" /></form>
             </div>
         </div>
     </div>
   </div>
</div>

