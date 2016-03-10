<div class="row">
   <div class="col-md-24">      
        
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php echo $this->lang->line('Add advert').'&nbsp;<span class="error">*</span>&nbsp;'.$this->lang->line('Required fields');?>
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
                        <?php $this->lib_tree->options('advert'); ?>
                        </select>
                        </td>
                        
                        </tr>
                     <tr>
                        <td style="width: 20%;">
                         <?php echo form_error('enabled'); ?>
                        </td>
                             
                        <td>
                           &nbsp;&nbsp;<?php echo $this->lang->line('Enabled');?> &nbsp;<input type="checkbox" <?php echo set_value('enabled','1') == 1 ? 'checked=""':''; ?> value="1" name="enabled" />
                           
                        </td>
                        <script>
                        document.getElementById("category_id").value = <?php echo set_value('category_id'); ?>;
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
                        <td><input style="width: 100%;" onchange="check(this);" type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" /></td>
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
                        <td><textarea onchange="check(this);" name="text" id="text" style="width: 100%;height: 150px;" ><?php echo set_value('text'); ?></textarea></td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Price');?>
                           <?php echo form_error('price'); ?>
                           
                           <i class="fa fa-thumbs-o-up" id="ok_price" style="visibility: hidden;"></span></i>
                           <i class="fa fa-thumbs-o-down" id="err_price" style="visibility: hidden;"><font style="color: #F00">
                           <?php echo $this->lang->line('Form element must contain only numbers.');?>
                           </font></span></i>
                           
                        </td>
                        <td><input style="width:50%;" name="price" onchange="check(this);" type="number" value="<?php echo set_value('price'); ?>" /></td>
                     </tr>
                        <tr>
                           <td>
                              <?php echo $this->lang->line('Contacts');?>
                              <?php echo form_error('contacts'); ?>
                              
                              <i class="fa fa-thumbs-o-up" id="ok_contacts" style="visibility: hidden;"></span></i>
                              <i class="fa fa-thumbs-o-down" id="err_contacts" style="visibility:hidden;"><font style="color: #F00">
                              <?php echo $this->lang->line('Form element must contain at least 8 characters.');?>
                              </font></span></i>
                           
                           </td>
                           
                           <td><textarea name="contacts" onchange="check(this);" style="width: 100%;height: 100px;"><?php echo set_value('contacts'); ?></textarea></td>
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
