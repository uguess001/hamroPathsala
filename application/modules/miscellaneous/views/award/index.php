<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_award'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_award_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'miscellaneous', 'award')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('miscellaneous/award/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_award"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_award"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                        
                        <li class="li-class-list">
                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_award_by_school(this.value);">
                                        <option value="<?php echo site_url('miscellaneous/award/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('miscellaneous/award/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  
                        </li>
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_award_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th> 
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>
                                        <th> <?php echo $this->lang->line('user_type'); ?></th>
                                        <th><?php echo $this->lang->line('title'); ?> </th>
                                        <th><?php echo $this->lang->line('gift'); ?> </th>
                                        <th><?php echo $this->lang->line('date'); ?> </th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                           
                                    <?php $count = 1; if(isset($awards) && !empty($awards)){ ?>
                                        <?php foreach($awards as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->role_name; ?></td>
                                            <td><?php echo $obj->title; ?></td>
                                            <td><?php echo $obj->gift; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></td>                                                                                                                                                                                                                                    
                                            <td>                                                      
                                                <?php if(has_permission(EDIT, 'miscellaneous', 'award')){ ?>
                                                    <a href="<?php echo site_url('miscellaneous/award/edit/'.$obj->id); ?>" title="<?php echo $this->lang->line('edit'); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?> 
                                                <?php if(has_permission(VIEW, 'miscellaneous', 'award')){ ?>
                                                    <a  onclick="get_award_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-award-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'miscellaneous', 'award')){ ?>    
                                                    <a href="<?php echo site_url('miscellaneous/award/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_award">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('miscellaneous/award/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id"> <?php echo $this->lang->line('user_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="add_role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($roles as $obj ){  ?>
                                                <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                <?php if(in_array($obj->id, array(GUARDIAN))){ continue;} ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($post['role_id']) && $post['role_id'] == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group display"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="add_class_id" onchange="get_user('', this.value,'');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php foreach($classes as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                            <?php } ?> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                    
                                <div class="item form-group">  
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('winner'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="add_user_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                    </div>
                                </div>
                                                                                                       
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('title'); ?><span class="required"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="add_title" value="<?php echo isset($post['title']) ?  $post['title'] : ''; ?>" placeholder=" <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gift"><?php echo $this->lang->line('gift'); ?> <span class="required"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="gift"  id="add_gift" value="<?php echo isset($post['gift']) ?  $post['gift'] : ''; ?>" placeholder=" <?php echo $this->lang->line('gift'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('gift'); ?></div>
                                    </div>
                                </div>                             
                                        
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"><?php echo $this->lang->line('price'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="price"  id="add_price" value="<?php echo isset($post['price']) ?  $post['price'] : ''; ?>" placeholder=" <?php echo $this->lang->line('price'); ?>" required="required" type="number" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('price'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date"><?php echo $this->lang->line('date'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="date"  id="add_date" value="<?php echo isset($post['date']) ?  $post['date'] : ''; ?>" placeholder="<?php echo $this->lang->line('date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('date'); ?></div>
                                    </div>
                                </div>
                                                              
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control" name="note" id="add_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div> 
                                                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('miscellaneous/award/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_award">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('miscellaneous/award/edit/'.$award->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                 <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                    <div class="item form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id"><?php echo $this->lang->line('user_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="edit_role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                                <?php foreach($roles as $obj ){  ?>
                                                    <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                    <?php if(in_array($obj->id, array(GUARDIAN))){ continue;} ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($award) && $award->role_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group display"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="edit_class_id"  onchange="get_user('', this.value,'');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php foreach($classes as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($award) && $award->class_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('winner'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="edit_user_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo $this->lang->line('title'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="title"  id="edit_title" value="<?php echo isset($award->title) ?  $award->title : ''; ?>" placeholder="<?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('title'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gift"> <?php echo $this->lang->line('gift'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="gift"  id="edit_title" value="<?php echo isset($award->gift) ?  $award->gift : ''; ?>" placeholder="<?php echo $this->lang->line('gift'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('gift'); ?></div>
                                        </div>
                                    </div>
                                                               
                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> <?php echo $this->lang->line('price'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="price"  id="edit_price" value="<?php echo isset($award->price) ?  $award->price : ''; ?>" placeholder="<?php echo $this->lang->line('price'); ?>" required="required" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('price'); ?></div>
                                        </div>
                                    </div>
                                                                      
                                    <div class="item form-group">
                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date"><?php echo $this->lang->line('date'); ?> <span class="required">*</span>
                                       </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="date"  id="edit_date" value="<?php echo isset($award->date) ?  date('d-m-Y', strtotime($award->date)) : ''; ?>" placeholder="<?php echo $this->lang->line('date'); ?>" required="required" type="text" autocomplete="off">
                                         <div class="help-block"><?php echo form_error('date'); ?></div>
                                       </div>
                                    </div>
                                     
                                    <div class="item form-group">
                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?> </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="edit_note"  placeholder="<?php echo $this->lang->line('note'); ?>"> <?php echo isset($award->note) ?  $award->note : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                    </div> 
                                
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($award) ? $award->id : ''; ?>" id="id" name="id" />
                                            <a  href="<?php echo site_url('miscellaneous/award/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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


<div class="modal fade bs-award-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_award_data">            
        </div>       
      </div>
    </div>
</div>

<script type="text/javascript">
         
    function get_award_modal(id){
         
        $('.fn_award_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('miscellaneous/award/get_single_award'); ?>",
          data   : {id : id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_award_data').html(response);
             }
          }
       });
    }
</script>


<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

 <script type="text/javascript">
     
    $('#add_date').datepicker();  
    $('#edit_date').datepicker();  
  
    var form = 'add';
   
   <?php if(isset($award)){ ?> 
      form = 'edit';
   <?php } ?>
      
    $("document").ready(function () {
     <?php if (isset($school_id) && !empty($school_id)) { ?>
         $("#edit_school_id").trigger('change');
     <?php } ?>
    });
    
    
    $('.fn_school_id').on('change', function(){   
         
        var class_id = '';
        <?php if(isset($award)){ ?> 
          class_id = '<?php echo $award->class_id; ?>';
       <?php } ?>
           
        var school_id = $(this).val(); 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                  $('#'+form+'_class_id').html(response);  
               }
            }
        });     
    });
      
      
    <?php if(isset($post['role_id'])){ ?>  
         get_user_by_role('<?php echo $post['role_id']; ?>', '<?php echo $post['user_id']; ?>');
    <?php } ?>
        
    <?php if(isset($award)){ ?>  
         get_user_by_role('<?php echo $award->role_id; ?>', '<?php echo $award->user_id; ?>');
    <?php } ?>
      
      
    function get_user_by_role(role_id, user_id){
      
        var school_id = $('.fn_school_id').val();
        if( !school_id){            
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           $('select#'+form+'_role_id').prop('selectedIndex', 0);
           return false;
        }
        
        if(role_id == <?php echo STUDENT; ?>){
        
           $('.display').show();
           $('#'+form+'_class_id').prop('required', true);
           $('select#'+form+'_class_id').prop('selectedIndex', 0);
           $('#'+form+'_user_id').html('<option value="">--<?php echo $this->lang->line('select'); ?>--</option>');                       
           
       }else{
           get_user(role_id, '', user_id);
           $('#'+form+'_class_id').prop('required', false);
           $('.display').hide();
       }            
   }
      
    <?php if(isset($award)){ ?> 
          get_user('<?php echo $award->role_id; ?>', '<?php echo $award->class_id; ?>', '<?php echo $award->user_id; ?>');
    <?php } ?>
   
   function get_user(role_id, class_id, user_id){
       
        if(role_id == ''){
            role_id = $('#'+form+'_role_id').val();
        }
        
        var school_id = $('.fn_school_id ').val();
        if( !school_id){            
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }  
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_by_role'); ?>",
            data   : { school_id : school_id, role_id : role_id , class_id: class_id, user_id : user_id, message:false},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#'+form+'_user_id').html(response); 
               }
            }
        }); 
   }
   
  
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
            search: true,            
            responsive: true
        });
  });
      
    $("#add").validate();   
    $("#edit").validate();   

    function get_award_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }
    
</script> 
