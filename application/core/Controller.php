<?php defined('BASEPATH') || exit('No direct script access allowed');
class CI_Controller {
	private static $instance;

   public static $userid           = 0;
	public static $username         = '';

   public static $dbtable          = 'advert';
   public static $meta_title       = '';
   public static $meta_description = '';
   public static $meta_keywords    = '';
   public static $data             = array();
   
   public static $breadcrumb       = array();
   
   public static $paging           = '';
   public static $sql              = '';
   public static $all              = 0;
   
   static $last_q = '';
   
  	public function __construct()
	{
		self::$instance =& $this;
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}
   
	public static function &get_instance()
	{
		return self::$instance;
	}
   
   public function get_list ($page=0,$sort='id asc')
   {
      if(self::$sql != '')
      {
         $this->db->start_cache();
         $this->db->where(self::$sql);
         $this->db->stop_cache();
      }
      self::$all = $this->db->count_all_results(self::$dbtable);
      
      $this->db->order_by($sort);
      $this->db->limit($this->config->item('per_page'),$page);
      $query = $this->db->get(self::$dbtable);
      if(self::$sql != '') $this->db->flush_cache();
      if($query->num_rows() > 0) self::$data[self::$dbtable] = $query->result_array();
   }
    
   public function set_paging($page=0, $attr_value='', $attr='href')
   {  
      $config['total_rows'] = self::$all;
      $config['active'] = $page;
      $config['per_page'] = $this->config->item("per_page");
      $config['attr'] = $attr;
      $config['attr_value'] = $attr_value;
      $this->load->library('Lib_paging',$config);
      self::$paging = $this->lib_paging->create_links();
   }

}
