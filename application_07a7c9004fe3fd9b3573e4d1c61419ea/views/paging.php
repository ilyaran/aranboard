<?php if(CI_Controller::$paging != ''){?>

   <div class="col-md-24 ">
      <ul class="pagination pagination-lg">
         <?php echo CI_Controller::$paging?>
      </ul>  
   </div>

<?php }?>

 <div class="col-md-24 ">
    <ul class="pager">
      <li><a href="javascript:history.back(1)">&larr;&mdash;</a></li>
      <li><a href="javascript:history.forward(1)">&mdash;&rarr;</a></li>
    </ul>
 </div>
