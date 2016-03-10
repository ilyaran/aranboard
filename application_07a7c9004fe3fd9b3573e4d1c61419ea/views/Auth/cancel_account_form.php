<?php
$this->load->view('header');
$password = array(
	'name'	=> 'password',
	'id'		=> 'password',
	'size' 	=> 30
);

?>
<div class="auth">
<fieldset>
<legend><?php echo $this->lang->line('Cancel Account'); ?></legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label($this->lang->line('Password'), $password['id']); ?></dt>
	<dd>
		<?php echo form_password($password); ?>
		<?php echo form_error($password['name']); ?>
	</dd>
	<dt></dt>
	<dd><?php echo form_submit('cancel', $this->lang->line('Cancel Account')); ?></dd>
</dl>

<?php echo form_close(); ?>
</fieldset></div>
<?php $this->load->view('footer'); ?>