<?php defined('BASEPATH') || exit('No direct script access allowed');

class MY_Form_Validation extends CI_Form_Validation {

   function __construct(){
      parent::__construct();
   }
   
   function price($str){
      if (preg_match('/^[0-9\.\,]+$/',$str))
      {
         return true;
      }else{
         return false;
      }
   }
   
   public function check_category($id){
		if($id == 0) return true;
      $q = $this->CI->db->get_where('category', array('category_id' => $id),1);
      if($q->num_rows() > 0)
      {
         if(CI_Controller::$dbtable == 'category')
         {
            CI_Controller::$data['post']['level'] = $q->row()->level + 1;
            
         }
         return true;
      } 
      else false;
	}
   
   	/* DX_Auth Callback functions */
	
	function username_check($username)
	{
		$result = $this->CI->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->set_message('username_check', $this->CI->lang->line('Username already exist. Please choose another username.'));
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->CI->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->set_message('email_check', $this->CI->lang->line('Email is already used by another user. Please choose another email address.'));
		}
				
		return $result;
	}

	
	function recaptcha_check()
	{
		$result = $this->CI->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->set_message('recaptcha_check', $this->CI->lang->line('Your confirmation code does not match the one in the image. Try again.'));
		}
		
		return $result;
	}
	
	/* End of DX_Auth Callback functions */
 	
    
}
