<h4  style="background-color: white;padding: 6px;"><?php echo  $this->session->userdata('DX_role_name').' : '.CI_Controller::$username; ?></h4>   
<div style="background-color: #009CD5;">
   <a class="btn btn-default"   href="<?php echo site_url('cabinet/index'); ?>"><?php echo $this->lang->line('Adverts'); ?></a> 
   <a class="btn btn-info" href="<?php echo site_url('auth/change_password'); ?>"><?php echo $this->lang->line('Change password'); ?></a> 
   <a title="<?php echo $this->lang->line('Warning! Delete your account and all your adverts');?>" class="btn btn-danger" href="<?php echo site_url('auth/cancel_account'); ?>"><?php echo $this->lang->line('Delete'); ?></a>
</div>