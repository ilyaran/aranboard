<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Users').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Uri permissions');?>
         </div>
         <div id="cabinet_panel" class="panel-body">	
	<?php  				
		// Build drop down menu
		foreach ($roles as $role)
		{
			$options[$role->id] = $role->name;
		}

		// Change allowed uri to string to be inserted in text area
		if ( ! empty($allowed_uris))
		{
			$allowed_uris = implode("\n", $allowed_uris);
		}
		
		// Build form
		echo form_open($this->uri->uri_string());
		
		echo form_label($this->lang->line('Role'), 'role_name_label');
		echo form_dropdown('role', $options); 
		echo form_submit('show', $this->lang->line('Show URI permissions')); 
		
		echo form_label('', 'uri_label');
				
		echo '<hr/>';
				
		echo $this->lang->line('Allowed URI (One URI per line)').' :<br/><br/>';
		
		echo $this->lang->line('Input \'/\' to allow role access all URI.')."<br/>";
		echo $this->lang->line('Input \'/controller/\' to allow role access controller and it\'s function.')."<br/>";
		echo $this->lang->line('Input \'/controller/function/\' to allow role access controller/function only.')."<br/><br/>";
		echo $this->lang->line('These rules only have effect if you use check_uri_permissions() in your controller').'<br/><br/>.';
		
		echo form_textarea('allowed_uris', $allowed_uris); 
				
		echo '<br/>';
		echo form_submit('save', $this->lang->line('Save URI Permissions'));
		
		echo form_close();
	?>
</div></div></div></div>