   </div>
   <!-- Right_bar -->
      <div class="col-md-4 col-lg-4 col-sm-24 col-xs-24">
       
         
        <?php echo '<?php $this->load->view("Widgets/category/menu_vertical_organization") ?>'; ?>
       
                
      </div>
   <!-- /Right_bar --></div>
</div>

<footer>
 <!-- nav --> 
   <nav class="navbar navbar-default navbar-bottom" role="navigation">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-24">
               <div class="col-md-4 navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="">Advertisement Board</a>
               </div>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                     <li>Page rendered in <strong>{elapsed_time}</strong> seconds.</li>
                  </ul>
               </div>
            </div>  
         </div>
      </div>
   </nav>
 <!-- /nav -->
</footer>
<script src="<?php echo base_url(set_value('theme','themes/bootstrap').'js/jquery-2.1.0.min.js'); ?>"></script>
<script src="<?php echo base_url(set_value('theme','themes/bootstrap').'js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="assets/js/board.js"></script>
</body>
</html>