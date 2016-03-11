<?php defined('BASEPATH') or exit('No direct script access allowed');
class Lib_recaptcha {
   public $ci;
   function __construct(){
      
      $this->ci =& get_instance();
   }
   
  	 function get_recaptcha_reload_link($text = 'Get another CAPTCHA')
	{
		return '<a href="javascript:Recaptcha.reload()">'.$text.'</a>';
	}
		
	function get_recaptcha_switch_image_audio_link($switch_image_text = 'Get an image CAPTCHA', $switch_audio_text = 'Get an audio CAPTCHA')
	{
		return '<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type(\'audio\')">'.$switch_audio_text.'</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type(\'image\')">'.$switch_image_text.'</a></div>';
	}
	
	function get_recaptcha_label($image_text = 'Enter the words above', $audio_text = 'Enter the numbers you hear')
	{
		return '<span class="recaptcha_only_if_image">'.$image_text.'</span>
			<span class="recaptcha_only_if_audio">'.$audio_text.'</span>';
	}
	
	// Get captcha image
	function get_recaptcha_image()
	{
		return '<div id="recaptcha_image"></div>';
	}
	
	// Get captcha input box 
	// IMPORTANT: You should at least use this function when showing captcha even for testing, otherwise reCAPTCHA image won't show up
	// because reCAPTCHA javascript will try to find input type with id="recaptcha_response_field" and name="recaptcha_response_field"
	function get_recaptcha_input()
	{
		return '<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />';
	}
	
	// Get recaptcha javascript and non javasript html
	// IMPORTANT: you should put call this function the last, after you are using some of get_recaptcha_xxx function above.
	function get_recaptcha_html()
	{
		// Load reCAPTCHA helper function
		$this->ci->load->helper('recaptcha');
		
		// Add custom theme so we can get only image
		$options = "<script>
			var RecaptchaOptions = {
				 theme: 'custom',
				 custom_theme_widget: 'recaptcha_widget'
			};
			</script>";					
			
		// Get reCAPTCHA javascript and non javascript HTML
		$html = recaptcha_get_html($this->ci->config->item('DX_recaptcha_public_key'));
		
		return $options.$html;
	}
	
	// Check if entered captcha code match with the image.
	// Use this in callback function in your form validation
	function is_recaptcha_match()
	{
		$this->ci->load->helper('recaptcha');
		
		$resp = recaptcha_check_answer($this->ci->config->item('DX_recaptcha_private_key'),
			$_SERVER["REMOTE_ADDR"],				
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
			
		return $resp->is_valid;
	}
		
	/* End of Recaptcha function */
   
   
}