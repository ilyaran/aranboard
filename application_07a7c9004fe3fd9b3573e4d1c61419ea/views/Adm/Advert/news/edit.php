<div class="row">
   <div class="col-md-24">      
        
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php echo $this->lang->line('Edit news').'&nbsp;<span class="error">*</span>&nbsp;'.$this->lang->line('Required fields');?>
         </div>
         <div id="cabinet_panel" class="panel-body">
            <div class="table-responsive">
               <form name="add_form" id="add_form"  action="" onsubmit="return presubmit()" method="post" enctype="multipart/form-data">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                     <tr>
                        <td style="width: 20%;">
                        <?php echo $this->lang->line('Category');?>
                        <?php echo form_error('category_id'); ?>
                        </td>
                        
                        <td>
                        <select id="category_id" name="category_id">
                        <option value="0"><?php echo $this->lang->line('All Categories');?></option>
                        <?php $this->lib_tree->options('news'); ?>
                        </select>
                        </td>
                        
                        </tr>
                     <tr>
                        <td style="width: 20%;">
                           <?php echo form_error('enabled'); ?>
                        </td>
                             
                        <td>
                           &nbsp;&nbsp;<?php echo $this->lang->line('Enabled');?> &nbsp;<input type="checkbox" <?php echo set_value('enabled',CI_Controller::$data['news']['enabled'])==1 ? 'checked=""':''; ?> value="1" name="enabled" />
                           
                        </td>
                        <script type="text/javascript">
                        document.getElementById("category_id").value = <?php echo set_value('category_id',CI_Controller::$data['news']['category_id']); ?>;
                        </script>
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
                        <td><input style="width: 100%;" onchange="check(this);" type="text" name="title" id="title" value="<?php echo set_value('title',CI_Controller::$data['news']['title']); ?>" /></td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Text').'&nbsp;<span class="error">*</span>&nbsp;';?>
                           <?php echo form_error('text'); ?>
                           
                           <i class="fa fa-thumbs-o-up" id="ok_text" style="visibility: hidden;"></span></i>
                           <i class="fa fa-thumbs-o-down" id="err_text" style="visibility: hidden;"><font style="color: #F00">
                           <?php echo $this->lang->line('Form element must contain at least 12 characters.');?>
                           </font></span></i>
                           
                        </td>
                        <td><textarea onchange="check(this);" name="text" id="text" style="width: 100%;height: 150px;" ><?php echo set_value('text',CI_Controller::$data['news']['text']); ?></textarea></td>
                     </tr>
                     
                        
                        <tr>
                           <td>
                              <?php echo $this->lang->line('Images (gif,jpg,jpeg,png), size no greater than ').$this->config->item('img_max_size').' Kb, '.$this->config->item('img_max_width').'x'.$this->config->item('img_max_height').'pixels. '.$this->upload->display_errors();?>
                           
                           </td>
                           <td>
                              <table style="width: 100%;">
                                 <tr>
                                    <td><?php echo $this->lang->line('First image will be as Logo.');?></td>
                                 </tr>
                                 <tr>
                                    <td>
                                    
                                    <?php 
                                    if(is_array(CI_Controller::$data['post']['img']))
                                    {
                                       foreach(CI_Controller::$data['post']['img'] as $a=>$i) 
                                       { ?>
                                       <div style="width: 155px; float: left; margin-bottom: 5px;">
                                       <img src='upload/img/<?php echo $i; ?>' width='150' height='150' />
                                    &nbsp;<input size="3" type="text" pattern="[0-9]+" value="<?php echo $a; ?>" name="img_sort[<?php echo $a; ?>]"/>
                                    &nbsp;<input  name="img_del[]" type="checkbox" value="<?php echo $a; ?>" title="<?php echo $this->lang->line('Delete this image');?>" />
                                         </div> 
                                    <?php   }
                                    
                                    }
                                    ?>
                                    
                                       
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <?php 
                                       for($i=1; $i <= $this->config->item('num_img'); $i++) 
                                       {
                                          echo ' <input style="width:50%" type="file" name="img[]" />';
                                       } 
                                       ?> 
                                    </td>
                                 </tr>
                               
                              </table>
                           </td>
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
   
