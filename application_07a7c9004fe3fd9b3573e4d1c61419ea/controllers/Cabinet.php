<?php defined('BASEPATH') || exit('No direct script access allowed');
class Cabinet extends CI_Controller {
   static $width = 800;
   static $height = 600;
   static $thumb = false;
   static $overwrite = true;
   static $ratio = true;
   
   public function __construct()
   {
      parent::__construct();
      $this->load->library('DX_Auth');
      $this->load->config('board');
      $this->load->config('breadcrumb');
      $this->load->helper('url');//$table
      if ($this->dx_auth->is_logged_in())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');
      }else redirect('auth/login');
	}

   public function index($page = 0)
	{  
      self::$sql = ' `author` = \'' . CI_Controller::$username.'\'';
      $this->get_list($page,'`updated` DESC');
      $attr_value = site_url("cabinet/index/%s");
      $this->set_paging($page, $attr_value);
      
      $this->load->view('header');
      $this->load->view('Cabinet/index');
      $this->load->view('footer');
	}
   
   public function add()
	{
      $this->load->library('upload');
      $this->load->library('image_lib');
      $this->load->library('form_validation');
      
      if(isset($_POST['title']))
      {
         if($this->validation())
         {
            self::$data['post']['created'] = time();
            $this->upl_multi('img');
            $this->db->insert('advert', self::$data['post']);
            
            redirect('cabinet');
         }    
      }
      
      $this->load->view('header');
      //$this->load->view('sidebar_left');
      $this->load->view('Cabinet/add');
      $this->load->view('footer');
	}
   
   public function edit($advert_id = 0)
	{
      preg_match("/^([0-9]){1,20}$/", $advert_id) || show_error("INVALID PARAMETER");
      $q = $this->db ->where('advert_id',$advert_id)
                     ->where('author',self::$username)
                     ->get('advert');
      $q->num_rows() > 0 || show_error($this->lang->line('No such advert!'));
      self::$data['advert'] = $q->row_array();
      self::$data['advert']['img'] = @unserialize(self::$data['advert']['img']);
      
      $this->config->set_item('num_img',$this->config->item('num_img') - count(self::$data['advert']['img']));
      
      $this->load->library('upload');
      $this->load->library('image_lib');
      $this->load->library('form_validation');
      
      if(isset($_POST['title']))
      {
         if($this->validation())
         {
            $this->_img_sort(self::$data['advert']['img']);
            $this->_img_del(self::$data['advert']['img']);
            $this->upl_multi('img');
            $this->db->where('advert_id',$advert_id)->update('advert', self::$data['post']);
            
            redirect('cabinet/edit/'.$advert_id);
         }    
      }

      $this->load->view('header');
      //$this->load->view('sidebar_left');
      $this->load->view('Cabinet/edit');
      $this->load->view('footer');
	}
   
   private function validation()
   {
      $rules = array(
         array('field' => 'category_id',   'label' => $this->lang->line('Category'), 'rules' => 'trim|required|is_natural|max_length[6]|check_category'),
         array('field' => 'title',         'label' => $this->lang->line('Title'),    'rules' => 'trim|required|max_length[512]'),
         array('field' => 'text',          'label' => $this->lang->line('Text'),     'rules' => 'trim|required|max_length[2048]'),
         array('field' => 'contacts',      'label' => $this->lang->line('Contacts'), 'rules' => 'trim|max_length[512]'),
         array('field' => 'price',         'label' => $this->lang->line('Price'),    'rules' => 'trim|max_length[20]|price'),
         array('field' => 'enabled',       'label' => $this->lang->line('Enabled'),  'rules' => 'trim|is_natural|max_length[1]')
      );
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() === true)
      {
         foreach ($rules as $i) 
         {
            self::$data['post'][$i['field']] = set_value($i['field']);
         }  
         self::$data['post']['author'] = self::$username;
         self::$data['post']['meta_title'] = mb_substr(self::$data['post']['title'],0,200);
         self::$data['post']['meta_description'] = mb_substr(self::$data['post']['text'],0,200);
         self::$data['post']['meta_keywords'] = mb_substr(preg_replace('/[\s\.\;\"\:^\,]+/',',',self::$data['post']['text']),0,200);
         return true;
      }else return false;
   }
   
   public function del($advert_id = 0)
	{
      preg_match("/^([0-9]){1,20}$/", $advert_id) || show_error("INVALID PARAMETER");
      $q = $this->db ->where('advert_id',(int)$advert_id)
                     ->where('author',self::$username)
                     ->get('advert');
      $q->num_rows() > 0 || show_error($this->lang->line('No such advert!'));
      $advert = $q->row_array();
      
      $img = @unserialize($advert['img']);
      if(is_array($img))
      {
         foreach($img as $i)
         {
            $path = "./upload/img/$i";
            if(file_exists($path)) @unlink($path);
         }
      }
      $this->db->where('advert_id',$advert_id)->limit(1)->delete('advert');
      
      redirect('cabinet/index');
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
    
   private function upl_multi($key, $size = array())
   {
      if( isset($_FILES[$key]) && !empty($_FILES[$key]))
      {
         $upl_files = $_FILES[$key];
         $counter = 1;
         $path="./upload/$key/";
         foreach($upl_files['error'] as $r=>$i)
         {
            if($counter > $this->config->item('num_img')) break;
            if($i != 0) continue;
            
            $_FILES[$key]['name'] = $upl_files['name'][$r];
            $_FILES[$key]['type'] = $upl_files['type'][$r];
            $_FILES[$key]['tmp_name'] = $upl_files['tmp_name'][$r];
            $_FILES[$key]['error'] = $upl_files['error'][$r];
            $_FILES[$key]['size'] = $upl_files['size'][$r];
            
            $file_type = strrchr($_FILES[$key]['name'],'.');
            $filename = str_replace('.','',microtime(true)).$counter.$file_type;
            
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
               self::$data['advert']['img'][] = $upldata['file_name'];
               $counter ++;
            }
         }
      }
      if(isset(self::$data['advert']['img']) && !empty(self::$data['advert']['img']))
      {
         ksort(self::$data['advert']['img']);
         self::$data['post']['logo'] = current(self::$data['advert']['img']);
         self::$data['post']['img'] = serialize(self::$data['advert']['img']);
      }
   }  
   
   private function _img_del($img)
   {
      if( is_array($img) && !empty($img) )
      {
         $post_img_del = $this->input->post('img_del');
         if(is_array($post_img_del) && !empty($post_img_del))
         {
            foreach($post_img_del as $i)
            {
               if(preg_match('/^[0-9]{1,3}$/',$i) && isset($img[$i]))
               {
                  $path = "./upload/img/{$img[$i]}";
                  if(file_exists($path)) @unlink($path);
                  unset($img[$i]);
               }
            }
            self::$data['advert']['img'] = $img;
         }
      }
   }
   
   private function _img_sort($img)
   {
      if( is_array($img) && !empty($img) )
      {
         $post_img_sort = $this->input->post("img_sort");
         if(is_array($post_img_sort) && !empty($post_img_sort))
         {
            foreach($post_img_sort as $a=>$i)
            {
               if(preg_match('/^[0-9]{1,3}$/',$a) && preg_match('/^[0-9]{1,3}$/',$i))
               {
                  if($a != $i)
                  {
                     if(isset($img[$i]))
                     {
                        $v = $img[$a];
                        $img[$a] = $img[$i];
                        $img[$i] = $v;
                     }
                     else
                     {
                        $img[$i] = $img[$a];
                        unset($img[$a]);
                     }
                  }
               }
            }
            self::$data['advert']['img'] = $img;
         }
      }
   }
   
   
   
   
}

