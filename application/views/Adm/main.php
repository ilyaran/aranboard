<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>Admin</title>
<base href="<?php echo $this->config->item('base_url'); ?>" />
<link href="<?php echo $this->config->item('base_url') . $this->config->item('theme') .
'css/style.css'; ?>" rel="stylesheet" />
<link href="<?php echo $this->config->item('base_url') . $this->config->item('theme') .
'css/font-awesome.css'; ?>" rel="stylesheet" />
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
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo
base_url(); ?></a>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
             <div class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" id="search" class="form-control" placeholder="Search">
              </div>
              <span onclick="catalog_list()" class="btn btn-default"><?php echo
$this->lang->line('Send'); ?></span>
            </div>
            
            <ul class="nav navbar-nav">
               <li><a href="<?php echo site_url('admin'); ?>"><?php echo $this->
lang->line('Admin'); ?></a></li>
               
               <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo
$this->lang->line('Catalog'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <?php foreach ($this->config->item('category_tables') as $i) { ?>
                     <li><a href="<?php echo site_url("adm/advert/index/$i"); ?>"><?php echo
$i; ?></a></li>
                     <?php } ?>
                    
                  </ul>
               </li>
               
               <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo
$this->lang->line('Categories'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <?php foreach ($this->config->item('category_tables') as $i) { ?>
                     <li><a href="<?php echo site_url("adm/category/index/$i"); ?>"><?php echo
$i; ?></a></li>
                     <?php } ?>
                  </ul>
               </li>
               
               <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo
$this->lang->line('Settings'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <li><a href="<?php echo site_url('adm/settings'); ?>"><?php echo
$this->lang->line('Common'); ?></a></li>
                     <li><a href="<?php echo site_url('adm/settings/auth'); ?>"><?php echo
$this->lang->line('Auth'); ?></a></li>
                     
                     <li class="divider"></li>
                     <li><a href="<?php echo site_url('adm/settings/system'); ?>"><?php echo
$this->lang->line('System'); ?></a></li>
         
                     <li class="divider"></li>
                     <li><a href="<?php echo site_url('auth/change_password'); ?>"><?php echo
$this->lang->line('Change password'); ?></a></li>
                  </ul>
               </li>
               
               <li><a href="<?php echo site_url('adm/page'); ?>"><?php echo $this->
lang->line('Pages'); ?></a></li>
               
               <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo
$this->lang->line('Users'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <li><a href="<?php echo site_url('adm/user'); ?>"><?php echo
$this->lang->line('List'); ?></a></li>
                     <li><a href="<?php echo site_url('adm/user/unactivated_users'); ?>"><?php echo
$this->lang->line('Unactivated users'); ?></a></li>
                     
                     <li><a href="<?php echo site_url('adm/user/roles'); ?>"><?php echo
$this->lang->line('Roles'); ?></a></li>
         
                     <li><a href="<?php echo site_url('adm/user/uri_permissions'); ?>"><?php echo
$this->lang->line('Uri permissions'); ?></a></li>
                     <li><a href="<?php echo site_url('adm/user/custom_permissions'); ?>"><?php echo
$this->lang->line('Custom permissions'); ?></a></li>
                  </ul>
               </li>
               
               <?php if (CI_Controller::$username == null) { ?>
               <li><a href="<?php echo site_url('auth/login'); ?>"><?php echo $this->
lang->line('Login'); ?></a></li>
               <?php } else { ?>
               <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->
lang->line('Logout'); ?></a></li>
               <li><a href="<?php echo site_url('cabinet'); ?>"><?php echo $this->
lang->line('Cabinet'); ?></a></li>
               <?php } ?>
               
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
               <option class="words" value="0"><?php echo $this->lang->line('All categories'); ?></option>
               <?php $this->lib_tree->options('advert'); ?>
            </select>
            <?php if (!empty(CI_Controller::$breadcrumb['current'])) { ?>    
            <script type="text/javascript">
               document.getElementById("category_options").value = <?php echo
CI_Controller::$breadcrumb['current']['category_id'] ?>;
            </script>
            <?php } ?>
   
            <div class="inputs">
               <div class="input-group">
                  <span class="input-group-addon"><span class="words"><?php echo
$this->lang->line('Price from'); ?></span></span>
                  <input id="price_from" value="" class="form-control" />
                  <span class="input-group-addon"><span class="words"><?php echo
$this->lang->line('to'); ?></span></span>
                  <input id="price_to" value="" type="text" class="form-control" />
               </div>
            </div>
            
            <select name="status" id="status" class="form-control">
               <option value="9"><?php echo $this->lang->line('All'); ?></option>
               <option value="0"><?php echo $this->lang->line('NonChecked'); ?></option>
               <option value="1"><?php echo $this->lang->line('Checked'); ?></option>
               <option value="2"><?php echo $this->lang->line('Doubtful'); ?></option>
               <option value="3"><?php echo $this->lang->line('Bad'); ?></option>
            </select>
            
            <select name="sort" id="sort" class="form-control">
               <option value="5">Updated ↓</option>
               <option value="6">Updated ↑</option>
               <option value="1">Price ↑</option>
               <option value="2">Price ↓</option>
               <option value="3">Title ↑</option>
               <option value="4">Title ↓</option>
               <option value="7">Id ↓</option>
               <option value="8">Id ↑</option>
               
            </select>
   
            <select name="per_page" id="per_page" class="form-control">
               <option value="25"><?php echo $this->lang->line('Per page '); ?>25</option>
               <option value="50"><?php echo $this->lang->line('Per page '); ?>50</option>
               <option value="100"><?php echo $this->lang->line('Per page '); ?>100</option>
               <option value="150"><?php echo $this->lang->line('Per page '); ?>150</option>
               <option value="200"><?php echo $this->lang->line('Per page '); ?>200</option>
            </select>
             
            
         </div>
         
         
         <a class="btn btn-lg btn-info btn-block" href="<?php echo site_url('adm/advert'); ?>"><?php echo
$this->lang->line('Adverts'); ?>&nbsp;<input type="radio" value="advert" name="category_table" checked="" /></a>
         <div id="cat_bar">
            <div>
            
            <?php $this->lib_tree->menu_vertical(); ?>
            
            </div>           
         </div> 
      </div>
   <!-- /Left_bar -->   
   
      <div id="content" class="col-md-15 col-lg-15 col-sm-24 col-xs-24">  
 
 <div id="content"><?php $this->load->view($content); ?></div>
 
       </div>
       
   <!-- Right_bar -->
      <div class="col-md-4 col-lg-4 col-sm-24 col-xs-24">
      
         <div class="panel panel-default">
            <div class="panel-heading" style="word-break: break-all;">
               <a href="<?php echo site_url('adm/advert/index/organization'); ?>"><?php echo
$this->lang->line('Organizations'); ?></a> 
               &nbsp;<input type="radio" value="organization" name="category_table" /> 
            </div>
            <div class="panel-body">
               <ul style="padding:5px">
                  <?php $this->lib_tree->menu_vertical_organizations(); ?>
               </ul>
            </div>
          </div> 
          <div class="panel panel-default">
            <div class="panel-heading" style="word-break: break-all;">
               <a href="<?php echo site_url('adm/advert/index/news'); ?>"><?php echo
$this->lang->line('News'); ?></a>
               &nbsp;<input type="radio" value="news" name="category_table" /> 
            </div>
            <div class="panel-body">
               <ul style="padding:5px">
                  <?php $this->lib_tree->menu_vertical_news(); ?>
               </ul>
            </div>
          </div>           
       
       </div>
   <!-- /Right_bar --></div>
</div>

<footer>
 <!-- nav --> 
   <nav class="navbar navbar-default navbar-bottom" role="navigation">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-24">
               <div class="col-md-12 navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="">Advertisement Board Admin</a>
               </div>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                     <li>Page rendered in <strong>{elapsed_time}</strong> seconds.</li>
                     <li>Last query <?php echo CI_Controller::$last_q; ?></li>
                  </ul>
               </div>
            </div>  
         </div>
      </div>
   </nav>
 <!-- /nav -->
</footer>
<script src="<?php echo $this->config->item('theme') . 'js/jquery-2.1.0.min.js'; ?>"></script>
<script src="<?php echo $this->config->item('theme') . 'js/bootstrap.min.js'; ?>"></script>
<script type="text/javascript" src="assets/js/admin.js"></script>
</body>
</html>   