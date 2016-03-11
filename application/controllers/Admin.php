<?php defined('BASEPATH') || exit('No direct script access allowed');
class Admin extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('url');
   }
   
   public function index()
	{
      redirect('adm/advert');
	}
}