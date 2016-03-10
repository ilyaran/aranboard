<?php defined('BASEPATH') || exit('No direct script access allowed');
class Mdl_utils extends CI_Model {
   public function __construct()
   {
      parent::__construct();
      //$this->lib_tree->enabled = true;
      $this->load->helper('url');
      $this->load->helper('file');
      //$this->init($this->category_table);
      $this->app_path = substr(strrchr(substr(APPPATH,0,-1),DIRECTORY_SEPARATOR),1);
   }
   
   function dbbackup()
   {
      //*****************
      //***************** BackUp
      $this->load->dbutil();
      
      // Backup your entire database and assign it to a variable
      $backup =& $this->dbutil->backup();
      
      // Load the file helper and write the file to your server
      $this->load->helper('file');
      write_file(APPPATH.'backup_files/board_database_backup.gz', $backup);
      
      // Load the download helper and send the file to your desktop
      $this->load->helper('download');
      force_download('board_database_backup.gz', $backup);
      //***************** end BackUp
      //*****************
   }
   
}