<?php echo '<?php  defined(\'BASEPATH\') || exit(\'No direct script access allowed\');';?>

$config['per_page'] = <?php echo set_value('per_page');?>;
$config['num_links'] = <?php echo set_value('num_links');?>;   

//$config['theme']	= 'themes/bootstrap/';

//$config['comment_recaptcha'] = true;
//$config['comment_enable'] = true;
//$config['comments_show'] = true;

$config['moderation']	   = <?php echo set_value('moderation');?>; // 0 - postmoder, 1 - premoder

//$config['path_upl']	      = 'upload';
$config['img_max_size']    = <?php echo set_value('img_max_size');?>;
$config['img_max_width']   = <?php echo set_value('img_max_width');?>;
$config['img_max_height']  = <?php echo set_value('img_max_height');?>;
$config['num_img']	      = <?php echo set_value('num_img');?>;

$config['img_normal']  = array(<?php echo set_value('img_normal_width');?>,<?php echo set_value('img_normal_height');?>);
//$config['img_middle']  = array(400,300);
//$config['img_small']  = array(150,150);