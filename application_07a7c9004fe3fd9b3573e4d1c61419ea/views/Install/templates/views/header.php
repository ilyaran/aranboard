<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="keywords" content="<?php echo '<?php echo CI_Controller::$meta_keywords?>'; ?>"/>
<meta name="description" content="<?php echo '<?php echo CI_Controller::$meta_description?>'; ?>"/>
<title><?php echo '<?php echo CI_Controller::$meta_title?>'; ?></title>
<base href="<?php echo base_url(); ?>" />
<link href="<?php echo base_url(set_value('theme','themes/bootstrap').'css/style.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url(set_value('theme','themes/bootstrap').'css/font-awesome.css'); ?>" rel="stylesheet" />
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
            <a class="navbar-brand" href="">Advertisement Board</a>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
            <ul class="nav navbar-nav">
             <li><a  href="<?php echo site_url('home/catalog');?>"><?php echo $this->lang->line('Catalog');?></a></li>
               <li><a href="<?php echo site_url('home/category');?>"><?php echo $this->lang->line('Categories');?></a></li>
               <li><a href="<?php echo site_url('home/about_us');?>"><?php echo $this->lang->line('About us');?></a></li>
               <?php echo '<?php if(CI_Controller::$username == null){ ?>'; ?>
               <li><a href="<?php echo site_url('auth/login'); ?>"><?php echo $this->lang->line('Login');?></a></li>
               <?php echo '<?php }else{ ?>'; ?>
               <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('Logout');?></a></li>
               <li><a href="<?php echo site_url('cabinet'); ?>"><?php echo $this->lang->line('Cabinet');?></a></li>
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
            <div class="input-group">
              <input  type="text" id="search" class="form-control" placeholder="" aria-describedby="basic-addon2">
              <span onclick="catalog_list('0');" class="input-group-addon" id="basic-addon2"><?php echo $this->lang->line('Search');?></span>
            </div>
         
            <select class="form-control" id="category_options">
               <option class="words" value="0"><?php echo $this->lang->line('All categories');?></option>
               <?php echo '<?php $this->load->view(\'Widgets/category/options\') ?>'; ?>
            </select>
            <?php echo '<?php if(!empty(CI_Controller::$breadcrumb[\'current\'])){ ?>';?>    
            <script type="text/javascript">
               document.getElementById("category_options").value = <?php echo '<?php echo CI_Controller::$breadcrumb[\'current\'][\'category_id\']; ?>'; ?>;
            </script>
            <?php echo '<?php } ?>'; ?>
            
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
               <option class="words" value="1"><?php echo $this->lang->line('Price up');?></option>
               <option class="words" value="2"><?php echo $this->lang->line('Price down');?></option>
               <option class="words" value="3"><?php echo $this->lang->line('A-Z');?></option>
               <option class="words" value="4"><?php echo $this->lang->line('Z-A');?></option>
            </select>
            
            <select name="per_page" id="per_page" class="form-control" title="<?php echo $this->lang->line('Per page ');?>">
               <option class="words" value="25">25</option>
               <option class="words" value="50">50</option>
               <option class="words" value="100">100</option>
               <option class="words" value="150">150</option>
               <option class="words" value="200">200</option>
            </select>
           
         </div>
          <a class="btn btn-lg btn-info btn-block" href="<?php echo site_url('home/catalog')?>"><?php echo $this->lang->line('Catalog');?></a>
         
         <?php echo '<?php $this->load->view("Widgets/category/menu_vertical") ?>'; ?>       
      
      </div>
   <!-- /Left_bar -->
   
      <div id="content" class="col-md-15 col-lg-15 col-sm-24 col-xs-24">  
 
         