<?php defined('BASEPATH') || exit('No direct script access allowed');
class Settings extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->library('DX_Auth');
      $this->load->config('board');
      $this->load->config('board_admin');
      $this->load->library('Lib_tree'); 
      $this->load->helper('url');
      $this->load->helper('file');
      $this->load->library('form_validation');
      $this->load->model('mdl_category');
      self::$dbtable = 'settings';
      if ($this->dx_auth->is_logged_in() && $this->dx_auth->is_admin())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');
      }else redirect('auth/login');
   }
   
   public function index()
	{
      if(isset($_POST))
      {
         $rules = array(
            array('field' => 'per_page',       'label' => $this->lang->line('Per page'),                         'rules' => 'trim|is_natural_no_zero|max_length[3]'),
            array('field' => 'num_links',      'label' => $this->lang->line('Number of links in pagination'),    'rules' => 'trim|is_natural_no_zero|max_length[2]'),
            array('field' => 'moderation',     'label' => $this->lang->line('Moderation'),                       'rules' => 'trim|is_natural|max_length[1]'),
            array('field' => 'num_img',        'label' => $this->lang->line('Number of image users can upload'), 'rules' => 'trim|is_natural_no_zero|max_length[3]'),
            array('field' => 'img_max_size',   'label' => $this->lang->line('Image max size'),                   'rules' => 'trim|is_natural_no_zero|max_length[4]'),
            array('field' => 'img_max_width',  'label' => $this->lang->line('Image max width'),                  'rules' => 'trim|is_natural_no_zero|max_length[4]'),
            array('field' => 'img_max_height', 'label' => $this->lang->line('Image max height'),                 'rules' => 'trim|is_natural_no_zero|max_length[4]'),
            array('field' => 'img_normal_width', 'label' => $this->lang->line('Image normal width'),             'rules' => 'trim|is_natural_no_zero|max_length[4]'),
            array('field' => 'img_normal_height', 'label' => $this->lang->line('Image normal height'),           'rules' => 'trim|is_natural_no_zero|max_length[4]')
         );
         $this->form_validation->set_rules($rules);
         if($this->form_validation->run() === true)
         {
            $string = $this->load->view('Adm/Settings/templates/board','',true);
            $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/config','board');
            redirect('adm/settings');
         } 
      }
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
   }
   
   public function auth()
	{
      if(isset($_POST))
      {
         $rules = array(
            array('field' => 'DX_website_name',            'label' => $this->lang->line('Website_name'),            'rules' => 'trim|max_length[64]'),
            array('field' => 'DX_webmaster_email',         'label' => $this->lang->line('Webmaster_email'),         'rules' => 'trim|valid_email|max_length[255]'),
            array('field' => 'DX_salt',                    'label' => $this->lang->line('Salt'),                    'rules' => 'trim|alpha_numeric|max_length[128]'),
            array('field' => 'DX_email_activation',        'label' => $this->lang->line('Email_activation'),        'rules' => 'trim|is_natural_no_zero|max_length[1]'),
            array('field' => 'DX_email_activation_expire', 'label' => $this->lang->line('Email_activation_expire'), 'rules' => 'trim|is_natural|max_length[11]'),
            array('field' => 'DX_email_account_details',   'label' => $this->lang->line('Email_account_details'),   'rules' => 'trim|is_natural_no_zero|max_length[1]'),
            array('field' => 'DX_max_login_attempts',      'label' => $this->lang->line('Max_login_attempts'),      'rules' => 'trim|is_natural_no_zero|max_length[2]'),
            array('field' => 'DX_captcha_registration',    'label' => $this->lang->line('Captcha_registration'),    'rules' => 'trim|is_natural_no_zero|max_length[1]')
            
         );
         $this->form_validation->set_rules($rules);
         if($this->form_validation->run() === true)
         {
            $string = $this->load->view('Adm/Settings/templates/dx_auth','',true);
            $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/config','dx_auth');
            redirect('adm/settings/auth');
         } 
      }
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
   }
   
   public function system()
	{
      if(isset($_POST['theme']))
      {
         $rules = array(
            array('field' => 'theme', 'label' => $this->lang->line('Theme'), 'rules' => 'trim'),
            array('field' => 'logo_name', 'label' => $this->lang->line('Site logo name'), 'rules' => 'trim'),
         );
         $this->form_validation->set_rules($rules);
         if($this->form_validation->run() === true)
         {
            //substr(base_url(),7,-1)
            $theme = $this->input->post('theme');
            $logo_name = $this->input->post('logo_name');
            if($theme !== false && $logo_name !== false)
            {
               $theme = trim($theme, '/');
               $theme = rtrim($theme, '/').'/';
               $this->config->set_item('theme_public',$theme);
               $this->config->set_item('logo_name',$logo_name);
               
               $string = $this->load->view('Adm/Settings/templates/board_admin','',true);
               $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/config','board_admin');
               
               $string = $this->load->view('Adm/Settings/templates/views/header','',true);
               $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/views','header');
               
               $string = $this->load->view('Adm/Settings/templates/views/footer','',true);
               $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/views','footer');
               
               redirect('adm/settings/system');
            }
         } 
      }
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
   }

   


}