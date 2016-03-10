<!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="keywords" content="<?php echo CI_Controller::$meta_keywords; ?>"/>
<meta name="description" content="<?php echo CI_Controller::$meta_description; ?>"/>
<title><?php echo CI_Controller::$meta_title; ?></title>
<base href="http://kristy.kz/" />
<link href="http://kristy.kz/themes/bootstrap/css/style.css" rel="stylesheet" />
<link href="http://kristy.kz/themes/bootstrap/css/font-awesome.css" rel="stylesheet" />
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
<input type="hidden" value="index.php" id="index_page" />
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
            <a class="navbar-brand" href="">Kristy.kz</a>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
             <div class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" id="search" class="form-control" placeholder="Search">
              </div>
              <span onclick="catalog_list()" class="btn btn-default">Send</span>
            </div>
            <ul class="nav navbar-nav">
             <li><a  href="http://kristy.kz/index.php/home/catalog">Catalog</a></li>
               <li><a href="http://kristy.kz/index.php/home/category">Categories</a></li>
               
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('Catalog'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                                          <li><a href="http://kristy.kz/index.php/home/adverts">advert</a></li>
                                          <li><a href="http://kristy.kz/index.php/home/organizations">organization</a></li>
                                          <li><a href="http://kristy.kz/index.php/home/news">news</a></li>
                                         
                  </ul>
               </li>
               
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('Categories'); ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                                          <li><a href="http://kristy.kz/index.php/home/category/advert">advert</a></li>
                                          <li><a href="http://kristy.kz/index.php/home/category/organization">organization</a></li>
                                          <li><a href="http://kristy.kz/index.php/home/category/news">news</a></li>
                                       </ul>
               </li>
               
                              
               
               <?php if(CI_Controller::$username == null){ ?>               <li><a href="http://kristy.kz/index.php/auth/login">Login</a></li>
               <?php }else{ ?>               <li><a href="http://kristy.kz/index.php/auth/logout">Logout</a></li>
               <li><a href="http://kristy.kz/index.php/cabinet">Cabinet</a></li>
               <?php } ?>            </ul> 
                       
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
               <option value="0">All categories</option>
               <?php include(APPPATH.'views/Widgets/category/options.php'); ?>            </select>
            <?php if(!empty(CI_Controller::$breadcrumb['current'])){ ?>    
            <script type="text/javascript">
               document.getElementById("category_options").value = <?php echo CI_Controller::$breadcrumb['current']['category_id']; ?>;
            </script>
            <?php } ?>            
            <div class="inputs">
               <div class="input-group">
                  <span class="input-group-addon"><span class="words">Price from</span></span>
                  <input id="price_from" value="" class="form-control" />
                  <span class="input-group-addon"><span class="words">to</span></span>
                  <input id="price_to" value="" type="text" class="form-control" />
               </div>
               <div id="slider-range"></div>
            </div>
            
            <select name="sort" id="sort" class="form-control">
               <option value="1">Price ↑</option>
               <option value="2">Price ↓</option>
               <option value="3">Title ↑</option>
               <option value="4">Title ↓</option>
               <option value="5">Updated ↓</option>
               <option value="6">Updated ↑</option>
            </select>
            
            <select name="per_page" id="per_page" class="form-control">
               <option value="25">Per page 25</option>
               <option value="50">Per page 50</option>
               <option value="100">Per page 100</option>
               <option value="150">Per page 150</option>
               <option value="200">Per page 200</option>
            </select>
           
         </div>
          <a class="btn btn-lg btn-info btn-block" href="http://kristy.kz/index.php/home/adverts"><?php echo $this->lang->line('Catalog'); ?>&nbsp;<input type="radio" value="advert" name="category_table" checked="" /></a>
         
         <?php include(APPPATH.'views/Widgets/category/menu_vertical.php'); ?>       
      
      </div>
   <!-- /Left_bar -->
   
      <div id="content" class="col-md-15 col-lg-15 col-sm-24 col-xs-24">  
 
         