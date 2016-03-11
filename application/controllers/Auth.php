<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	function __construct()
	{
		parent::__construct();
      $this->load->config('board');
      $this->load->library('DX_Auth');
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		
		$this->load->helper('url');
		$this->load->helper('form');
      if ($this->dx_auth->is_logged_in())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');  
      }
	}
	
	function index()
	{
		$this->login();
	}
	
	/* Callback function */
	
	function username_check($username)
	{
		$result = $this->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->form_validation->set_message('username_check', $this->lang->line('Username already exist. Please choose another username.'));
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->form_validation->set_message('email_check', $this->lang->line('Email is already used by another user. Please choose another email address.'));
		}
				
		return $result;
	}

	
	function recaptcha_check()
	{
		$result = $this->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->form_validation->set_message('recaptcha_check', $this->lang->line('Your confirmation code does not match the one in the image. Try again.'));
		}
		
		return $result;
	}
	
	/* End of Callback function */
	
	
	function login()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('username', $this->lang->line('Username'), 'trim|required|alpha_dash');
			$val->set_rules('password', $this->lang->line('Password'), 'trim|required|alpha_dash');
			$val->set_rules('remember', $this->lang->line('Remember me'), 'integer');

			// Set captcha rules if login attempts exceed max attempts in config
			if ($this->dx_auth->is_max_login_attempts_exceeded())
			{
				$val->set_rules('captcha', $this->lang->line('Confirmation Code'), 'trim|required|callback_captcha_check');
			}

			//$resultA = $val->run();
			//$resultB = $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember'));


				
			if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))
			{
				// Redirect to homepage
				redirect('', 'location');
			}
			else
			{
				// Check if the user is failed logged in because user is banned user or not
				if ($this->dx_auth->is_banned())
				{
					// Redirect to banned uri
					$this->dx_auth->deny_access('banned');
				}
				else
				{						
					// Default is we don't show captcha until max login attempts eceeded
					$data['show_captcha'] = FALSE;
				
					// Show captcha if login attempts exceed max attempts in config
					if ($this->dx_auth->is_max_login_attempts_exceeded())
					{
						// Create catpcha						
						$this->dx_auth->captcha();
						
						// Set view data to show captcha on view file
						$data['show_captcha'] = TRUE;
					}
					
					// Load login page view
					$this->load->view($this->dx_auth->login_view, $data);
				}
			}
		}
		else
		{
			$data['auth_message'] = $this->lang->line('You are already logged in.');
			$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
	
	function logout()
	{
		$this->dx_auth->logout();
		redirect();
		//$data['auth_message'] = $this->lang->line('You have been logged out.');		
		//$this->load->view($this->dx_auth->logout_view, $data);
	}
	
	
	function register()
	{
		if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
		{	
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('username', $this->lang->line('Username'), 'trim|required|min_length['.$this->min_username.']|max_length['.$this->max_username.']|username_check|alpha_dash');
			$val->set_rules('password', $this->lang->line('Password'), 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', $this->lang->line('Confirm Password'), 'trim|required');
			$val->set_rules('email', 'Email', 'trim|required|valid_email|email_check');
			
			// Is registration using captcha
			if ($this->dx_auth->captcha_registration)
			{
				// Set recaptcha rules.
				// IMPORTANT: Do not change 'recaptcha_response_field' because it's used by reCAPTCHA API,
				// This is because the limitation of reCAPTCHA, not DX Auth library
				$val->set_rules('recaptcha_response_field', $this->lang->line('Confirmation Code'), 'trim|required|recaptcha_check');
			}

			// Run form validation and register user if it's pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
			{	
				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$data['auth_message'] = $this->lang->line('You have successfully registered. Check your email address to activate your account.');
				}
				else
				{					
					$data['auth_message'] = $this->lang->line('You have successfully registered. ').anchor(site_url($this->dx_auth->login_uri), $this->lang->line('Login'));
				}
				
				// Load registration success page
				$this->load->view($this->dx_auth->register_success_view, $data);
			}
			else
			{
				// Load registration page
				$this->load->view('Auth/register_form');
			}
		}
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$data['auth_message'] = $this->lang->line('Registration has been disabled.');
			$this->load->view($this->dx_auth->register_disabled_view, $data);
		}
		else
		{
			$data['auth_message'] = $this->lang->line('You have to logout first, before registering.');
			$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
	
	function activate()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Activate user
		if ($this->dx_auth->activate($username, $key)) 
		{
			$data['auth_message'] = $this->lang->line('Your account have been successfully activated. ').anchor(site_url($this->dx_auth->login_uri), $this->lang->line('Login'));
			$this->load->view($this->dx_auth->activate_success_view, $data);
		}
		else
		{
			$data['auth_message'] = $this->lang->line('The activation code you entered was incorrect. Please check your email again.');
			$this->load->view($this->dx_auth->activate_failed_view, $data);
		}
	}
	
	function forgot_password()
	{
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_rules('login', $this->lang->line('Username or Email address'), 'trim|required');

		// Validate rules and call forgot password function
		if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
		{
			$data['auth_message'] = $this->lang->line('An email has been sent to your email with instructions with how to activate your new password.');
			$this->load->view($this->dx_auth->forgot_password_success_view, $data);
		}
		else
		{
			$this->load->view($this->dx_auth->forgot_password_view);
		}
	}
	
	function reset_password()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Reset password
		if ($this->dx_auth->reset_password($username, $key))
		{
			$data['auth_message'] = $this->lang->line('You have successfully reset you password, ').anchor(site_url($this->dx_auth->login_uri), $this->lang->line('Login'));
			$this->load->view($this->dx_auth->reset_password_success_view, $data);
		}
		else
		{
			$data['auth_message'] = $this->lang->line('Reset failed. Your username and key are incorrect. Please check your email again and follow the instructions.');
			$this->load->view($this->dx_auth->reset_password_failed_view, $data);
		}
	}
	
	function change_password()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_rules('old_password', $this->lang->line('Old Password'), 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', $this->lang->line('New Password'), 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', $this->lang->line('Confirm new Password'), 'trim|required');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$data['auth_message'] = $this->lang->line('Your password has successfully been changed.');
				$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
			else
			{
				$this->load->view($this->dx_auth->change_password_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
	
	function cancel_account()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('password', $this->lang->line('Password'), "trim|required");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				redirect('', 'location');
			}
			else
			{
				$this->load->view($this->dx_auth->cancel_account_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	// Example how to get permissions you set permission in /backend/custom_permissions/
	function custom_permissions()
	{
		if ($this->dx_auth->is_logged_in())
		{
			echo $this->lang->line('My role: ').$this->dx_auth->get_role_name().'<br/>';
			echo $this->lang->line('My permission: <br/>');
			
			if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit'))
			{
				echo $this->lang->line('Edit is allowed');
			}
			else
			{
				echo $this->lang->line('Edit is not allowed');
			}
			
			echo '<br/>';
			
			if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
			{
				echo $this->lang->line('Delete is allowed');
			}
			else
			{
				echo $this->lang->line('Delete is not allowed');
			}
		}
	}


}