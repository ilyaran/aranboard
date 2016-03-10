<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Lib_tree Class for Aran eboard CMS
 *
 * Tree of categories library for Aran eboard CMS.
 *
 * @author		Ilyas Toxanbayev  (penname Ilya Aranov)
 * @version		1.0.0
 * @based on	
 * @email      il.aranov@gmail.com
 * @link			http://iaran.org/
 * @github     https://github.com/ilyaran/Aran
 * @license		MIT License Copyright (c) 2015 Ilyas Toxanbayev
 */
class Lib_tree {
   public $enabled = false;
   public $categories = array();
   public $category_table = 'advert';
   public $ci;
   public $uri = 'adm/advert/index/advert/';
   
   public function __construct()
	{
		$this->ci =& get_instance();
   }
   
   function init()
   {
      if($this->enabled) $this->ci->db->where('enabled',1);
      $this->ci->db->where('category_table',$this->category_table);
      $this->ci->db->order_by('sort ASC');
      $q=$this->ci->db->get('category');
      $this->categories = $q->result_array();
      return true;
   }
   
   function is_child($id){
      foreach($this->categories as $i) {
         if($i['parent'] == $id) return true;
      }
      return false;
   }
   
   //************** Menu vertical
   //*********************************
   
   function menu_vertical()
   {
      $this->init();
      if(isset($this->categories[0]))
      {
         foreach($this->categories as $i) 
         {
            if($i['level'] > 1) continue;
            $this->getView_menu($i);
            if($this->is_child($i['category_id'])) echo '<div id="sub_'.$i['category_id'].'" class="sub" style="display:none;">';
            $this->child_menu($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</div>';
         }
      }
   }
   
   function getView_menu($i) {
   if($this->is_child($i['category_id'])){ ?>
   
      <div class="row">
         <div onclick="$('#sub_<?php echo $i['category_id']; ?>').toggle(500)" class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <span class="accordion-toggle btn btn-primary">
               <img width="35" height="35" src="upload/logo/<?php echo $i['logo']=='' ? 'noimg.jpg' : $i['logo']; ?>"/>
            </span>
         </div>
         
         <div class="col-md-18 col-lg-18 col-sm-18 col-xs-18">
            <a class="btn btn-block btn-lg btn-info" href="<?php echo site_url($this->uri.$i['category_id']); ?>"><?php echo mb_substr($i['name'],0,12); ?></a>
         </div>
      </div>
   
   <?php }else{ ?>
   
      <div class="row">
         
         <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <span id="163" class="accordion-toggle btn btn-primary">
               <img width="35" height="35" src="upload/logo/<?php echo $i['logo']=='' ? 'noimg.jpg' : $i['logo']; ?>"/>
            </span>
         </div>
         
         <div class="col-md-18 col-lg-18 col-sm-18 col-xs-18">
            <a class="btn btn-block btn-lg btn-default" href="<?php echo site_url($this->uri.$i['category_id']); ?>"><?php echo mb_substr($i['name'],0,12); ?></a>
         </div>
      </div>
      
   <?php } 
    }
   
   function child_menu($level, $parent) {
      foreach($this->categories as $i) 
      {
         if($i['level'] > $level) continue;
         if($i['level'] == $level && $i['parent'] == $parent)
         {
            $this->getView_menu($i);
            if($this->is_child($i['category_id'])) echo '<div id="sub_'.$i['category_id'].'" class="sub" style="display:none;">';
            $this->child_menu($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</div>';
         }
      }
   }
   //************** End Menu vertical
   
   
   //************** Menu vertical organization
   //*********************************
   function menu_vertical_organizations($uri='adm/advert/index/organization/',$enabled=false)
   {
      $this->category_table = 'organization';
      $this->uri = $uri;
      $this->enabled = $enabled;
      $this->init();
      
      if(isset($this->categories[0]))
      {
         foreach($this->categories as $i) 
         {
            if($i['level'] > 1) continue;
            $this->getView_menu_organizations($i);
            if($this->is_child($i['category_id'])) echo '<ul>';
            $this->child_menu_org($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</ul>';
         }
      }
   }
   
   function getView_menu_organizations($i) {
      ?>
         
      <li><a href="<?php echo site_url($this->uri."{$i['category_id']}"); ?>"><?php echo $i['name']; ?></a></li>
   
   <?php      
      
   }
   
   function child_menu_org($level, $parent) {
      foreach($this->categories as $i) 
      {
         if($i['level'] > $level) continue;
         if($i['level'] == $level && $i['parent'] == $parent)
         {
            $this->getView_menu_organizations($i);
            if($this->is_child($i['category_id'])) echo '<ul>';
            $this->child_menu_org($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</ul>';
         }
      }
   }
   //************** End Menu vertical organization
   
   
   //************** Menu vertical organization
   //*********************************
   function menu_vertical_news($uri='adm/advert/index/news/',$enabled=false)
   {
      $this->category_table = 'news';
      $this->uri = $uri;
      $this->enabled = $enabled;
      $this->init();
      
      if(isset($this->categories[0]))
      {
         foreach($this->categories as $i) 
         {
            if($i['level'] > 1) continue;
            $this->getView_menu_news($i);
            if($this->is_child($i['category_id'])) echo '<ul>';
            $this->child_menu_news($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</ul>';
         }
      }
   }
   
   function getView_menu_news($i) {
      ?>
         
      <li><a href="<?php echo site_url($this->uri."{$i['category_id']}"); ?>"><?php echo $i['name']; ?></a></li>
   
   <?php      
      
   }
   
   function child_menu_news($level, $parent) {
      foreach($this->categories as $i) 
      {
         if($i['level'] > $level) continue;
         if($i['level'] == $level && $i['parent'] == $parent)
         {
            $this->getView_menu_news($i);
            if($this->is_child($i['category_id'])) echo '<ul>';
            $this->child_menu_news($i['level']+1, $i['category_id']);
            if($this->is_child($i['category_id']))echo '</ul>';
         }
      }
   }
   //************** End Menu vertical organization
   
   
   
   //************************* Options
   //***********************************
   
   function options($category_table = 'advert',$enabled = false)
   {
      $this->category_table = $category_table;
      $this->enabled = $enabled;
      $this->init();
      if(isset($this->categories[0]))
      {
         foreach($this->categories as $i) 
         {
            if($i['level'] > 1) continue;
            $this->getView_option($i);
            $this->child_option($i['level']+1, $i['category_id']);
         }
      }
   }
   
   function getView_option($i) { ?>
   
   <option value="<?php echo $i['category_id']; ?>"><?php echo str_repeat('&nbsp;', $i['level']*3).$i['name']; ?></option>
      
   <?php }
   
   function child_option($level, $parent) {
      foreach($this->categories as $i) 
      {
         if($i['level'] > $level) continue;
         if($i['level'] == $level && $i['parent'] == $parent)
         {
            $this->getView_option($i);
            $this->child_option($i['level']+1, $i['category_id']);
         }
      }
   }
   
   //************************* End Options
   
  
   
   
}?>