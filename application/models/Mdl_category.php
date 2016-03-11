<?php defined('BASEPATH') || exit('No direct script access allowed');
class Mdl_category extends CI_Model {
   static $current_category = array();
   static $category_parents = array();
   static $category_children = array();
   
   public $category_table = 'advert';
   public $app_path;
   public function __construct()
   {
      parent::__construct();
      //$this->lib_tree->enabled = true;
      $this->load->helper('url');
      $this->load->helper('file');
      //$this->init($this->category_table);
      $this->app_path = substr(strrchr(substr(APPPATH,0,-1),DIRECTORY_SEPARATOR),1);
   }
   
   public function create_options($category_table = 'advert')
	{
      ob_start();
      $this->lib_tree->options($category_table,true);
      $string = ob_get_contents();
      ob_end_clean();
      $this->save_to_files($string,'./'.$this->app_path.'/views/Widgets/category','options');
	}
   
   public function create_menu_vertical($uri = 'home/catalog/')
	{
      $this->category_table = 'advert';
      $this->lib_tree->uri = 'home/catalog/';
      $this->lib_tree->enabled = true;
      ob_start();
      $this->lib_tree->menu_vertical();
      $string = ob_get_contents();
      ob_end_clean();
      $this->save_to_files($string,'./'.$this->app_path.'/views/Widgets/category','menu_vertical');
   }
   
   public function create_menu_vertical_organizations()
	{
      $string = '<div class="panel panel-default">
            <div class="panel-heading" style="word-break: break-all;"><a href="'.site_url('home/organizations').'">'.$this->lang->line('Organizations').'</a>
            &nbsp;<input type="radio" value="organization" name="category_table" />
            </div>
            <div class="panel-body">
               <ul style="padding:5px">';
      ob_start();
      $this->lib_tree->menu_vertical_organizations('home/organizations/', true);
      $string .= ob_get_contents();
      ob_end_clean();
      $string .= '</ul>
            </div>
          </div> ';
      $this->save_to_files($string,'./'.$this->app_path.'/views/Widgets/category','menu_vertical_organization');
   }
   
   public function create_menu_vertical_news()
	{
      $string = '<div class="panel panel-default">
            <div class="panel-heading" style="word-break: break-all;">
            <a href="'.site_url('home/news').'">'.$this->lang->line('News').'</a>
            &nbsp;<input type="radio" value="news" name="category_table" />
            </div>
            <div class="panel-body">
               <ul style="padding:5px">';
      ob_start();
      $this->lib_tree->menu_vertical_news('home/news/', true);
      $string .= ob_get_contents();
      ob_end_clean();
      $string .= '</ul>
            </div>
          </div> ';
      $this->save_to_files($string,'./'.$this->app_path.'/views/Widgets/category','menu_vertical_news');
   }
   
   public function create_indexpage_category_list()
   {
      $this->lib_tree->category_table = 'advert';
      $this->lib_tree->uri = 'home/catalog/';
      $this->lib_tree->enabled = true;
      $this->lib_tree->init();
      CI_Controller::$data['categories'] = $this->lib_tree->categories;
      
      $string = $this->load->view('Adm/Widgets/category/indexpage_category_list','',true);
      
      $this->save_to_files($string,'./'.$this->app_path.'/views/Widgets/category','indexpage_category_list');
   
   }

   public function create_breadcrumb()
	{
      $all_category = $this->db->where('enabled','1')->get('category')->result_array();
      if(empty($all_category))return false;
      $string = "<?php defined('BASEPATH') || exit('No direct script access allowed'); \n";
      foreach($all_category as $i)
      {
         $this->get_category($i['category_id'],true);
         
         $string .= "\$config['category_id_{$i['category_id']}']['parents']= array(";
         foreach(self::$category_parents as $s)
         {
            $string .= "array('name'=>'{$s['name']}','category_id'=>{$s['category_id']}),\n";
         }
         $string .= ");\n";
         
         $string .= "\$config['category_id_{$i['category_id']}']['children']= array(";
         foreach(self::$category_children as $v)
         {
            $string .= "array('name'=>'{$v['name']}','category_id'=>{$v['category_id']}),\n";
         }
         $string .= ");\n";
         
         $string .= "\$config['category_id_{$i['category_id']}']['current']= array(
         'name'=>'".self::$current_category['name']."', 
         'category_id'=>".self::$current_category['category_id'].",'level'=>{$i['level']},
         'category_table'=>'{$i['category_table']}',
          );\n";
      }
      $this->save_to_files($string,'./'.$this->app_path.'/config','breadcrumb');
   
	}
   
   public function save_to_files($string='', $path='', $filename = 'breadcrumb')
   {
      if (!copy("$path/{$filename}.php", "./".$this->app_path."/backup_files/{$filename}_copy.php"))
         return false;
      if ( !write_file("$path/{$filename}.php", $string))
      {
         if (!copy("./".$this->app_path."/backup_files/{$filename}_copy.php", "$path/{$filename}.php"))
            return false;
      }
      return true;
   }
   
     /**
	 * Category File
	 * 
	 * Set static variables $current_category, $category_parents, $category_children
	 * @param	integer	$category_id
	 * If no such category it returns false
    * @return boolean	
    * 
	 */
   function get_category($category_id = 0, $enabled = false)
   {    
      if($category_id==0)return false;
      $this->db->where('category_id', $category_id);
      if($enabled) $this->db->where('enabled','1');
      $this->db->limit(1);
      $q = $this->db->get('category');
      if($q->num_rows() == 0) return false;  
      self::$current_category = $q->row_array();
      
      if($enabled) $this->db->where('enabled','1');
      $all_category = $this->db->get('category')->result_array();
      
      if( empty($all_category) ) return false;
      $parents = function($item,$item_key='parent',$i_key='category_id') use ($all_category)
      {
         foreach ($all_category as &$i)
         {
            if($item[$item_key] == $i[$i_key]) return $i;
         }
         return false;
      };
      
      $i = $parents(self::$current_category); $b=array();
      while($i != false){ $b[] = $i; $i = $parents($i); };
      self::$category_parents = array_reverse($b);
      
      $children = function($p,$item_key='category_id',$i_key='parent') use ($all_category){
         $c = array();
         foreach($p as $item)
         {
            foreach ($all_category as &$i)
            {
               if($item[$item_key] == $i[$i_key]) $c[] = $i;
            }  
         }
         if(empty($c)) return false;
         return $c;
      };
      
      $i = $children(array(self::$current_category),'category_id','parent'); $b = array();
      while($i != false){ $b = array_merge($b, $i); $i = $children($i,'category_id','parent'); };
      self::$category_children = &$b;
      return true;
   }
   
}