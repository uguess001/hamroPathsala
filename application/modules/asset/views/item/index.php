<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bullhorn"></i><small> <?php echo $this->lang->line('manage_item'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
               <?php $this->load->view('quick-link'); ?>              
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_item_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'asset', 'item')){ ?>
                            <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_item"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_item"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?> 
                            
                        <li class="li-class-list">
                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_item_by_school(this.value);">
                                        <option value="<?php echo site_url('asset/item/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('asset/item/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  
                        </li>   
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_item_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('category'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('product_code'); ?></th>
                                        <th><?php echo $this->lang->line('type'); ?></th>
                                        <th><?php echo $this->lang->line('store'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($items) && !empty($items)){ ?>
                                        <?php foreach($items as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->cat_name; ?></td>
                                            <td><?php echo $obj->name; ?></td>
                                            <td><?php echo $obj->code; ?></td>
                                            <td><?php echo $this->lang->line($obj->type); ?></td>
                                            <td><?php echo $obj->store_name; ?></td>
                                            <td><?php echo $obj->status ? $this->lang->line('active') : $this->lang->line('in_active'); ?></td>
                                            <td>
                                                <?php if(has_permission(VIEW, 'asset', 'item')){ ?>
                                                    <a  onclick="get_item_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-item-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(EDIT, 'asset', 'item')){ ?>
                                                    <a href="<?php echo site_url('asset/item/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?> 
                                                <?php if(has_permission(DELETE, 'asset', 'item')){ ?>
                                                    <a href="<?php echo site_url('asset/item/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_item">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('asset/item/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                   
                               <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="add_category_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($categories) && !empty($categories)){ ?>
                                                <?php foreach($categories as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($post) && $post['category_id'] == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                    </div>
                                </div>
                                
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($post['name']) ?  $post['name'] : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('name'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code"><?php echo $this->lang->line('product_code'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="code"  id="code" value="<?php echo isset($post['code']) ?  $post['code'] : ''; ?>" placeholder="<?php echo $this->lang->line('product_code'); ?>"  type="text">
                                        <div class="help-block"><?php echo form_error('code'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type"><?php echo $this->lang->line('type'); ?>  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="type"  id="type">
                                            <?php $types = get_item_type(); ?>
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            <?php foreach($types as $key=>$value){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['type'] == $key){ echo 'selected="selected"';} ?>><?php echo $this->lang->line($key); ?></option>    
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_id"><?php echo $this->lang->line('store'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="store_id"  id="add_store_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($stores) && !empty($stores)){ ?>
                                                <?php foreach($stores as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($post) && $post['store_id'] == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('store_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"> <?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm- col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>                                        
                                    </div>  
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('asset/item/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_item">
                            <div class="x_content">
                               
                                 <?php echo form_open(site_url('asset/item/edit/'.$item->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                 
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="edit_category_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($categories) && !empty($categories)){ ?>
                                                <?php foreach($categories as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($item->category_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($item->name) ?  $item->name : ''; ?>" placeholder=" <?php echo $this->lang->line('name'); ?>" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('name'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code"> <?php echo $this->lang->line('product_code'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="code"  id="code" value="<?php echo isset($item->code) ?  $item->code : ''; ?>" placeholder=" <?php echo $this->lang->line('product_code'); ?>" type="text">
                                        <div class="help-block"><?php echo form_error('code'); ?></div>
                                    </div>
                                </div>                                
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type"><?php echo $this->lang->line('type'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="type" id="type">
                                            <?php $types = get_item_type(); ?>
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            <?php foreach($types as $key=>$value){ ?>                                                                                
                                                <option value="<?php echo $key; ?>" <?php if($key == $item->type){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line($key); ?></option>                                                                                  
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_id"><?php echo $this->lang->line('store'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="store_id"  id="edit_store_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($stores) && !empty($stores)){ ?>
                                                <?php foreach($stores as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($item->store_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('store_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"> <?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($item) ? $item->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                   </div>
                                </div>
                                
                                 <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status"><?php echo $this->lang->line('status'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12 gsms-nice-select_"  name="status"  id="status" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="1" <?php if($item->status == 1){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('active'); ?></option>                                           
                                            <option value="0" <?php if($item->status == 0){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('in_active'); ?></option>                                                                                       
                                        </select>
                                        <div class="help-block"><?php echo form_error('status'); ?></div>
                                    </div>
                                </div> 
                                                                                            
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($item) ? $item->id : ''; ?>" id="id" name="id"/>
                                        <a href="<?php echo site_url('asset/item/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        
                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-item-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_item_data">            
        </div>       
      </div>
    </div>
</div>
  <!-- bootstrap-datetimepicker -->

  <script type="text/javascript">
         
    function get_item_modal(item_id){
         
        $('.fn_item_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('asset/item/get_single_item'); ?>",
          data   : {item_id : item_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_item_data').html(response);
             }
          }
       });
    }
   </script>
  
<script type="text/javascript">
          
    $("document").ready(function() {
        <?php if(isset($item) && !empty($item)){ ?>           
            $("#edit_school_id").trigger('change');
        <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val(); 
        var category_id = '';
        var store_id  = '';
        var form = 'add_';
         
        <?php if(isset($item) && !empty($item)){ ?>
            category_id =  '<?php echo $item->category_id; ?>';
            store_id  =  '<?php echo $item->store_id ; ?>';
            form = 'edit_';
        <?php } ?> 
        
       if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
        get_category_by_school(school_id, category_id, form);
        get_store_by_school(school_id, store_id, form);
        
       
    });
    
    
    <?php if(isset($post) && $post['category_id'] != ''){ ?>       
        get_category_by_school('<?php echo $post['school_id']; ?>', '<?php echo $post['category_id']; ?>', 'add_');
    <?php } ?>
   <?php if(isset($item) && !empty($item)){  ?>
        get_category_by_school('<?php echo $item->school_id; ?>', '<?php echo $item->category_id; ?>', 'edit_');
    <?php } ?> 
    
    function get_category_by_school(school_id, category_id, form){
            
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('asset/item/get_category_by_school'); ?>",
            data   : { school_id:school_id, category_id:category_id},               
            async  : false,
            success: function(response){                                                   
                if(response)
                {  
                   $('#'+form+'category_id').html(response);  
                }
            }
        });
    }
    
    
    <?php if(isset($post) && $post['store_id'] != ''){ ?>       
        get_store_by_school('<?php echo $post['school_id']; ?>', '<?php echo $post['store_id']; ?>', 'add_');
    <?php } ?>
   <?php if(isset($item) && !empty($item)){  ?>
        get_store_by_school('<?php echo $item->school_id; ?>', '<?php echo $item->store_id; ?>', 'edit_');
    <?php } ?> 
        
    function get_store_by_school(school_id, store_id, form){
    
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('asset/item/get_store_by_school'); ?>",
            data   : { school_id:school_id, store_id: store_id},               
            async  : false,
            success: function(response){                                                   
                if(response)
                {  
                  
                    $('#'+form+'store_id').html(response);   
                  
               }
           }
       });
    }
        
 </script>
   
 <script type="text/javascript">
     
    $(document).ready(function() {
      $('#datatable-responsive').DataTable( {
          dom: 'Bfrtip',
          iDisplayLength: 15,
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5',
              'pageLength'
          ],
          search: true
      });
    });
    
    $("#add").validate();     
    $("#edit").validate(); 
    
    function get_item_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }
    
</script>