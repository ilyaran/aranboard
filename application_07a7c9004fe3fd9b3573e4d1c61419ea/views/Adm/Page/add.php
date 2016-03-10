<div class="row">
   <div class="col-md-24">      
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php echo $this->lang->line('Add page').'&nbsp;<span class="error">*</span>&nbsp;'.$this->lang->line('Required fields');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
            <div class="table-responsive">
               <form name="add_form" id="add_form"  action="" onsubmit="return presubmit()" method="post" enctype="multipart/form-data">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Url');?>
                           <?php echo form_error('url'); ?>
                           
                           <i class="fa fa-thumbs-o-up" id="ok_contacts" style="visibility: hidden;"></span></i>
                           <i class="fa fa-thumbs-o-down" id="err_contacts" style="visibility:hidden;"><font style="color: #F00">
                           <?php echo $this->lang->line('Form element must contain at least 8 characters.');?>
                           </font></span></i>
                        
                        </td>
                        <td>
                           <input style="width: 100%;" onchange="check(this);" type="text" name="url" id="url" value="<?php echo set_value('url'); ?>" />
                        </td>
                     </tr>
                     <tr>
                        <td style="width: 20%;">
                        <?php echo $this->lang->line('Sort Index');?>
                        <?php echo form_error('sort'); ?>
                        </td>
                                                
                        <td>
                           <input style="width: 20%;" type="number" name="sort" id="sort" value="<?php echo set_value('sort'); ?>" />
                        </td>
                        
                        </tr>
                     <tr>
                        <td style="width: 20%;">
                         <?php echo form_error('display'); ?>
                        </td>
                             
                        <td>
                           &nbsp;&nbsp;<?php echo $this->lang->line('Display');?> &nbsp;<input type="checkbox" <?php echo set_value('display','0') == 1 ? 'checked=""':''; ?> value="1" name="display" />
                        </td>
                     </tr>
                     <tr>
                        <td style="width: 20%;">
                           <?php echo $this->lang->line('Title').'&nbsp;<span class="error">*</span>&nbsp;';?>
                           <?php echo form_error('title'); ?>
                           
                           <i class="fa fa-thumbs-o-up" id="ok_title" style="visibility: hidden;"></span></i>
                           <i class="fa fa-thumbs-o-down" id="err_title" style="visibility: hidden;"><font style="color: #F00">
                           <?php echo $this->lang->line('Form element must contain at least 8 characters.');?>
                           </font></span></i>
                           
                        </td>
                        <td>
                           <input style="width: 100%;" onchange="check(this);" type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" />
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Page Body').'&nbsp;<span class="error">*</span>&nbsp;';?>
                           <?php echo form_error('body'); ?>
                           
                           <i class="fa fa-thumbs-o-up" id="ok_text" style="visibility: hidden;"></span></i>
                           <i class="fa fa-thumbs-o-down" id="err_text" style="visibility: hidden;"><font style="color: #F00">
                           <?php echo $this->lang->line('Form element must contain at least 12 characters.');?>
                           </font></span></i>
                           
                        </td>
                        <td><textarea onchange="check(this);" name="body" id="body" style="width: 100%;height: 150px;" ><?php echo set_value('body'); ?></textarea></td>
                     </tr>
                    
                       
                        <tr>
                           <td></td>
                           <td><input type="submit" value="<?php echo $this->lang->line('Send');?>"/></td>
                        </tr> 
                        
                     </tbody>
                  </table>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
   
<script language="JavaScript" type="text/javascript">
<!--
function check(obj)
{
   var str = obj.value;
   var field = obj.getAttribute("name");
   var valid = false;
   if(field == 'title'){
      if(str.length > 5) valid = true;
   }
   if(field == 'text'){
      if(str.length > 12) valid = true;
   }
   
   if (valid) {
      document.getElementById('err_'+field).style.visibility="hidden"; 
      document.getElementById('ok_'+field).style.visibility="visible";
   } else {
      document.getElementById('ok_'+field).style.visibility="hidden"; 
      document.getElementById('err_'+field).style.visibility="visible";
   }
}

function presubmit(){
   var field = ['title','text'];
   for (var i in field){
      if (document.getElementById(field[i]).value.length == 0)
      {
         alert ('<?php echo $this->lang->line('Fill Required fields');?>');
         return false;
      }   
   }
   return true;
}

//-->
</script>