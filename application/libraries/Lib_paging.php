<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Lib_paging Class for Aran eboard CMS
 *
 * Pagination library.
 *
 * @author		Ilyas Toxanbayev  (penname Ilya Aranov)
 * @version		1.0.0
 * @based on	
 * @email      il.aranov@gmail.com
 * @link			http://iaran.org/
 * @github     https://github.com/ilyaran/Aran
 * @license		MIT License Copyright (c) 2015 Ilyas Toxanbayev
 */
class Lib_paging {
   
   static $active = 0; // 0  12  24  36  48  
   static $per_page = 12;
   static $num_links = 5;
   static $total_rows = 194;
   static $attr = 'onclick';
   static $attr_value = 'catalog/%s'; // if url is site.com/catalog/%s then $attr = 'href';
   static $use_page_numbers = true; 
   
   static $first_link = '<<';
   static $first_tag_open = '<li>';
   static $first_tag_close = '</li>';
   
   static $next_link = '&raquo;';
   static $next_tag_open   = '<li>';
   static $next_tag_close  = '</li>';
   
   static $prev_link = '&laquo;';
   static $prev_tag_open   = '<li>';
   static $prev_tag_close  = '</li>';
   
   
   static $last_link = '>>';
   static $last_tag_open   = '<li>';
   static $last_tag_close  = '</li>';
   
   
   static $cur_tag_open = '<li class="active"><a><b>';
   static $cur_tag_close = '</b></a></li>';
   
   static $num_tag_open    = '<li>';
   static $num_tag_close   = '</li>';
   
   static $tag_open = 'a';
   static $tag_close = '/a';
   //static $get_param = '?name=ilya&surname=aranov';
   public function __construct($params = array())
	{
		$this->init($params);
	}
   
   public function init($params = array())
   {
      if (!empty($params))
      {
         foreach ($params as $key => $val)
         {
            if (isset(self::$$key)) self::$$key = $val;
         }
      }
   }
   
   function create_links() 
   {  
      $total_pages = ceil( self::$total_rows / self::$per_page); //12345...102
      $active_page = floor(self::$active / self::$per_page)+1; // 123 <4> 5...102
      
      if($total_pages < 2 || $active_page > $total_pages) return null;
      
      $first_link = 0;
      $last_link = ($total_pages - 1)  * self::$per_page;
      $next_link = self::$active + self::$per_page;
      $prev_link = self::$active -  self::$per_page;
      
      if(self::$num_links > 0)
      {
         $left_side = floor(self::$num_links / 2); 
         $right_side = self::$num_links - $left_side - 1;
      }else return null;
      
      $out = '';

      $start = $active_page - floor(self::$num_links/2);
      if($start <= 1) $start = 1;
      else
      {
         $out .= self::$first_tag_open."<".self::$tag_open." ".self::$attr."=\"".sprintf(self::$attr_value,$first_link)."\">".self::$first_link."<".self::$tag_close.">".self::$first_tag_close;
         $out .= self::$prev_tag_open."<".self::$tag_open." ".self::$attr."=\"".sprintf(self::$attr_value,$prev_link)."\">".self::$prev_link."<".self::$tag_close.">".self::$prev_tag_close;
      }
      
      $end = $start + self::$num_links;
      if($end > $total_pages) $end = $total_pages;
      
      for($i = $start; $i <= $end; $i++)
      { 
         if($i == $active_page)
         {
            $out .= self::$cur_tag_open.$i.self::$cur_tag_close; 
            continue;
         }   
         $out .= self::$num_tag_open."<".self::$tag_open." ".self::$attr."=\"".sprintf(self::$attr_value, ($i - 1) * self::$per_page)."\">$i<".self::$tag_close.">".self::$num_tag_close;
      }
      
      if($start + self::$num_links < $total_pages )
      {
         $out .= self::$next_tag_open."<".self::$tag_open." ".self::$attr."=\"".sprintf(self::$attr_value,$next_link)."\">".self::$next_link."<".self::$tag_close.">".self::$next_tag_close;
         $out .= self::$last_tag_open."<".self::$tag_open." ".self::$attr."=\"".sprintf(self::$attr_value,$last_link)."\">".self::$last_link."<".self::$tag_close.">".self::$last_tag_close;
      }
      return $out;
   }
   
   private static function bootstrap_params($page=0)
   {
      $config = array(
         'num_links' => 9,
         'active'=>$page,
         'tag_open' => 'a',
         'tag_close' => '/a',
         'first_tag_open' => '<li>',
         'last_tag_open' => '<li>',
         'next_tag_open' => '<li>',
         'prev_tag_open' => '<li>',
         'num_tag_open' => '<li>',
         'first_tag_close' => '</li>',
         'last_tag_close' => '</li>',
         'next_tag_close' => '</li>',
         'prev_tag_close' => '</li>',
         'num_tag_close' => '</li>',
         'cur_tag_open' => '<li class="active"><a><b>',
         'cur_tag_close' => '</b></a></li>',
         'prev_link' => '&laquo;',
         'next_link' => '&raquo;',
         'last_link' => '>>',
         'first_link' => '<<'
      );
      $this->init($config);
      $this->create_links();
   }
}

?>