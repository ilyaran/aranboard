<?php defined('BASEPATH') || exit('No direct script access allowed');
class Page extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->library('DX_Auth');
      $this->load->config('board');
      $this->load->config('board_admin');
      $this->load->library('Lib_tree'); 
      $this->load->helper('url');
      $this->load->helper('file');
      $this->load->model('mdl_category');
      self::$dbtable = 'page';
      if ($this->dx_auth->is_logged_in() && $this->dx_auth->is_admin())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');
      }else redirect('auth/login');
   }
   
   public function index($page = 0)
	{
      preg_match("/^([0-9]){1,6}$/", $page ) || show_error("Invalid Parameter");
      
      $this->get_list ($page,'`page_time` DESC');
      $attr_value = site_url("adm/page/index/%s");
      $this->set_paging($page, $attr_value);
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
   }

   public function add()
	{
      $this->load->library('form_validation');
      if(isset($_POST['title']) && isset($_POST['text']))
      {
         if($this->validation())
         {
            $this->db->insert('page', self::$data['post']);
            
            $string = $this->load->view('Adm/Settings/templates/views/header','',true);
            $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/views','header');
            
            redirect('adm/page');
         }    
      }
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
	}
   
   public function edit($page_id=0)
	{
      preg_match("/^([0-9]){1,6}$/", $page_id ) || show_error("Invalid Parameter");
      $this->load->library('form_validation');
      $q = $this->db ->where('page_id',$page_id)
                     ->get('page');
      $q->num_rows() > 0 || show_error($this->lang->line('No such page!'));
      self::$data['page'] = $q->row_array();
      if(isset($_POST['title']) && isset($_POST['body']))
      {
         if($this->validation())
         {
            $this->db->where('page_id',$page_id)->update('page', self::$data['post']);
            
            $string = $this->load->view('Adm/Settings/templates/views/header','',true);
            $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/views','header');
            
            redirect('adm/page');
         }    
      }
      
      $data['content']='Adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('Adm/main',$data);
	}
   
   private function validation()
   {
      $rules = array(
         array('field' => 'url',    'label' => $this->lang->line('Page url'), 'rules' => 'trim|max_length[255]'),
         array('field' => 'sort',    'label' => $this->lang->line('Sort Index'), 'rules' => 'trim|is_natural|max_length[4]'),
         array('field' => 'title',   'label' => $this->lang->line('Title'),      'rules' => 'trim|required|max_length[512]'),
         //array('field' => 'body',    'label' => $this->lang->line('Page Body'),       'rules' => 'max_length[8048]'),
         array('field' => 'display', 'label' => $this->lang->line('Display'),    'rules' => 'trim|is_natural|max_length[1]')
      );
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() === true)
      {
         foreach ($rules as $i) 
         {
            self::$data['post'][$i['field']] = set_value($i['field']);
         }
         
         self::$data['post']['body'] = $this->input->post('body');
         
         return true;
         
      }else return false;
   }
   
   public function del($page_id = 0)
	{
      preg_match("/^([0-9]){1,6}$/", $page_id) || show_error("INVALID PARAMETER");
      $this->db->where('page_id',(int)$page_id)->limit(1)->delete('page');
      
      $string = $this->load->view('Adm/Settings/templates/views/header','',true);
      $this->mdl_category->save_to_files($string,'./'.$this->mdl_category->app_path.'/views','header');
            
      redirect('adm/page');
	}


}