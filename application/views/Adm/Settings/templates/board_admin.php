<?php echo '<?php  defined(\'BASEPATH\') || exit(\'No direct script access allowed\');';?>

$config['category_tables']	= array('advert','organization','news');
$config['theme_public']	= '<?php echo $this->config->item('theme_public'); ?>';
$config['logo_name']	= '<?php echo $this->config->item('logo_name'); ?>';
$config['theme']	= 'themes/bootstrap/';
$config['per_page'] = 50;
$config['num_links'] = 20;   

$config['img_max_size']    = 2000;
$config['img_max_width']   = 2000;
$config['img_max_height']  = 2000;
$config['num_img']	      = 24;
$config['img_normal']  = array(800,600);
