<?php $this->load->view('header');
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember',true),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>
<div class="auth">
<fieldset><legend><?php echo $this->lang->line('Login');?></legend>
<?php echo form_open($this->uri->uri_string())?>
<br>
<?php echo $this->dx_auth->get_auth_error(); ?>


<dl>	
	<dt><?php echo form_label($this->lang->line('Username'), $username['id']);?></dt>
	<dd>
		<?php echo form_input($username)?>
    <?php echo form_error($username['name']); ?>
	</dd>

  <dt><?php echo form_label($this->lang->line('Password'), $password['id']);?></dt>
	<dd>
		<?php echo form_password($password)?>
    <?php echo form_error($password['name']); ?>
	</dd>

<?php if ($show_captcha): ?>

	<dt>Enter the code exactly as it appears. There is no zero.</dt>
	<dd><?php echo $this->dx_auth->get_captcha_image(); ?></dd>

	<dt><?php echo form_label($this->lang->line('Confirmation Code'), $confirmation_code['id']);?></dt>
	<dd>
		<?php echo form_input($confirmation_code);?>
		<?php echo form_error($confirmation_code['name']); ?>
	</dd>
	
<?php endif; ?>

	<dt></dt>
	<dd>
		<?php echo form_checkbox($remember);?> <?php echo form_label($this->lang->line('Remember me'), $remember['id']);?> 
		<?php echo anchor($this->dx_auth->forgot_password_uri, $this->lang->line('Forgot password'));?> 
		<?php
			if ($this->dx_auth->allow_registration) {
				echo anchor($this->dx_auth->register_uri, $this->lang->line('Register'));
			};
		?>
	</dd>

	<dt></dt>
	<dd><?php echo form_submit('login',$this->lang->line('Login'));?></dd>
</dl>

<?php echo form_close()?>
</fieldset>
</div>
<?php $this->load->view("footer") ?>