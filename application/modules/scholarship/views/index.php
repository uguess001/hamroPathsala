<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_scholarship'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_scholarship_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a></li>
                        <?php if(has_permission(ADD, 'scholarship', 'scholarship')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('scholarship/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a></li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_scholarship"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a></li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_scholarship"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                            
                            
                        <li class="li-class-list">
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <?php $teacher_access_data = get_teacher_access_data(); ?>  
                            
                            <?php echo form_open(site_url('scholarship/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            
                              <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?> 
                            
                                <select  class="form-control col-md-7 col-xs-12" style="width:auto;" id="filter_school_id"  name="school_id"  onchange="get_class_by_school(this.value, '');">
                                        <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                                <select  class="form-control col-md-7 col-xs-12" id="filter_class_id" name="class_id"  style="width:auto;" onchange="this.form.submit();">
                                     <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                         
                                </select>
                            
                             <?php }else{  ?> 

                                <select  class="form-control col-md-7 col-xs-12"   id="filter_class_id"  name="class_id"  onchange="this.form.submit();">
                                    <?php if($this->session->userdata('role_id') != STUDENT){ ?>
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php } ?>  
                                    <?php foreach($classes as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT ){ ?>
                                            <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>                                            
                                                 <?php if (!in_array($obj->id, $guardian_class_data)) { continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>                                            
                                                 <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?>                                           
                                    <?php } ?>                                            
                                </select>
                            
                            <?php } ?> 
                            
                            <?php echo form_close(); ?>
                           
                        </li>       
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_scholarship_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>  
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                        <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('candidate'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                        <th> <?php echo $this->lang->line('amount'); ?></th>
                                        <th><?php echo $this->lang->line('payment_date'); ?> </th>
                                        <th><?php echo $this->lang->line('note'); ?> </th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                          
                                    <?php $count = 1; if(isset($scholarships) && !empty($scholarships)){ ?>
                                        <?php foreach($scholarships as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->student_name; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->section; ?></td>
                                            <td><?php echo $obj->roll_no; ?></td>
                                            <td><?php echo $obj->amount; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->payment_date)); ?></td>                                                                                                                                                                                                                                     
                                            <td><?php echo $obj->note; ?></td>
                                            <td>                                                      
                                                <?php if(has_permission(EDIT, 'scholarship', 'scholarship')){ ?>
                                                    <a href="<?php echo site_url('scholarship/edit/'.$obj->id); ?>" title="<?php echo $this->lang->line('edit'); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?> 
                                                <?php if(has_permission(DELETE, 'scholarship', 'scholarship')){ ?>    
                                                    <a href="<?php echo site_url('scholarship/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_scholarship">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('scholarship/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                 <?php $this->load->view('layout/school_list_form'); ?>
                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="candidate_id"><?php echo $this->lang->line('candidate'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="candidate_id"  id="add_candidate_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($candidates) && !empty($candidates)){ ?>
                                                <?php foreach($candidates as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($post) && $post['candidate_id'] == $obj->id){ echo 'selected="selected"'; } ?>><?php echo $obj->student_name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('candidate_id'); ?></div>
                                    </div>
                                </div>
                                                                                                       
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"><?php echo $this->lang->line('amount'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="amount"  id="amount" value="<?php echo isset($post['amount']) ?  $post['amount'] : ''; ?>" placeholder="<?php echo $this->lang->line('amount'); ?>" required="required" type="number">
                                        <div class="help-block"><?php echo form_error('amount'); ?></div>
                                    </div>
                                </div>
                                
                               <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_date"><?php echo $this->lang->line('payment_date'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payment_date"  id="add_payment_date" value="<?php echo isset($post['payment_date']) ?  $post['payment_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('payment_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payment_date'); ?></div>
                                    </div>
                                </div>
                                        
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control" name="note" id="add_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div> 
                                                                                           
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('scholarship/scholarship/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_scholarship">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('scholarship/edit/'.$scholarship->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="candidate_id"><?php echo $this->lang->line('candidate'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="candidate_id"  id="edit_candidate_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($candidates) && !empty($candidates)){ ?>
                                                <?php foreach($candidates as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($scholarship->candidate_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->student_name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('candidate_id'); ?></div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"> <?php echo $this->lang->line('amount'); ?><span class="required"> *</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" value="<?php echo isset($scholarship->amount) ?  $scholarship->amount : ''; ?>" name="old_amount" />
                                            <input  class="form-control col-md-7 col-xs-12"  name="amount"  id="edit_amount" value="<?php echo isset($scholarship->amount) ?  $scholarship->amount : ''; ?>" placeholder="<?php echo $this->lang->line('amount'); ?>" required="required" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('amount'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_date"><?php echo $this->lang->line('payment_date'); ?> <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="payment_date"  id="edit_payment_date" value="<?php echo isset($scholarship->payment_date) ?  date('d-m-Y', strtotime($scholarship->payment_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('payment_date'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('payment_date'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note"  placeholder="<?php echo $this->lang->line('note'); ?>"> <?php echo isset($scholarship->note) ?  $scholarship->note : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                    </div> 

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($scholarship) ? $scholarship->id : $id; ?>" id="id" name="id" />
                                            <a  href="<?php echo site_url('scholarship/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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

<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

<!-- Super admin js START  -->
<script type="text/javascript">
     
    var form = 'add';
    $("document").ready(function() {
        <?php if(isset($scholarship) && !empty($scholarship)){ ?>
            form = 'edit';     
            $(".fn_school_id").trigger('change');   
        <?php } ?>
             
        <?php if(isset($post) && !empty($post)){ ?>
            $(".fn_school_id").trigger('change');          
         <?php } ?>    
    }); 
    
    
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var candidate_id = '';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            candidate_id =  '<?php echo $scholarship->candidate_id; ?>';           
         <?php } ?> 
         <?php if(isset($post) && !empty($post)){ ?>
            candidate_id =  '<?php echo $post['candidate_id']; ?>';           
         <?php } ?>   
             
                   
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('scholarship/get_candidate_by_school'); ?>",
            data   : { school_id:school_id, candidate_id:candidate_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   $('#'+form+'_candidate_id').html(response);                                       
               }
            }
        });
    }); 
    
    
                 
    <?php if(isset($filter_class_id)){ ?>
        get_class_by_school('<?php echo $filter_school_id; ?>', '<?php echo $filter_class_id; ?>');
    <?php } ?>
    
    function get_class_by_school(school_id, class_id){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_class_id').html(response);                     
               }
            }
        });
    }

  </script>
<!-- Super admin js end -->

 <script type="text/javascript">
     
    $('#add_payment_date').datepicker();  
    $('#edit_payment_date').datepicker();  
 
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
      
      
    function get_scholarship_by_class(url){          
        if(url){
            window.location.href = url; 
        }           
    }     
      
    $("#add").validate();   
    $("#edit").validate();   

    function get_scholarship_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }
    
</script> 
