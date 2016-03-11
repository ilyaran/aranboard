<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Home Class for Aran eboard CMS
 *
 * Home library for Aran eboard CMS.
 *
 * @author		Ilyas Toxanbayev  (penname Ilya Aranov)
 * @version		1.0.0
 * @based on	
 * @email      il.aranov@gmail.com
 * @link			http://iaran.org/
 * @github     https://github.com/ilyaran/Aran
 * @license		MIT License Copyright (c) 2015 Ilyas Toxanbayev
 */
class Home extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->library('DX_Auth');
      $this->load->config('board');
      $this->load->config('breadcrumb');
      $this->load->helper('url');
      if ($this->dx_auth->is_logged_in())
      {
         self::$userid = $this->session->userdata('DX_user_id');
         self::$username = $this->session->userdata('DX_username');  
      }
	}
	
   public function index($static_page = 0)
	{
	   if($this->config->item('moderation') == 1)
      {
         $this->db->where('status',1);
      }
      $this->db->where('enabled',1);
      $this->db->limit(36);
      $this->db->order_by('created','DESC');
      $q = $this->db->get('advert');
      
      self::$data['advert'] = $q->result_array(); 
      
      $this->load->view('header');  
      $this->load->view('index');
      $this->load->view('footer');
	}
   
   public function statics($page_id = 0)
	{
	   preg_match("/^[0-9]{1,6}$/", $page_id) || show_error("Invalid Parameter"); 
      $q=$this->db->get_where('page',array('page_id'=>$page_id),1);
      $q->num_rows() > 0 || show_error('No such page!');
       
      self::$data['page'] = $q->row_array();
      
      $this->load->view('header');
      $this->load->view('statics');
      $this->load->view('footer');
	}
   
   public function category($category_table = 'advert', $category_id = 0)
   {
      preg_match("/^[0-9]{1,20}$/i", $category_id ) || show_error("Invalid Parameter");
      in_array($category_table,array('advert','news','organization')) || show_error("Invalid parameter");
      
      self::$data['category_id'] = $category_id;
      self::$breadcrumb = $this->config->item("category_id_$category_id");
      if(!empty(self::$breadcrumb))
      {
         if(!isset(self::$breadcrumb['parents'][0]['category_id']))$parent=0;else$parent=self::$breadcrumb['parents'][0]['category_id'];
         self::$data['categories'] = $this->db->where("`category_table` = '$category_table' AND `enabled` = 1 AND 
         ( `category_id` = $category_id OR `parent` = $parent OR `parent` = $category_id)")
                              ->order_by('sort','ASC')->get('category')->result_array();
      }
      else
      {
         if($category_id==0)
         {
            self::$data['categories'] = $this->db->where("`category_table` = '$category_table' AND `enabled` = 1 AND `level` = 1")
                                 ->order_by('sort','ASC')->get('category')->result_array();
         }
      }
      
      $this->load->view('header');
      $this->load->view('category');
      $this->load->view('footer');
   }
   
   public function advert($advert_id = 0) 
   {
      preg_match("/^[0-9]{1,20}$/", $advert_id) || show_error("Invalid Parameter"); 
      if($this->config->item('moderation') == 1)
      {
         $this->db->where('status',1);
      }
      $this->db->where('enabled',1);
      $this->db->where('advert_id',$advert_id);
      $this->db->limit(1);
      $q = $this->db->get('advert');
      $q->num_rows()>0 || show_error('No such advert!'); 
      $advert = $q->row_array();
      self::$data['img'] = @unserialize($advert['img']);
      
      self::$meta_title = $advert['meta_title'];
      self::$meta_keywords = $advert['meta_keywords'];
      self::$meta_description = $advert['meta_description'];
      
      self::$breadcrumb = $this->config->item("category_id_{$advert['category_id']}");
      self::$data['advert'] = &$advert;
      
      $this->load->view('header');
      $this->load->view('advert');
      $this->load->view('footer');
   }
   
   public function catalog($category_id = 0, $page = 0) 
   {
      preg_match("/^[0-9]{1,6}$/", $category_id ) || show_error("Invalid Parameter");
      preg_match("/^[0-9]{1,6}$/", $page ) || show_error("Invalid Parameter");
      if($this->config->item('moderation') == 1)
      {
         self::$sql .= ' `status` = 1 AND ';
      }
      self::$sql .= ' `enabled` = 1';
      
      self::$breadcrumb = $this->config->item("category_id_$category_id");
      if($category_id > 0 && !empty(self::$breadcrumb))
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
         else self::$sql .= "  AND `category_id` = $category_id";
      }
      
      $this->get_list ($page,'`created` DESC');
      $attr_value = site_url("home/catalog/$category_id/%s");
      $this->set_paging($page, $attr_value);
      
      $this->load->view('header');
      $this->load->view('catalog');
      $this->load->view('footer');
      //$this->output->cache(60);
   }

   public function ajax_catalog($category_table = 'advert', $page = 0) 
   {
      in_array($category_table,array('advert','news','organization')) || exit("Invalid parameter");
      $this->input->is_ajax_request() || exit("IT IS NOT AJAX");
      preg_match("/^[0-9]{1,6}$/i", $page ) || exit("Invalid Parameter");
      
      if($this->config->item('moderation') == 1)
      {
         self::$sql .= ' `status` = 1 AND ';
      }
      self::$sql .= ' `enabled` = 1 ';
      
      if(isset($_POST['search']) && preg_match('/^[a-zA-Zа-яА-Я0-9\,\.\-\(\)\[\]\@\#\$\%\!\&\~\`\s]{0,64}$/',$_POST['search']))
      {
         $search = $_POST['search'];
         if($search != '') 
         {
            if($category_table == 'news')
            {
               self::$sql .= " AND ( `title` LIKE '%$search%' ESCAPE '!' OR `text` LIKE '%$search%' ESCAPE '!')";
            }
            else self::$sql .= " AND ( `title` LIKE '%$search%' ESCAPE '!' OR `text` LIKE '%$search%' ESCAPE '!' OR `contacts` LIKE '%$search%' ESCAPE '!')";
         }  
      }
      $order = '`created` DESC';   
      if($category_table == 'advert')
      {
         if(isset($_POST['category_id']) && preg_match('/^[0-9]{1,6}$/',$_POST['category_id']))
         {
            $category_id = $_POST['category_id'];
            self::$breadcrumb = $this->config->item("category_id_$category_id");
            if($category_id > 0 && !empty(self::$breadcrumb))
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
         
         if(isset($_POST['price_from']) && preg_match('/^[0-9\.\,]{1,20}$/',$_POST['price_from']))
         {
            $price_from = (float)$_POST['price_from']; 
            if($price_from > 0) self::$sql .= " AND price > $price_from";
         }
         
         if(isset($_POST['price_to']) && preg_match('/^[0-9\,\.]{1,20}$/',$_POST['price_to']))
         {
            $price_to = (float) $_POST['price_to'];
            if($price_to > 0) self::$sql .= " AND price < $price_to";
         }
         
         if(isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
         {
            $sort = $_POST['sort'];
            if( $sort == 1 ) $order = '`price` ASC';
            if( $sort == 2 ) $order = '`price` DESC';
         }
      }
      
      if($order == '`created` DESC' && isset($_POST['sort']) && preg_match('/^([0-9]){1}$/',$_POST['sort'])) 
      {
         $sort = $_POST['sort'];
         if( $sort == 3 ) $order = '`title` ASC';
         if( $sort == 4 ) $order = '`title` DESC';
         if( $sort == 5 ) $order = '`updated` DESC';
         if( $sort == 6 ) $order = '`updated` ASC';
      }
      
      
      if(isset($_POST['per_page']) && preg_match('/^[0-9]{2,3}$/',$_POST['per_page'])) 
            $this->config->set_item('per_page', (int)$_POST['per_page']);
      self::$dbtable = $category_table;
      $this->get_list($page,$order);
      $this->set_paging($page,"catalog_list('%s')",'onclick');
      
      //self::$last_q = $this->db->last_query();
      
      header('Content-Type: text/html; charset=utf-8');
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
      
      $view = 'catalog';
      if($category_table == 'news') $view = 'news';
      if($category_table == 'organization') $view = 'organizations';
      
      $this->load->view($view);
   }

   public function organizations($category_id = 0, $page = 0) 
   {
      preg_match("/^[0-9]{1,6}$/", $category_id ) || show_error("Invalid Parameter");
      preg_match("/^[0-9]{1,6}$/", $page ) || show_error("Invalid Parameter");
      self::$dbtable = 'organization';
      self::$sql .= ' `enabled` = 1 ';
      
      self::$breadcrumb = $this->config->item("category_id_$category_id");
      if($category_id > 0 && !empty(self::$breadcrumb))
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
      
      $this->get_list ($page,'`created` ASC');
      $attr_value = site_url("home/organization/$category_id/%s");
      $this->set_paging($page, $attr_value);
      self::$last_q = $this->db->last_query();
      
      $this->load->view('header');
      $this->load->view('organizations');
      $this->load->view('footer');
      //$this->output->cache(60);
      
  
   }

   public function organization($organization_id = 0) 
   {
      preg_match("/^[0-9]{1,6}$/", $organization_id) || show_error("Invalid Parameter");
      
      $q=$this->db->get_where('organization',array('organization_id'=>$organization_id,'enabled'=>1),1);
      $q->num_rows()>0 || show_error('No such organization!'); 
      $org = $q->row_array();
      self::$data['img'] = @unserialize($org['img']);
      self::$meta_title = $org['meta_title'];
      self::$meta_keywords = $org['meta_keywords'];
      self::$meta_description = $org['meta_description'];
      
      self::$breadcrumb = $this->config->item("category_id_{$org['category_id']}");
      self::$data['organization'] = &$org;
      
      $this->load->view('header');
      $this->load->view('organization');
      $this->load->view('footer');
   }
   
   public function news($category_id = 0, $page = 0) 
   {
      preg_match("/^[0-9]{1,6}$/", $category_id ) || show_error("Invalid Parameter");
      preg_match("/^[0-9]{1,6}$/", $page ) || show_error("Invalid Parameter");
      self::$dbtable = 'news';
      self::$sql .= ' `enabled` = 1 ';
      
      self::$breadcrumb = $this->config->item("category_id_$category_id");
      if($category_id > 0 && !empty(self::$breadcrumb))
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
      
      $this->get_list ($page,'`created` ASC');
      $attr_value = site_url("home/news/$category_id/%s");
      $this->set_paging($page, $attr_value);
      self::$last_q = $this->db->last_query();
      
      $this->load->view('header');
      $this->load->view('news');
      $this->load->view('footer');
      //$this->output->cache(60);
      
  
   }

   public function news_item($news_id = 0) 
   {
      preg_match("/^[0-9]{1,6}$/", $news_id) || show_error("Invalid Parameter");
      $q = $this->db->get_where('news',array('news_id'=>$news_id,'enabled'=>1),1);
      $q->num_rows()>0 || show_error('No such news!'); 
      $news = $q->row_array();
      self::$data['img'] = @unserialize($news['img']);
      self::$meta_title = $news['meta_title'];
      self::$meta_keywords = $news['meta_keywords'];
      self::$meta_description = $news['meta_description'];
      
      self::$breadcrumb = $this->config->item("category_id_{$news['category_id']}");
      self::$data['news'] = &$news;
      
      $this->load->view('header');
      $this->load->view('news_item');
      $this->load->view('footer');
   }
   
}
