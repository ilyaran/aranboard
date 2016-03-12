<?php defined('BASEPATH') || exit('No direct script access allowed');

class Install extends CI_Controller {
   public function __construct()
   {
      parent::__construct();
      
      $this->load->helper(array('file','url','string'));
      $this->load->config('board');
      $this->load->config('board_admin');
      $this->load->library('Lib_tree');
      $this->load->model('mdl_category');
      $this->load->library('Form_validation');
        
	}
   
   public function index($lang = 'en')
   {
      $lang_codes = array('English' => 'en', 'Russian' => 'ru', 'Chinese (Simplified)' => 'zh-CN', 'Chinese (Traditional)' => 'zh-TW', 'Korean' => 'ko', 'Hindi' => 'hi', 'French' => 'fr', 'Italian' => 'it', 'Spanish' => 'es', 'Portuguese (Brazil)' => 'pt-BR', 'Portuguese (Portugal)' => 'pt-PT', 'Kazakh' => 'kz', 'Swedish' => 'sv', 'Dutch' => 'nl', 'German' => 'de', 'Arabic' => 'ar', 'Bulgarian' => 'bg', 'Czech' => 'cs', 'Filipino' => 'fil', 'Norwegian' => 'no', 'Polish' => 'pl', 'Vietnamese' => 'vi', 'Romanian' => 'ro', 'Gujarati' => 'gu', 'Hungarian' => 'hu', 'Indonesian' => 'id', 'Japanese' => 'ja', 'Slovak' => 'sk', 'Tamil' => 'ta', 'Thai' => 'th', 'Turkish' => 'tr','Urdu' => 'ur' );
      preg_match('/^[a-z\-]{2,5}$/ui', $lang) || show_error('Invalid language parameter');
      $this->config->set_item('language','en');
      foreach($lang_codes as &$l)
      {
         if($l == $lang)
         {
            $this->config->set_item('language',$l);
            $data['html_lang'] = $l;
            break;
         }
      }
      
      $data['lang_codes'] =& $lang_codes; 
      $data['connection_result'] = '';
      $this->lang->load('app');
      if ($this->config->item('base_url') != '')
      {
         if(!empty($_POST)) 
         {
            $rules = array(
               array('field' => 'language',   'label' => $this->lang->line('Language'),   'rules' => 'trim|required|alpha_dash|max_length[6]'),
               //array('field' => 'base_url',   'label' => $this->lang->line('Base Url'),   'rules' => 'trim|required|valid_url|max_length[255]'),
               //array('field' => 'index_page', 'label' => $this->lang->line('Index page'), 'rules' => 'trim|required|max_length[255]'),
               //array('field' => 'email',      'label' => $this->lang->line('Email'),      'rules' => 'trim|required|valid_email|max_length[255]'),      
               array('field' => 'hostname',   'label' => $this->lang->line('Host name'),  'rules' => 'trim|required|max_length[255]'),
               array('field' => 'username',   'label' => $this->lang->line('User Name'),  'rules' => 'trim|required|alpha_dash|max_length[255]'),
               array('field' => 'password',   'label' => $this->lang->line('Password'),   'rules' => 'trim|alpha_dash|max_length[255]'),
               array('field' => 'database',   'label' => $this->lang->line('Data Base Name'), 'rules' => 'trim|required|alpha_dash|max_length[255]'),
            );
               
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() === true)
            {
               unset($this->db);
               $dsn = 'mysqli://'.set_value('username').':'.set_value('password').'@'.set_value('hostname').'/'.set_value('database');
               $this->load->database($dsn);
               if (is_resource($this->db->conn_id) || is_object($this->db->conn_id))
               {
                  $this->load->database($dsn);

                  $data['connection_result'] = '<p style="color:green;">Ok!</p>';
                  
                  //$this->config->set_item('base_url',set_value('base_url'));
            
                  $string = $this->load->view('Install/templates/config/routes','',true);
                  $this->save_to_files($string, APPPATH.'config','routes');
                     
                  $string = $this->load->view('Install/templates/config/database','',true);
                  $this->save_to_files($string, APPPATH.'config','database');
                  
                  $string = $this->load->view('Install/templates/config/config','',true);
                  $this->save_to_files($string, APPPATH.'config','config');

                  redirect('install/start');
                         
               }
               else
               {
                  $data['connection_result'] = '<p class="error">Connection Failed!</p>';
               }
            }
         }
      }
      $this->load->view('Install/install_view',$data);
   }
   
   public function start()
   {
      $this->load->database();
      $prefix = $this->db->dbprefix('test');
      $prefix = substr($prefix,0,-4);
      $email = 'your@email.com';
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."advert`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."category`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."news`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."organization`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."page`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."captcha`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."login_attempts`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."permissions`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."roles`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."search`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."users`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."user_autologin`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."user_profile`");
      $this->db->query("DROP TABLE IF EXISTS `".$prefix."user_temp`");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."advert` (
        `advert_id` int(11) NOT NULL AUTO_INCREMENT,
        `category_id` int(11) NOT NULL DEFAULT '0',
        `author` varchar(255) DEFAULT NULL,
        `price` float(20,2) DEFAULT NULL,
        `title` varchar(512) DEFAULT NULL,
        `text` text,
        `contacts` varchar(2048) DEFAULT NULL,
        `created` int(11) NOT NULL,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `expire` int(11) NOT NULL,
        `logo` varchar(255) NOT NULL,
        `img` text NOT NULL,
        `views` int(11) NOT NULL,
        `meta_keywords` varchar(200) NOT NULL,
        `meta_description` varchar(200) NOT NULL,
        `meta_title` varchar(200) NOT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT '1',
        `comment_allow` tinyint(1) NOT NULL DEFAULT '1',
        `highlight` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''free-0'', ''inline-1'',''top-2''',
        `noticesms` tinyint(1) NOT NULL,
        `noticeday` tinyint(1) NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - nonchecked, 1 - checked, 2 - doubtful',
        PRIMARY KEY (`advert_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;");

      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."captcha` (
        `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
        `captcha_time` int(10) unsigned NOT NULL,
        `ip_address` varchar(16) NOT NULL DEFAULT '0',
        `word` varchar(20) NOT NULL,
        PRIMARY KEY (`captcha_id`),
        KEY `word` (`word`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=612 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."category` (
        `category_id` int(11) NOT NULL AUTO_INCREMENT,
        `level` tinyint(3) NOT NULL DEFAULT '1',
        `category_table` varchar(64) NOT NULL DEFAULT 'advert',
        `name` varchar(255) DEFAULT NULL,
        `parent` int(11) DEFAULT '0',
        `sort` smallint(4) NOT NULL DEFAULT '1',
        `params` text,
        `description` text,
        `logo` varchar(255) DEFAULT NULL,
        `items_count` int(11) DEFAULT '0',
        `enabled` tinyint(1) DEFAULT '1',
        `meta_title` varchar(200) DEFAULT NULL,
        `meta_keywords` varchar(200) DEFAULT NULL,
        `meta_description` varchar(200) DEFAULT NULL,
        PRIMARY KEY (`category_id`),
        UNIQUE KEY `category_id` (`category_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."login_attempts` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
        `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."news` (
        `news_id` int(11) NOT NULL AUTO_INCREMENT,
        `category_id` int(11) NOT NULL,
        `author` varchar(512) NOT NULL,
        `title` varchar(512) NOT NULL,
        `text` text NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT '0',
        `created` int(11) NOT NULL,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `expire` int(11) NOT NULL,
        `logo` varchar(255) NOT NULL,
        `img` text NOT NULL,
        `meta_title` varchar(200) NOT NULL,
        `meta_keywords` varchar(200) NOT NULL,
        `meta_description` varchar(200) NOT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT '1',
        PRIMARY KEY (`news_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."organization` (
        `organization_id` int(11) NOT NULL AUTO_INCREMENT,
        `category_id` int(11) NOT NULL DEFAULT '0',
        `author` varchar(255) DEFAULT NULL,
        `title` varchar(512) DEFAULT NULL,
        `text` varchar(2048) DEFAULT NULL,
        `contacts` varchar(1024) DEFAULT NULL,
        `status` tinyint(1) NOT NULL DEFAULT '0',
        `created` int(11) NOT NULL,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `expire` int(11) NOT NULL,
        `logo` varchar(255) NOT NULL,
        `img` text NOT NULL,
        `views` int(11) NOT NULL,
        `meta_keywords` varchar(200) NOT NULL,
        `meta_description` varchar(200) NOT NULL,
        `meta_title` varchar(200) NOT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT '1',
        `highlight` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''free-0'', ''inline-1'',''top-2''',
        PRIMARY KEY (`organization_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."page` (
        `page_id` int(11) NOT NULL AUTO_INCREMENT,
        `page_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `title` varchar(512) DEFAULT NULL,
        `body` text,
        `sort` tinyint(4) DEFAULT NULL,
        `url` varchar(512) NOT NULL,
        `display` tinyint(1) NOT NULL DEFAULT '0',
        `page_clicks` int(11) NOT NULL,
        `meta_title` varchar(200) DEFAULT NULL,
        `meta_keywords` varchar(200) DEFAULT NULL,
        `meta_description` varchar(200) DEFAULT NULL,
        PRIMARY KEY (`page_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
            
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."permissions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `role_id` int(11) NOT NULL,
        `data` text COLLATE utf8_bin,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."roles` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `parent_id` int(11) NOT NULL DEFAULT '0',
        `name` varchar(30) COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."search` (
        `id` smallint(6) NOT NULL AUTO_INCREMENT,
        `word` varchar(64) NOT NULL DEFAULT '',
        `count` smallint(5) NOT NULL DEFAULT '0',
        `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=12 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."sessions` (
        `id` varchar(40) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
        `data` blob NOT NULL,
        PRIMARY KEY (`id`),
        KEY `ci_sessions_timestamp` (`timestamp`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `role_id` int(11) NOT NULL DEFAULT '1',
        `username` varchar(25) COLLATE utf8_bin NOT NULL,
        `password` varchar(34) COLLATE utf8_bin NOT NULL,
        `email` varchar(100) COLLATE utf8_bin NOT NULL,
        `banned` tinyint(1) NOT NULL DEFAULT '0',
        `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
        `newpass` varchar(34) COLLATE utf8_bin DEFAULT NULL,
        `newpass_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
        `newpass_time` datetime DEFAULT NULL,
        `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
        `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."user_autologin` (
        `key_id` char(32) COLLATE utf8_bin NOT NULL,
        `user_id` mediumint(8) NOT NULL DEFAULT '0',
        `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
        `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
        `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`key_id`,`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
            
      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."user_profile` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
        `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;");

      $this->db->query("CREATE TABLE IF NOT EXISTS `".$prefix."user_temp` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) COLLATE utf8_bin NOT NULL,
        `password` varchar(34) COLLATE utf8_bin NOT NULL,
        `email` varchar(100) COLLATE utf8_bin NOT NULL,
        `activation_key` varchar(50) COLLATE utf8_bin NOT NULL,
        `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");

      $this->db->query("INSERT INTO `".$prefix."category` (`category_id`, `level`, `category_table`, `name`, `parent`, `sort`, `params`, `description`, `logo`, `items_count`, `enabled`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
         (227, 1, 'organization', 'Construction', 0, 1, NULL, 'fdfdgbdx dgffcvjcv', '14343111926662.jpg', 0, 1, 'Construction', 'fdfdgbdx,dgffcvjcv', 'fdfdgbdx dgffcvjcv'),
         (228, 1, 'organization', 'Transport and Logistics', 0, 2, NULL, 'xcxcf gfgc gh', '14343113068588.jpg', 0, 1, 'Transport and Logistics', 'xcxcf,gfgc,gh', 'xcxcf gfgc gh'),
         (229, 1, 'advert', 'Real Estate', 0, 10, NULL, 'AsdaS ASdcaS aSDC', '14356540843853.jpg', 0, 1, 'Real Estate', 'AsdaS,ASdcaS,aSDC', 'AsdaS ASdcaS aSDC'),
         (235, 1, 'advert', 'Food Store', 0, 50, NULL, '', '14356546224435.jpg', 0, 1, 'Food Store', '', ''),
         (236, 1, 'advert', 'Furniture', 0, 70, NULL, '', '1435654727023.jpg', 0, 1, 'Furniture', '', ''),
         (237, 1, 'advert', 'Clothes and Shoes', 0, 80, NULL, '', '14356548596286.jpg', 0, 1, 'Clothes and Shoes', '', ''),
         (239, 1, 'advert', 'Transport', 0, 43, NULL, '', '14356543684847.jpg', 0, 1, 'Transport', '', ''),
         (242, 1, 'advert', 'Business', 0, 45, NULL, '', '14356544552755.jpg', 0, 1, 'Business', '', ''),
         (262, 2, 'advert', 'Men', 237, 0, NULL, '', '14356549907007.jpg', 0, 1, 'Men', '', ''),
         (263, 2, 'advert', 'Women', 237, 0, NULL, '', '14356550126051.jpg', 0, 1, 'Women', '', ''),
         (264, 2, 'advert', 'Hotels', 229, 10, NULL, '', '14356553432283.jpg', 0, 1, 'Hotels', '', ''),
         (265, 2, 'advert', 'Apartments', 229, 20, NULL, 'xdfvxdf zdfvdzf', '14356553875132.jpg', 0, 1, 'Apartments', 'xdfvxdf,zdfvdzf', 'xdfvxdf zdfvdzf'),
         (266, 2, 'advert', 'Cottages', 229, 30, NULL, '', '14356554593836.jpg', 0, 1, 'Cottages', '', ''),
         (267, 2, 'advert', 'Offices', 229, 50, NULL, '', '14356555870846.jpg', 0, 1, 'Offices', '', ''),
         (268, 2, 'advert', 'Cafe', 235, 0, NULL, '', '14356556541788.jpg', 0, 1, 'Cafe', '', ''),
         (269, 3, 'advert', 'Bistro', 268, 10, NULL, '', '14356574459948.jpg', 0, 1, 'Bistro', '', ''),
         (270, 2, 'advert', 'Electronic', 242, 10, NULL, '', '14356581930217.jpg', 0, 1, 'Electronic', '', ''),
         (271, 3, 'advert', 'SmartPhones', 270, 0, NULL, '', '14356582255547.jpg', 0, 1, 'SmartPhones', '', ''),
         (272, 4, 'advert', 'Gadgets', 271, 10, NULL, '', '14356586540781.jpg', 0, 1, 'Gadgets', '', ''),
         (273, 1, 'organization', 'Cleanning', 0, 60, NULL, '', '14356808669147.jpg', 0, 1, 'Cleanning', '', ''),
         (274, 2, 'advert', 'Children', 237, 30, NULL, '', '14357287298322.jpg', 0, 1, 'Children', '', ''),
         (275, 1, 'organization', 'IT', 0, 50, NULL, '', '14357288052739.jpg', 0, 1, 'IT', '', ''),
         (277, 1, 'advert', 'Test project ff', 0, 1, NULL, '', '14358974133394.jpg', 0, 0, 'Test project ff', '', ''),
         (278, 1, 'advert', 'Test Category', 0, 10, NULL, '', '14358974984717.jpg', 0, 0, 'Test Category', '', ''),
         (279, 2, 'organization', 'Design', 275, 0, NULL, 'sadfsdfzffa erer  erwer', '14359196112589.jpg', 0, 1, 'Design', 'sadfsdfzffa,erer,erwer', 'sadfsdfzffa erer  erwer'),
         (281, 1, 'news', 'Economics', 0, 10, NULL, 'sdfvzsd zsdvvsd', '14359204185679.jpg', 0, 1, 'Economics', 'sdfvzsd,zsdvvsd', 'sdfvzsd zsdvvsd'),
         (283, 2, 'news', 'Finance', 281, 10, NULL, 'Finance is good thing', '14359235213496.jpg', 0, 1, 'Finance', 'Finance,is,good,thing', 'Finance is good thing'),
         (284, 1, 'news', 'People', 0, 20, NULL, 'News from people life', '1435935689734.jpg', 0, 1, 'People', 'News,from,people,life', 'News from people life'),
         (285, 2, 'news', 'Events and', 284, 0, NULL, '', '1435935742398.jpg', 0, 1, 'Events and', '', '');");

      $this->db->query("INSERT INTO `".$prefix."roles` (`id`, `parent_id`, `name`) VALUES (1, 0, 'User'),(2, 0, 'Admin');");

      $this->db->query("INSERT INTO `".$prefix."users` (`id`, `role_id`, `username`, `password`, `email`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login`, `created`, `modified`) VALUES
         (1, 2, 'admin', '\$1\$9E/.c9/.\$uFjyNj4giMjPYaG63JEJL.', '{$email}', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2015-06-30 19:33:18', '2008-11-30 04:56:32', '2015-06-30 15:33:18'),
         (2, 1, 'user', '\$1\$bO..IR4.\$CxjJBjKJ5QW2/BaYKDS7f.', 'user@localhost.com', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2008-12-01 14:04:14', '2008-12-01 14:01:53', '2008-12-01 09:04:14');");

      $this->mdl_category->create_menu_vertical();
      $this->mdl_category->create_menu_vertical_organizations();
      $this->mdl_category->create_indexpage_category_list();
      $this->mdl_category->create_options('advert');
      $this->mdl_category->create_menu_vertical_news();
      $this->mdl_category->create_breadcrumb();  
      

      $string = $this->load->view('Adm/Settings/templates/views/header','',true);
      $this->save_to_files($string, APPPATH.'views','header');               

      $string = $this->load->view('Adm/Settings/templates/views/footer','',true);
      $this->save_to_files($string, APPPATH.'views','footer');
               
      $path = APPPATH.'controllers/Install.php';
      if(file_exists($path)) unlink($path);         
      
      redirect('admin');

   }
   
   private function save_to_files($string='', $path='', $filename = '')
   {
      return write_file("$path/{$filename}.php", $string) ? true : false;
   }
	
}
