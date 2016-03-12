<!DOCTYPE html>
<html lang="<?php echo '<?php echo $this->config->item(\'language\'); ?>'; ?>">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="keywords" content="<?php echo '<?php echo CI_Controller::$meta_keywords; ?>'; ?>"/>
<meta name="description" content="<?php echo '<?php echo CI_Controller::$meta_description; ?>'; ?>"/>
<title><?php echo '<?php echo CI_Controller::$meta_title; ?>'; ?></title>
<base href="<?php echo base_url(); ?>" />
<link href="<?php echo base_url($this->config->item('theme_public').'css/style.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url($this->config->item('theme_public').'css/font-awesome.css'); ?>" rel="stylesheet" />
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
body {
   padding-top: 50px;
   background: url(assets/img/1.jpg) no-repeat center center fixed;
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
}
.auth{
   background: white;
   margin:25px;
   padding: 25px;
   
}
.error {color:red;}
</style>
</head>
<body>
<input type="hidden" value="<?php echo $this->config->item('index_page'); ?>" id="index_page" />
<div id="loader" class="loader" style="background-color: black;position: absolute;top:30%; left: 50%; ;z-index: 1500;display: none;">
   <img src="assets/img/ajax_loader_blue_256.gif" />
</div>
<!-- nav -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <div class="container-fluid">
      <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" onclick="$('#navbar-collapse1').toggle();" data-target="#navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""><?php echo $this->config->item('logo_name'); ?></a>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
             <div class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" id="search" class="form-control" placeholder="Search">
              </div>
              <span onclick="catalog_list()" class="btn btn-default"><?php echo $this->lang->line('Send');?></span>
            </div>
            <ul class="nav navbar-nav">
             <li><a  href="<?php echo site_url('home/catalog'); ?>"><?php echo $this->lang->line('Catalog'); ?></a></li>
               <li><a href="<?php echo site_url('home/category'); ?>"><?php echo $this->lang->line('Categories'); ?></a></li>
               
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo '<?php echo $this->lang->line(\'Catalog\'); ?>'; ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <?php foreach ($this->config->item('category_tables') as $i) { ?>
                     <li><a href="<?php echo $i == 'news' ? site_url("home/$i") : site_url("home/{$i}s"); ?>"><?php echo $this->lang->line($i); ?></a></li>
                     <?php } ?>
                    
                  </ul>
               </li>
               
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo '<?php echo $this->lang->line(\'Categories\'); ?>'; ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <?php foreach ($this->config->item('category_tables') as $i) { ?>
                     <li><a href="<?php echo site_url("home/category/$i"); ?>"><?php echo $this->lang->line($i); ?></a></li>
                     <?php } ?>
                  </ul>
               </li>
               
               <?php $this->load->view("Adm/Settings/menu_statics_list"); ?>
               
               
               <?php echo '<?php if(CI_Controller::$username == null){ ?>'; ?>
               <li><a href="<?php echo site_url('auth/login'); ?>"><?php echo $this->lang->line('Login'); ?></a></li>
               <?php echo '<?php }else{ ?>'; ?>
               <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('Logout'); ?></a></li>
               <li><a href="<?php echo site_url('cabinet'); ?>"><?php echo $this->lang->line('Cabinet'); ?></a></li>
               <?php echo '<?php } ?>';?>
            </ul> 
                       
         </div>  
      </div>  
   </div>
</nav>
<!-- /nav --> 
<div class="container-fluid">
   <div class="row">
   <!-- Left_bar -->
      <div class="col-md-5 col-lg-5 col-sm-10 col-xs-24">          
         <div class="form-group">
            
            <select class="form-control" id="category_options">
               <option value="0"><?php echo $this->lang->line('All categories');?></option>
               <?php echo '<?php include(APPPATH.\'views/Widgets/category/options.php\'); ?>'; ?>
            </select>
            <?php echo '<?php if(!empty(CI_Controller::$breadcrumb[\'current\'])){ ?>';?>    
            <script type="text/javascript">
               document.getElementById("category_options").value = <?php echo '<?php echo CI_Controller::$breadcrumb[\'current\'][\'category_id\']; ?>'; ?>;
            </script>
            <?php echo '<?php } ?>';?>
            
            <div class="inputs">
               <div class="input-group">
                  <span class="input-group-addon"><span class="words"><?php echo $this->lang->line('Price from');?></span></span>
                  <input id="price_from" value="" class="form-control" />
                  <span class="input-group-addon"><span class="words"><?php echo $this->lang->line('to');?></span></span>
                  <input id="price_to" value="" type="text" class="form-control" />
               </div>
               <div id="slider-range"></div>
            </div>
            
            <select name="sort" id="sort" class="form-control">
               <option value="1"><?php echo $this->lang->line('Price ↑');?></option>
               <option value="2"><?php echo $this->lang->line('Price ↓');?></option>
               <option value="3"><?php echo $this->lang->line('Title ↑');?></option>
               <option value="4"><?php echo $this->lang->line('Title ↓');?></option>
               <option value="5"><?php echo $this->lang->line('Updated ↓');?></option>
               <option value="6"><?php echo $this->lang->line('Updated ↑');?></option>
            </select>
            
            <select name="per_page" id="per_page" class="form-control">
               <option value="25"><?php echo $this->lang->line('Per page ');?>25</option>
               <option value="50"><?php echo $this->lang->line('Per page ');?>50</option>
               <option value="100"><?php echo $this->lang->line('Per page ');?>100</option>
               <option value="150"><?php echo $this->lang->line('Per page ');?>150</option>
               <option value="200"><?php echo $this->lang->line('Per page ');?>200</option>
            </select>
           
         </div>
          <a class="btn btn-lg btn-info btn-block" href="<?php echo site_url('home/adverts')?>"><?php echo '<?php echo $this->lang->line(\'Catalog\'); ?>'; ?>&nbsp;<input type="radio" value="advert" name="category_table" checked="" /></a>
         
         <?php echo '<?php include(APPPATH.\'views/Widgets/category/menu_vertical.php\'); ?>';?>       
      
      </div>
   <!-- /Left_bar -->
   
      <div id="content" class="col-md-15 col-lg-15 col-sm-24 col-xs-24">  
 
         