<?php defined('BASEPATH') || exit('No direct script access allowed');

class Category extends CI_Controller {
   private static $width = 800;
   private static $height = 600;
   private static $thumb = false;
   private static $overwrite = true;
   private static $ratio = true;
   
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
      $this->load->library('upload');
      $this->load->library('image_lib');
      $this->load->library('form_validation');
      self::$dbtable = 'category';
      if ($this->dx_auth->is_logged_in() && $this->dx_auth->is_admin())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');
      }else redirect('auth/login');
   }
   
   public function index($category_table = 'advert', $enabled = false)
	{
      in_array($category_table, $this->config->item('category_tables')) || preg_match('/^(parameter)$/ui',$category_table) || show_error("Invalid Parameter");
      
      $this->db->select('category_id,category_table,name,parent,sort,level,logo,enabled');
      if($enabled) $this->db->where('enabled',1);
      $this->db->where('category_table',$category_table);
      $this->db->order_by('sort ASC');
      $q=$this->db->get('category');
      CI_Controller::$data['categories'] = $q->result_array();
                      
      self::$data['category_table'] = $category_table;
      $data['content']='adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('adm/main',$data);
	}
   
   public function add($category_table = 'advert')
	{
      in_array($category_table, $this->config->item('category_tables')) || preg_match('/^(parameter)$/ui',$category_table) || show_error("Invalid Parameter");
      
      if(isset($_POST['name']))
      {
         if($this->validation())
         {
            $this->upl_one('logo');
            self::$data['post']['category_table']=$category_table;
            $this->db->insert(self::$dbtable, self::$data['post']);
            $this->create_widgets($category_table);
            redirect('adm/'.__CLASS__.'/index/'.$category_table);
         }
      }
      
      self::$data['category_table'] = $category_table;
      $data['content']='adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('adm/main',$data);
	}
   
   public function edit($category_id = 0, $category_table = 'advert')
	{
      in_array($category_table, $this->config->item('category_tables')) || preg_match('/^(parameter)$/ui',$category_table) || show_error("Invalid Parameter");
      preg_match("/^([0-9]){1,20}$/", $category_id) || show_error("INVALID PARAMETER");
      $q = $this->db ->where(self::$dbtable.'_id', $category_id)
                     ->where('category_table',$category_table)
                     ->get(self::$dbtable);
      $q->num_rows() > 0 || show_error($this->lang->line('No such category!'));
      self::$data[self::$dbtable] = $q->row_array();
      
      if(isset($_POST['name']))
      {
         if($this->validation())
         {
            if($this->upl_one('logo') && self::$data[self::$dbtable]['logo'] != null)
            {
               $path = './upload/logo/'.self::$data[self::$dbtable]['logo'];
               if(file_exists($path)) @unlink($path);  
            }
            self::$data['post']['category_table'] = $category_table;
            $this->db->where(self::$dbtable.'_id',$category_id)->update(self::$dbtable, self::$data['post']);
            $this->create_widgets($category_table);
            redirect('adm/'.__CLASS__.'/index/'.$category_table);
         }
      }
      
      self::$data['category_table'] = $category_table;
      $data['content']='adm/'.__CLASS__.'/'.__FUNCTION__;
      $this->load->view('adm/main',$data);
	}
   
   private function validation()
   {
      $rules = array(
         array('field' => 'parent',         'label' => $this->lang->line('Parent'),         'rules' => 'trim|required|is_natural|max_length[6]|check_category'),
         array('field' => 'name',           'label' => $this->lang->line('Name'),           'rules' => 'trim|required|max_length[128]'),
         array('field' => 'description',    'label' => $this->lang->line('Description'),    'rules' => 'trim|max_length[2048]'),
         array('field' => 'sort',           'label' => $this->lang->line('Sort index'),     'rules' => 'trim|is_natural|max_length[4]'),
         array('field' => 'enabled',        'label' => $this->lang->line('Enabled'),        'rules' => 'trim|is_natural|max_length[1]'),
         array('field' => 'category_table', 'label' => $this->lang->line('Category Table'), 'rules' => 'trim|alpha_dash|max_length[64]'),
      );
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() === true)
      {
         foreach ($rules as $i) 
         {
            self::$data['post'][$i['field']] = set_value($i['field']);
         }
         
         self::$data['post']['category_table'] = in_array(set_value('category_table'),$this->config->item('category_tables')) ? set_value('category_table') : 'product'; 
         self::$data['post']['meta_title'] = mb_substr(self::$data['post']['name'],0,200);
         self::$data['post']['meta_description'] = mb_substr(self::$data['post']['description'],0,200);
         self::$data['post']['meta_keywords'] = mb_substr(preg_replace('/[\s\.\;\"\:^\,]+/',',',self::$data['post']['description']),0,200);
         return true;
      }else return false;
   }
   
   public function del($category_id = 0)
	{
      preg_match("/^[0-9]{1,20}$/", $category_id) || show_error($this->lang->line('Invalid parameter'));
      $q = $this->db->where('category_id',$category_id)->get('category');
      $q->num_rows() > 0 || show_error($this->lang->line('No such category'));
      $category = $q->row_array();
      
      $path = "./upload/logo/{$category['logo']}";
      if(file_exists($path)) @unlink($path);
      
      $this->db->where('parent',$category['category_id'])
               ->update('category',array('parent'=>$category['parent'],'level'=>$category['level']));
      
      $this->db->where('category_id',$category['category_id'])
               ->update($category['category_table'],array('category_id'=>$category['parent']));
   
      $this->db->where('category_id',$category_id)->limit(1)->delete('category');
   
      $this->create_widgets($category['category_table']);
      redirect('adm/'.__CLASS__.'/index/'.$category['category_table']);
	}

   private function upl($key,$path,$filename)
   {
      $config['upload_path'] = $path;
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size']    = $this->config->item('img_max_size'); //'2000';
      $config['max_width'] = $this->config->item('img_max_width'); //'2000';
      $config['max_height'] = $this->config->item('img_max_height'); //'2000';
      $config['overwrite'] = self::$overwrite;
      $config['file_name'] = $filename;
      $this->upload->initialize($config);
      
      if($this->upload->do_upload($key)) return $this->upload->data();
      return false;
   }
    
   private function img_resize ($source,$path,$filename)
   {
     $new_img = $path.$filename;
     $config_img['width'] = self::$width;
     $config_img['height'] = self::$height;
     $config_img['source_image'] = $source;
     $config_img['create_thumb'] = self::$thumb;
     $config_img['maintain_ratio'] = self::$ratio;
     $config_img['new_image'] = $new_img; 
     $this->image_lib->initialize($config_img);  
     
     if($this->image_lib->resize()) 
     {
        $this->image_lib->clear(); 
        return true;
     }else return $this->image_lib->display_errors();
   }
    
   private function upl_one($key, $size = array())
   {
      if( isset($_FILES[$key]) && !empty($_FILES[$key]) && $_FILES[$key]['error']==0)
      {
         $path="./upload/$key/";
            
         $file_type = strrchr($_FILES[$key]['name'],'.');
         $filename = str_replace('.','',microtime(true)).$file_type;
            
         $upldata = $this->upl($key,$path,$filename);
         if(isset($upldata['file_name']))
         {
            if(!empty($size))
            {
              foreach($size as $a=>$s)
              {
                  self::$width=$s[0];
                  self::$height=$s[1];
                  $this->img_resize($upldata['full_path'],$upldata['file_path']."$a/",$upldata['file_name']);
              }
            }
            else
            {
               $this->img_resize($upldata['full_path'],$upldata['file_path']."/",$upldata['file_name']);
            }
            self::$data['post'][$key] = $upldata['file_name'];
            return true;
         }  
      }
      return false;
   }
   
   private function create_widgets($category_table = 'advert')
	{
      if($category_table == 'advert')
      {
         $this->mdl_category->create_menu_vertical();
         $this->mdl_category->create_menu_vertical_organizations();
         $this->mdl_category->create_indexpage_category_list();
         $this->mdl_category->create_options('advert');
      }
      
      if($category_table == 'organization')
      {
         $this->mdl_category->create_menu_vertical_organizations();
      }
      
      if($category_table == 'news')
      {
         $this->mdl_category->create_menu_vertical_news();
      }
      
      $this->mdl_category->create_breadcrumb();
      
	}
   
   
}