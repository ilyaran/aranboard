<?php
if (isset($this->db))
{ 
   $statics = $this->db->where('display',1)->order_by('sort','ASC')->get('page')->result_array();
   if(!empty($statics))
   {
      foreach($statics as $i)
      {   
         echo '<li><a href="'.site_url('home/statics/'.$i['page_id']).'">'.$i['title'].'</a></li>';  
      }
   }
}
?>