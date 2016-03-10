<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Users').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Custom permissions');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
	<?php
		echo '<b>'.$this->lang->line('Here is an example how to use custom permissions').'</b><br/><br/>';
		
		// Build drop down menu
		foreach ($roles as $role)
		{
			$options[$role->id] = $role->name;
		}

		// Change allowed uri to string to be inserted in text area
		if ( ! empty($allowed_uri))
		{
			$allowed_uri = implode("\n", $allowed_uri);
		}
		
		if (empty($edit))
		{
			$edit = FALSE;
		}
			
		if (empty($delete))
		{
			$delete = FALSE;
		}
		
		// Build form
		echo form_open($this->uri->uri_string());
		
		echo form_label($this->lang->line('Role'), 'role_name_label');
		echo form_dropdown('role', $options); 
		echo form_submit('show', $this->lang->line('Show permissions')); 
		
		echo form_label('', 'uri_label');
				
		echo '<hr/>';
		
		echo form_checkbox('edit', '1', $edit);
		echo form_label($this->lang->line('Allow edit'), 'edit_label');
		echo '<br/>';
		
		echo form_checkbox('delete', '1', $delete);
		echo form_label($this->lang->line('Allow delete'), 'delete_label');
		echo '<br/>';
					
		echo '<br/>';
		echo form_submit('save', $this->lang->line('Save Permissions'));
		
		echo '<br/>';
		
		echo $this->lang->line('Open ').anchor('auth/custom_permissions/').$this->lang->line(' to see the result, try to login using user that you have changed.').'<br/>';
		echo $this->lang->line('If you change your own role, you need to relogin to see the result changes.');
		
		echo form_close();
			
	?>
</div></div></div></div>