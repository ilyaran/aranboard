<?php defined('BASEPATH') || exit('No direct script access allowed');
class Advert extends CI_Controller {
   static $current_category = array();
   static $category_parents = array();
   static $category_children = array();
   static $categories = array();
   
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
      $this->load->config('board_admin');
      $this->load->helper('url');
      $this->load->helper('file');
      $this->load->library('Lib_tree');
      $this->lib_tree->init();
      $this->load->model('Mdl_category');
      if ($this->dx_auth->is_logged_in())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');
      
      }else redirect('auth/login');
   }
   
   public function index($category_table = 'advert', $category_id = 0, $page = 0 )
	{
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      preg_match("/^([0-9]){1,6}$/", $category_id ) || show_error($this->lang->line('Invalid parameter'));
      preg_match("/^([0-9]){1,6}$/", $page ) || show_error($this->lang->line('Invalid parameter'));
      self::$sql .= ' `status` = 0';
      self::$dbtable = $category_table;
      if($this->Mdl_category->get_category($category_id,false,$category_table))
      {
         self::$breadcrumb['current'] = Mdl_category::$current_category;
         self::$breadcrumb['parents'] = Mdl_category::$category_parents;
         self::$breadcrumb['children'] = Mdl_category::$category_children;
         if(!empty(self::$breadcrumb))
         {
            if(!empty(self::$breadcrumb['children']))
            {
               self::$sql .= " AND `category_id` IN ($category_id";
               foreach(self::$breadcrumb['children'] as $i)
               {
                  self::$sql .=",{$i['category_id']}";
               }
               self::$sql .= ')';
            }
            else self::$sql .= " AND `category_id` = $category_id";
         } 
      }
      
      
      $this->get_list ($page,'`updated` DESC');
      $attr_value = site_url("adm/advert/index/$category_table/$category_id/%s");
      $this->set_paging($page, $attr_value);
      self::$data['category_table'] = $category_table;
      self::$last_q = $this->db->last_query();
      $data['content'] = "Adm/Advert/$category_table/index";
      $this->load->view('Adm/main',$data);
      
	}
   public function ajax_catalog($category_table = 'advert', $page = 0) 
   {
      in_array($category_table,array('advert','news','organization')) || show_error("Invalid parameter");
      $this->input->is_ajax_request() || exit("IT IS NOT AJAX");
      preg_match("/^[0-9]{1,6}$/i", $page ) || exit("Invalid Parameter");
      
      if(isset($_POST['status']) && preg_match('/^[0-9]$/',$_POST['status']))
      {
         $status = (int)$_POST['status'];
         if($status > -1 && $status < 9) 
         {
            self::$sql .= " `status` = $status AND ";
         }
      }
      
      if(isset($_POST['search']) && preg_match('/^[a-zA-Zа-яА-Я0-9\,\.\-\(\)\[\]\@\#\$\%\!\&\~\`\s]{0,64}$/',$_POST['search']))
      {
         $search = $_POST['search'];
         if($search != '') 
         {
            if($category_table == 'news')
            {
               self::$sql .= " ( `title` LIKE '%$search%' ESCAPE '!' OR `text` LIKE '%$search%' )";
            }
            else self::$sql .= " ( `title` LIKE '%$search%' ESCAPE '!' OR `text` LIKE '%$search%' ESCAPE '!' OR `contacts` LIKE '%$search%' )";
            
            self::$sql .= " AND ";
         }  
      }
      
      $order = '';   
      
      if($category_table == 'advert')
      {
         if(isset($_POST['category_id']) && preg_match('/^[0-9]{1,6}$/',$_POST['category_id']))
         {
            $category_id = $this->input->post('category_id');
            if(!$this->mdl_category->get_category($category_id))
            {}
            self::$breadcrumb['current'] = Mdl_category::$current_category;
            self::$breadcrumb['parents'] = Mdl_category::$category_parents;
            self::$breadcrumb['children'] = Mdl_category::$category_children;
            if($category_id > 0 && !empty(self::$breadcrumb))
            {
               if(!empty(self::$breadcrumb['children']))
               {
                  self::$sql .= " `category_id` IN ($category_id";
                  foreach(self::$breadcrumb['children'] as $i)
                  {
                     self::$sql .=",{$i['category_id']}";
                  }
                  self::$sql .= ')';
               }
               else self::$sql .= " `category_id` = $category_id";
               self::$sql .= " AND ";
            }
         }
         
         if(isset($_POST['price_from']) && preg_match('/^[0-9\.\,]{1,20}$/',$_POST['price_from']))
         {
            $price_from = (float)$_POST['price_from']; 
            if($price_from > 0) self::$sql .= " price > $price_from AND ";
         }
         
         if(isset($_POST['price_to']) && preg_match('/^[0-9\,\.]{1,20}$/',$_POST['price_to']))
         {
            $price_to = (float) $_POST['price_to'];
            if($price_to > 0) self::$sql .= " price < $price_to AND ";
         }
         
         if(isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
         {
            $sort = $_POST['sort'];
            if( $sort == 1 ) $order = '`price` ASC';
            if( $sort == 2 ) $order = '`price` DESC';
         }
      }

      if($order == '' && isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
      {
         $sort = $_POST['sort'];
         if( $sort == 3 ) $order = '`title` ASC';
         if( $sort == 4 ) $order = '`title` DESC';
         if( $sort == 5 ) $order = '`updated` DESC';
         if( $sort == 6 ) $order = '`updated` ASC';
         if( $sort == 7 ) $order = '`advert_id` DESC';
         if( $sort == 8 ) $order = '`advert_id` ASC';
      }
      
      self::$sql = substr(self::$sql,0,-4);
      
      if(isset($_POST['per_page']) && preg_match('/^([0-9]){2,3}$/',$_POST['per_page'])) 
            $this->config->set_item('per_page', (int)$_POST['per_page']);
      
      self::$dbtable = $category_table;
      $this->get_list($page,$order);
      $this->set_paging($page,"catalog_list('%s')",'onclick');
      self::$last_q = $this->db->last_query();
      
      header('Content-Type: text/html; charset=utf-8');
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
      
      $view = 'Adm/Advert/advert/index';
      if($category_table == 'news') $view = 'Adm/Advert/news/index';
      if($category_table == 'organization') $view = 'Adm/Advert/organization/index';
      
      $this->load->view($view);
   }
   public function ajax_catalog12($category_table = 'advert', $page = 0) 
   {
      $this->input->is_ajax_request() || exit("IT IS NOT AJAX");
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      preg_match("/^[0-9]{1,20}$/i", $page ) || exit("Invalid Parameter");
      $sql='';
      if($this->config->item('moderation') == 1)
      {
         $sql .= ' `status` = 1 AND ';
      }
      $sql .= ' `enabled` = 1 ';
      
      if(isset($_POST['category_id']) && preg_match('/^[0-9]{1,20}$/',$_POST['category_id']))
      {
         $category_id = $this->input->post('category_id');
         if(!$this->mdl_category->get_category($category_id))
         {
            self::$breadcrumb['current'] = Mdl_category::$current_category;
            self::$breadcrumb['parents'] = Mdl_category::$category_parents;
            self::$breadcrumb['children'] = Mdl_category::$category_children;
            if($category_id > 0 && !empty(self::$breadcrumb))
            {
               if(!empty(self::$breadcrumb['children']))
               {
                  $sql .= " AND `category_id` IN ($category_id";
                  foreach(self::$breadcrumb['children'] as $i)
                  {
                     $sql .=",{$i['category_id']}";
                  }
                  $sql .= ')';
               }
               else $sql .= "`category_id` = $category_id";
            }
         }
      }
      
      if(isset($_POST['price_from']) && preg_match('/^[0-9\.\,]{1,20}$/',$_POST['price_from']))
      {
         $price_from = (float)$_POST['price_from']; 
         if($price_from > 0) $sql .= " AND price > $price_from";
      }
      
      if(isset($_POST['price_to']) && preg_match('/^[0-9\,\.]{1,20}$/',$_POST['price_to']))
      {
         $price_to = (float) $_POST['price_to'];
         if($price_to > 0) $sql .= " AND price < $price_to";
      }
      
      if(isset($_POST['search']) && preg_match('/^[a-zA-Zа-яА-Я0-9\,\.\-\(\)\[\]\@\#\$\%\!\&\~\`\s]{0,64}$/',$_POST['search']))
      {
         $search = $_POST['search'];
         if($search != '') 
         {
            $sql .= " AND ( `title` LIKE '%$search%' OR `text` LIKE '%$search%' OR `contacts` LIKE '%$search%')";
         }  
      }
     
      self::$sql = $sql;
      
      $order = '`price` ASC';
      if(isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
      {
         $sort = $_POST['sort'];
         if( $sort == 1 ) $order = '`price` ASC';
         if( $sort == 2 ) $order = '`price` DESC';
         if( $sort == 3 ) $order = '`title` ASC';
         if( $sort == 4 ) $order = '`title` DESC';
      }
      
      if(isset($_POST['per_page']) && preg_match('/^([0-9]){2,3}$/',$_POST['per_page'])) 
            $this->config->set_item('per_page', (int)$_POST['per_page']);
      
      $this->get_list($page,$order);
      $this->set_paging($page,"catalog_list('%s')",'onclick');
      self::$last_q = $this->db->last_query();
      header('Content-Type: text/html; charset=utf-8');
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
      $this->load->view('Adm/Advert/advert/index');
   }
   
   public function ajax_catalog11($page = 0) 
   {
      $this->input->is_ajax_request() || exit($this->lang->line('It is not AJAX'));
      //in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      preg_match("/^[0-9]{1,20}$/", $page ) || exit($this->lang->line('Invalid parameter'));
      $sql='';
      $presql = function()use(&$sql){return $sql == '' ? '' :' AND ';};
      if(isset($_POST['category_id']) && preg_match('/^[0-9]{1,6}$/',$_POST['category_id']))
      {
         $category_id = $_POST['category_id'];
         $this->mdl_category->get_category($category_id);
         self::$breadcrumb['current'] = Mdl_category::$current_category;
         self::$breadcrumb['parents'] = Mdl_category::$category_parents;
         self::$breadcrumb['children'] = Mdl_category::$category_children;
         if($category_id > 0 && !empty(self::$breadcrumb))
         {
            if(!empty(self::$breadcrumb['children']))
            {
               $sql .= " `category_id` IN ($category_id";
               foreach(self::$breadcrumb['children'] as $i)
               {
                  $sql .= ",{$i['category_id']}";
               }
               $sql .= ')';
            }
            else $sql .= " category_id = $category_id";
         }
         
      }
      
      if(isset($_POST['price_from']) && preg_match('/^[0-9\.\,]{1,20}$/',$_POST['price_from']))
      {
         $price_from = (float)$_POST['price_from']; 
         if($price_from > 0) $sql .= $presql()."price > $price_from";
      }
      
      if(isset($_POST['price_to']) && preg_match('/^[0-9\,\.]{1,20}$/',$_POST['price_to']))
      {
         $price_to = (float) $_POST['price_to'];
         if($price_to > 0) $sql .= $presql()."price < $price_to";
      }
      
      if(isset($_POST['status']) && preg_match('/^[0-9]{1}$/',$_POST['status']))
      {
         $status = $_POST['status']; 
         $sql .= $presql()." `status` = $status ";
      }
      
      if(isset($_POST['search']) && preg_match('/^[a-zA-Zа-яА-Я0-9\,\.\-\(\)\[\]\@\#\$\%\!\&\~\`\s]{0,64}$/',$_POST['search']))
      {
         $search = $_POST['search'];
         if($search != '') 
         {
            $sql .= $presql()."( `title` LIKE '%$search%' OR `text` LIKE '%$search%' OR `contacts` LIKE '%$search%')";
         }  
      }
     
      self::$sql = $sql;
      
      $order = '`price` ASC';
      if(isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
      {
         $sort = $_POST['sort'];
         if( $sort == 5 ) $order = '`updated` DESC';
         if( $sort == 6 ) $order = '`updated` ASC';
         if( $sort == 3 ) $order = '`title` ASC';
         if( $sort == 4 ) $order = '`title` DESC';
      }
      
      if(isset($_POST['per_page']) && preg_match('/^([0-9]){2,3}$/',$_POST['per_page'])) 
            $this->config->set_item('per_page', (int)$_POST['per_page']);
      
      $this->get_list($page,$order);
      $this->set_paging($page,"catalog_list('%s')",'onclick');
      //self::$last_q = $this->db->last_query();
      header('Content-Type: text/html; charset=utf-8');
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
      $this->load->view('Adm/Advert/index');
   }
   
   public function add($category_table = 'advert')
	{
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      $this->load->library('upload');
      $this->load->library('image_lib');
      $this->load->library('form_validation');
      if(isset($_POST['title']))
      {
         if($this->validation($category_table))
         {
            self::$data['post']['created'] = time();
            $this->upl_multi('img');
            self::$data['post']['author'] = self::$username;
            $this->db->insert($category_table, self::$data['post']);
            
            redirect("adm/advert/index/$category_table");
         }    
      }
      
      $data['content']="Adm/Advert/$category_table/add";
      $this->load->view('Adm/main',$data);
	}
   
   public function edit($id = 0, $category_table = 'advert')
	{
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      preg_match("/^([0-9]){1,20}$/", $id) || show_error("INVALID PARAMETER");
      $q = $this->db ->where("{$category_table}_id",$id)
                     ->get($category_table);
      $q->num_rows() > 0 || show_error($this->lang->line('No such '.$category_table.'!'));
      self::$data[$category_table] = $q->row_array();
      self::$data['post']['img'] = @unserialize(self::$data[$category_table]['img']);
      
      $this->config->set_item('num_img',$this->config->item('num_img') - count(self::$data['post']['img']));
      
      $this->load->library('upload');
      $this->load->library('image_lib');
      $this->load->library('form_validation');
      
      if(isset($_POST['title']))
      {
         
         if($this->validation($category_table))
         {
            //print_r(self::$data[$category_table]['img']);
            $this->_img_sort();
            $this->_img_del();
            $this->upl_multi('img');
            $this->db->where("{$category_table}_id",$id)->update($category_table, self::$data['post']);
            
            redirect("adm/advert/edit/$id/$category_table");
         }    
      }

      $data['content']="Adm/Advert/$category_table/edit";
      $this->load->view('Adm/main',$data);
	}
   
   private function validation($category_table = 'advert')
   {
      $rules = $this->valid_rules($category_table);
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() === true)
      {
         foreach ($rules as $i) 
         {
            self::$data['post'][$i['field']] = set_value($i['field']);
         }  
         
         self::$data['post']['meta_title'] = mb_substr(self::$data['post']['title'],0,200);
         self::$data['post']['meta_description'] = mb_substr(self::$data['post']['text'],0,200);
         self::$data['post']['meta_keywords'] = mb_substr(preg_replace('/[\s\.\;\"\:^\,]+/',',',self::$data['post']['text']),0,200);
         return true;
      }else return false;
   }
   
   public function del($category_table = 'advert', $advert_id = 0)
	{
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      preg_match("/^([0-9]){1,20}$/", $advert_id) || show_error($this->lang->line('Invalid parameter'));
      $q = $this->db ->where($category_table.'_id',(int)$advert_id)
                     ->get($category_table);
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
      $this->db->where($category_table.'_id',$advert_id)->limit(1)->delete('advert');
      
      redirect("adm/advert/index/$category_table");
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
               self::$data['post']['img'][] = $upldata['file_name'];
               $counter ++;
            }
         }
      }
      if(isset(self::$data['post']['img']) && !empty(self::$data['post']['img']))
      {
         ksort(self::$data['post']['img']);
         self::$data['post']['logo'] = current(self::$data['post']['img']);
         self::$data['post']['img'] = serialize(self::$data['post']['img']);
      }
      else 
      {
         self::$data['post']['logo'] = '';
         self::$data['post']['img'] = '';
      }
   }  
   
   private function _img_del()
   {
      $img = self::$data['post']['img'];
      if( is_array($img) && !empty($img) )
      {
         $post_img_del = $this->input->post('img_del');
         if(is_array($post_img_del) && !empty($post_img_del))
         {
            foreach($post_img_del as $i)
            {
               if(preg_match('/^[0-9]{1,10}$/',$i) && isset($img[$i]))
               {
                  $path = "./upload/img/{$img[$i]}";
                  if(file_exists($path)) @unlink($path);
                  unset($img[$i]);
               }
            }  
         }
      }
      self::$data['post']['img'] = $img;
   }
   
   private function _img_sort()
   {
      $img = self::$data['post']['img'];
      if( is_array($img) && !empty($img) )
      {
         $post_img_sort = $this->input->post("img_sort");
         if(is_array($post_img_sort) && !empty($post_img_sort))
         {
            foreach($post_img_sort as $a=>$i)
            {
               if(preg_match('/^[0-9]{1,10}$/',$a) && preg_match('/^[0-9]{1,10}$/',$i))
               {
                  if($a != $i)
                  {
                     if(isset($img[$i])){
                        $v = $img[$a];
                        $img[$a] = $img[$i];
                        $img[$i] = $v;
                     }else{
                        $img[$i] = $img[$a];
                        unset($img[$a]);
                     }
                  }
               }
            }            
         }
      }
      self::$data['post']['img'] = $img;
   }
   
   function in_list($category_table = 'advert')
   {
      in_array($category_table,$this->config->item('category_tables')) || show_error("Invalid parameter");
      $upd = array(); 
      if(isset($_POST['status']) && !empty($_POST['status']))
      {
         $status = $this->input->post('status');
         foreach($status as $a=>$i)
         {
            if(preg_match('/^[0-9]{1,20}$/',$a) && preg_match('/^[0-9]$/',$i))
            {
               $upd[]=array($category_table.'_id'=>$a, 'status'=>$i);
            }
         }
         if(!empty($upd))
         {
            $this->db->update_batch($category_table, $upd, $category_table.'_id');
         }
      }
      
      if(isset($_POST['del']) && !empty($_POST['del']))
      {
         $del = $this->input->post('del');
         $wherein = array();
         foreach($del as $i)
         {
            if(preg_match('/^[0-9]{1,20}$/',$i))
            {
               $wherein[] = $i;
            }
         }
         if(!empty($wherein))
         {
            $sql = "DELETE FROM ".$this->db->dbprefix($category_table)." WHERE {$category_table}_id IN ? ";
            $this->db->query($sql, array($wherein));
         }
      }
      
      redirect("adm/advert/index/$category_table");
   }
   
   
   function valid_rules($category_table = 'advert')
   {
      if($category_table == 'advert') 
      {
         return array(
            array('field' => 'category_id',   'label' => $this->lang->line('Category'), 'rules' => 'trim|required|is_natural|max_length[6]|check_category'),
            array('field' => 'title',         'label' => $this->lang->line('Title'),    'rules' => 'trim|required|max_length[512]'),
            array('field' => 'text',          'label' => $this->lang->line('Text'),     'rules' => 'trim|required|max_length[2048]'),
            array('field' => 'contacts',      'label' => $this->lang->line('Contacts'), 'rules' => 'trim|max_length[512]'),
            array('field' => 'price',         'label' => $this->lang->line('Price'),    'rules' => 'trim|max_length[20]|price'),
            array('field' => 'enabled',       'label' => $this->lang->line('Enabled'),  'rules' => 'trim|is_natural|max_length[1]')
         );
      }
      
      if($category_table == 'organization')
      { 
         return array(
            array('field' => 'category_id',   'label' => $this->lang->line('Category'), 'rules' => 'trim|required|is_natural|max_length[6]|check_category'),
            array('field' => 'title',         'label' => $this->lang->line('Title'),    'rules' => 'trim|required|max_length[512]'),
            array('field' => 'text',          'label' => $this->lang->line('Text'),     'rules' => 'trim|required|max_length[2048]'),
            array('field' => 'contacts',      'label' => $this->lang->line('Contacts'), 'rules' => 'trim|max_length[512]'),
            array('field' => 'enabled',       'label' => $this->lang->line('Enabled'),  'rules' => 'trim|is_natural|max_length[1]')
         );
      }
      
      if($category_table == 'news') 
      {
         return array(
            array('field' => 'category_id',   'label' => $this->lang->line('Category'), 'rules' => 'trim|required|is_natural|max_length[6]|check_category'),
            array('field' => 'title',         'label' => $this->lang->line('Title'),    'rules' => 'trim|required|max_length[512]'),
            array('field' => 'text',          'label' => $this->lang->line('Text'),     'rules' => 'trim|required|max_length[2048]'),
            array('field' => 'enabled',       'label' => $this->lang->line('Enabled'),  'rules' => 'trim|is_natural|max_length[1]')
         );
      }
   }
}