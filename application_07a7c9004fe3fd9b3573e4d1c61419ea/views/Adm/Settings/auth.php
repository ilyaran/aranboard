<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Settings').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Auth');?>
         
         </div>
         <div id="cabinet_panel" class="panel-body">
             
             <div class="table-responsive">
             <form method="post"><input type="submit" />
                 <table class="table table-striped table-bordered table-hover">
                     <thead style="background-color: #DCDCDC;">
                         <tr>
                             <th style="width: 50%;"><?php echo $this->lang->line('Authorization settings');?></th>
                             <th></th>
                             <th style="width: 25%;"></th>
                             
                         </tr>
                     </thead>
                     <tbody>
                    
                         <tr>
                             <td><?php echo $this->lang->line('Website_name');?></td>
                             <td><input name="DX_website_name" value="<?php echo set_value('DX_website_name',$this->config->item('DX_website_name')); ?>" /></td>
                             <td><?php echo form_error('DX_website_name'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Webmaster_email');?></td>
                             <td><input name="DX_webmaster_email" value="<?php echo set_value('DX_webmaster_email',$this->config->item('DX_webmaster_email')); ?>" /></td>
                             <td><?php echo form_error('DX_webmaster_email'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Salt');?></td>
                             <td><input name="DX_salt" value="<?php echo set_value('DX_salt',$this->config->item('DX_salt')); ?>" /></td>
                             <td><?php echo form_error('DX_salt'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Email_activation');?></td>
                             <td><input name="DX_email_activation" value="<?php echo set_value('DX_email_activation',$this->config->item('DX_email_activation')); ?>" /></td>
                             <td><?php echo form_error('DX_email_activation'); ?></td>
                         </tr>
                          
                         <tr>
                             <td><?php echo $this->lang->line('Email_activation_expire');?></td>
                             <td><input name="DX_email_activation_expire" value="<?php echo set_value('DX_email_activation_expire',$this->config->item('DX_email_activation_expire')); ?>" /></td>
                             <td><?php echo form_error('DX_email_activation_expire'); ?></td>
                         </tr>
                         
                       
                         <tr>
                             <td><?php echo $this->lang->line('Email_account_details');?></td>
                             <td><input name="DX_email_account_details" value="<?php echo set_value('DX_email_account_details',$this->config->item('DX_email_account_details')); ?>" /></td>
                             <td><?php echo form_error('DX_email_account_details'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Max_login_attempts');?></td>
                             <td><input name="DX_max_login_attempts" value="<?php echo set_value('DX_max_login_attempts',$this->config->item('DX_max_login_attempts')); ?>" /></td>
                             <td><?php echo form_error('DX_max_login_attempts'); ?></td>
                         </tr>
                         
                         <tr>
                             <td><?php echo $this->lang->line('Captcha_registration');?></td>
                             <td><input name="DX_captcha_registration" value="<?php echo set_value('DX_captcha_registration',$this->config->item('DX_captcha_registration')); ?>" /></td>
                             <td><?php echo form_error('DX_captcha_registration'); ?></td>
                         </tr>
                     </tbody>
                 </table>
                 <input type="submit" /></form>
             </div>
         </div>
     </div>
   </div>
</div>

