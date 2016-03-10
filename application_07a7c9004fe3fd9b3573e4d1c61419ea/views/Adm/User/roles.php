<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
      
      <div class="panel panel-default">
         <div class="panel-heading">
         <?php echo $this->lang->line('Users').'&nbsp;&rarr;&nbsp;'.$this->lang->line('Roles');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
	<?php  				
		// Show error
		echo validation_errors();
		
		// Build drop down menu
		$options[0] = 'None';
		foreach ($roles as $role)
		{
			$options[$role->id] = $role->name;
		}
	
		// Build table
		$this->table->set_heading('', $this->lang->line('ID'), $this->lang->line('Name'), $this->lang->line('Parent ID'));
		
		foreach ($roles as $role)
		{			
			$this->table->add_row(form_checkbox('checkbox_'.$role->id, $role->id), $role->id, $role->name, $role->parent_id);
		}
		
		// Build form
		echo form_open($this->uri->uri_string());
		
		echo form_label($this->lang->line('Role parent'), 'role_parent_label');
		echo form_dropdown('role_parent', $options); 
				
		echo form_label($this->lang->line('Role name'), 'role_name_label');
		echo form_input('role_name', ''); 
		
		echo form_submit('add', $this->lang->line('Add role')); 
		echo form_submit('delete', $this->lang->line('Delete selected role'));
				
		echo '<hr/>';
		
		// Show table
		echo $this->table->generate(); 
		
		echo form_close();
			
	?>
	</div></div></div></div>