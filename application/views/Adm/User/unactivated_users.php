<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Users').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Unactivated users');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
	<?php  				
		// Show error
		echo validation_errors();
		
		$this->table->set_heading('', 'Username', 'Email', 'Register IP', 'Activation Key', 'Created');
		
		foreach ($users as $user) 
		{
			$this->table->add_row(
				form_checkbox('checkbox_'.$user->id, $user->username).form_hidden('key_'.$user->id, $user->activation_key),
				$user->username, 
				$user->email, 
				$user->last_ip, 				
				$user->activation_key, 
				date('Y-m-d', strtotime($user->created)));
		}
		
		echo form_open($this->uri->uri_string());
				
		echo form_submit('activate', 'Activate User');
		
		echo '<hr/>';
		
		echo $this->table->generate(); 
		
		echo form_close();
		
		echo $pagination;
			
	?>
	</div></div></div></div>