<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Users').'&nbsp;&rarr;&nbsp;'.$this->lang->line('List');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
         
	<?php  				
		// Show reset password message if exist
		if (isset($reset_message))
			echo $reset_message;
		
		// Show error
		echo validation_errors();
		
		$this->table->set_heading('', $this->lang->line('Username'), 'Email', $this->lang->line('Role'), $this->lang->line('Banned'), $this->lang->line('Last IP'), $this->lang->line('Last login'), $this->lang->line('Created'));
		
		foreach ($users as $user) 
		{
			$banned = ($user->banned == 1) ? 'Yes' : 'No';
			
			$this->table->add_row(
				form_checkbox('checkbox_'.$user->id, $user->id),
				$user->username, 
				$user->email, 
				$user->role_name, 			
				$banned, 
				$user->last_ip,
				date('Y-m-d', strtotime($user->last_login)), 
				date('Y-m-d', strtotime($user->created)));
		}
		
		echo form_open($this->uri->uri_string());
				
		echo form_submit('ban', $this->lang->line('Ban user'));
		echo form_submit('unban', $this->lang->line('Unban user'));
		echo form_submit('reset_pass', $this->lang->line('Reset password'));
		
		echo '<hr/>';
		
		echo $this->table->generate(); 
		
		echo form_close();
		
		echo $pagination;
			
	?>
</div></div></div></div>