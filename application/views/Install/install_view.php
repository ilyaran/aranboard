<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Install</title>
<base href="<?php echo $this->config->item('base_url'); ?>" />
<link href="<?php echo $this->config->item('base_url').$this->config->item('theme').'css/style.css'; ?>" rel="stylesheet" />
<link href="<?php echo $this->config->item('base_url').$this->config->item('theme').'css/font-awesome.css'; ?>" rel="stylesheet" />
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
body {
   padding-top: 3px;
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
<div class="container-fluid">
   <div class="row">
   
   <!-- Left_bar -->
      <div class="col-md-5 col-lg-5 col-sm-10 col-xs-24">
      </div>
   <!-- /Left_bar -->
   
   <div id="content" class="col-md-15 col-lg-15 col-sm-24 col-xs-24">  
 
   <!------------ Content -->

   <div class="panel panel-default">
      <div class="panel-body">
         <h2><?php echo $this->lang->line('Welcome to install.');?></h2>
         <div style="border: black 2px solid;padding: 5px;">
            <?php foreach($lang_codes as $n => &$l){ ?>
               <a href="<?php echo site_url("install/index/$l"); ?>"><?php echo $n; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
         </div>
      </div>
   </div>

<div class="panel panel-default">
   <div class="panel-heading">
      <h1 class="panel-title"><?php echo $this->lang->line('Install');?></h1>
   </div>
   <div class="panel-body">
      <div class="table-responsive">
         <form method="post">
            <table class="table table-striped table-bordered table-hover">
            
            <thead>
               <tr>
                  <th><?php echo $this->lang->line('Options');?></th>
                  <th style="width: 30%;"><?php echo $this->lang->line('Value');?></th>
                  <th style="width: 50%;"><?php echo $this->lang->line('Description');?></th>
               </tr>
            </thead>
            
            <tbody>
            
               <tr>
                  <td><span class=""><?php echo $this->lang->line('PHP version');?></span></td>
                  <td><?php echo phpversion(); ?></td>
                  
                  <td>
                  
                  <?php 
                  if (version_compare(PHP_VERSION, '5.3.0') === 1) 
                  {
                     echo $this->lang->line('Ok! Your version: ') . PHP_VERSION . "\n";
                     echo $this->lang->line('Tested for 5.3 and 5.4');
                  }
                  else
                  {
                     echo '<span class="error">'.
                           $this->lang->line('Unsuitable version: ') . 
                           PHP_VERSION .'<br>'. $this->lang->line('Tested for 5.3 and 5.4').
                           '</span>';
                  }
                  
                  ?>
                  </td>
               </tr>
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Primary config Language');?></span></td>
                  <td>
                     <select name="language" id="language">
                        <?php foreach($lang_codes as $n => &$l){ ?>
                           <option value="<?php echo $l; ?>"><?php echo $n; ?></option>
                        <?php } ?>
                     </select>
                      <script type="text/javascript">
               document.getElementById("language").value = '<?php echo set_value('language',$this->config->item('language')); ?>';
            </script>
                  </td>
                  <td> <?php echo form_error('language'); ?></td>
               </tr>
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Base url');?></span>
                 
                  </td>
                  <td><?php echo $this->config->item('base_url'); ?></td>
                  <td>
                  <?php if ($this->config->item('base_url') == '')
                  {
                     echo '<p class="error">'.$this->lang->line('Set Base URL ($config[\'base_url\']="http://your_site.com/") in application/config/config.php').'</p>';
                  } 
                  ?>
                  <?php echo $this->lang->line('Example: http://your_site.com/'); ?>
                   
                  
                  </td>
               </tr>
               <tr>
                  <td><span class="">Index Page</span></td>
                  <td>index.php</td>
                  <td></td>
               </tr> 
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Data Base');?></span></td>
                  <td>MySQL 5.5</td>
                  <td><?php echo $connection_result; ?></td>
               </tr>
             
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Host');?></span></td>
                  <td><input name="hostname" value="<?php echo set_value('hostname'); ?>" type="text"/></td>
                  <td><?php echo form_error('hostname').$connection_result; ?></td>
               </tr>
               
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Database Name');?></span></td>
                  <td><input name="database" value="<?php echo set_value('database'); ?>" placeholder="" type="text"/></td>
                  <td><?php echo form_error('database').$connection_result; ?></td>
               </tr>
               
               <tr>
                  <td><span class=""><?php echo $this->lang->line('Database User Name');?></span></td>
                  <td><input name="username" value="<?php echo set_value('username'); ?>" placeholder="" type="text"/></td>
                  <td><?php echo form_error('username').$connection_result; ?></td>
               </tr>
               
               <tr>    
                  <td><span class=""><?php echo $this->lang->line('Database Password');?></span></td>
                  <td><input name="password" value="<?php echo set_value('password'); ?>" placeholder="" type="text"/></td>
                  <td><?php echo form_error('password').$connection_result; ?></td>
               </tr>
               
               <tr>
                  <td></td>
                  <td><input type="submit" /></td>
                  <td></td>
               </tr>
               </tbody>
            </table>
         </form>
      </div>
   </div>
</div>
 
 
 
 <!------------ End Content -->
 
 
      </div>


 <!-- Right_bar -->
      <div class="col-md-4 col-lg-4 col-sm-24 col-xs-24">
             
      </div>
    <!-- /Right_bar --></div>
</div>

<footer>
 
</footer>
<script src="<?php echo $this->config->item('theme').'js/jquery-1.10.2.js'; ?>"></script>
<script src="<?php echo $this->config->item('theme').'js/bootstrap.min.js'; ?>"></script>
</body>
</html>