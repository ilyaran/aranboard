<?php
$this->load->view("header");
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'maxlength'	=> 80,
	'size'	=> 30,
	'value' => set_value('login')
);

?>
<div class="auth">
<fieldset><legend accesskey="D" tabindex="1"><?php echo $this->lang->line('Forgotten Password'); ?></legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label($this->lang->line('Enter your Username or Email Address'), $login['id']); ?></dt>
	<dd>
		<?php echo form_input($login); ?> 
		<?php echo form_error($login['name']); ?>
		<?php echo form_submit('reset', $this->lang->line('Reset Now')); ?>
	</dd>
</dl>

<?php echo form_close()?>
</fieldset></div>
<?php $this->load->view("footer"); ?>