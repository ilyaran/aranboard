<div class="row">
   <div class="col-md-24 col-lg-24 col-sm-24 col-xs-24"> 
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php echo $this->lang->line('Edit Category').': '.CI_Controller::$data['category']['name'];?>
         </div>
         <div id="cabinet_panel" class="panel-body">
            <div class="table-responsive">
               <form name="add_form" id="add_form"  action="" onsubmit="return presubmit()" method="post" enctype="multipart/form-data">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                     <tr>
                        <td style="width: 20%;">
                        <?php echo $this->lang->line('Parent Category');?>
                        <?php echo form_error('parent'); ?>
                        </td>
                        <input type="hidden" name="category_table" value="<?php echo CI_Controller::$data['category_table']; ?>" />
                        <td>
                        <select id="parent" name="parent">
                        <option value="0"><?php echo $this->lang->line('Root Category');?></option>
                        <?php $this->lib_tree->options(CI_Controller::$data['category_table']); ?>
                        </select>
                        </td>
                        
                        </tr>
                     <tr>
                        <td style="width: 20%;">
                          <?php echo form_error('enabled'); ?>
                        </td>
                             
                        <td>
                           &nbsp;&nbsp;<?php echo $this->lang->line('Enabled');?> &nbsp;<input type="checkbox" <?php echo set_value('enabled',CI_Controller::$data['category']['enabled']) == 1 ? 'checked="checked"':''; ?> value="1" name="enabled" />
                        </td>
                        <script>
                        document.getElementById("parent").value = <?php echo set_value('parent',CI_Controller::$data['category']['parent']); ?>;
                        </script>
                     </tr>
                     <tr>
                        <td style="width: 20%;">
                           <?php echo $this->lang->line('Sort index');?>
                           <?php echo form_error('sort'); ?>
                        </td>
                        <td><input style="width: 50%;" type="number" name="sort" id="sort" value="<?php echo set_value('sort',CI_Controller::$data['category']['sort']); ?>" placeholder="0" /></td>
                     </tr>
                     <tr>
                        <td style="width: 20%;">
                           <?php echo $this->lang->line('Name');?>
                           <?php echo form_error('name'); ?>
                        </td>
                        <td><input style="width: 100%;" type="text" name="name" id="name" value="<?php echo set_value('name',CI_Controller::$data['category']['name']); ?>" /></td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Description');?>
                           <?php echo form_error('description'); ?>
                        </td>
                        <td><textarea name="description" id="description" style="width: 100%;height: 150px;" ><?php echo set_value('description',CI_Controller::$data['category']['description']); ?></textarea></td>
                     </tr>
                  
                     <tr>
                        <td>
                           <?php echo $this->lang->line('Logo image (gif,jpg,jpeg,png), size no greater than ').$this->config->item('img_max_size').' Kb, '.$this->config->item('img_max_width').'x'.$this->config->item('img_max_height').'pixels. '.$this->upload->display_errors();?>
                        
                        </td>
                        <td>
                           <table style="width: 100%;">
                              <tr>
                                 <td>
                                    <?php if(CI_Controller::$data['category']['logo']!=null){?>
                                    <img src="upload/logo/<?php echo CI_Controller::$data['category']['logo']; ?>" width="150" height="150"/>
                                    <?php } ?>
                                    <input style="width:50%" type="file" name="logo" />
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