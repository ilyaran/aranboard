<?php defined('BASEPATH') || exit('No direct script access allowed');
class Mobile extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url');
      $this->load->helper('file');
	}
	
   public function index()
	{
      $email = $this->input->post('UserEmail');
      
      $role = (int)$this->input->post('Role');
      
      $results['Result']['Status'] = 0;
      
      if($role == 1 || $role == 2 || $role == 3)
      {
         $q = $this->db->query("
            UPDATE USER SET RoleID = $role WHERE Email = '$email' 
         ");
         
         if($q !== false) $results['Result']['Status'] = 1;
      }
      
      print json_encode($results);
	}
   
}