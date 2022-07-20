<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mouse-pointer"></i><small> <?php echo $this->lang->line('manage_online_exam'); ?> </small></h3>
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
                        <li class=""><a href="<?php echo site_url('onlineexam/index'); ?>"  aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'onlineexam', 'onlineexam')){ ?>
                                <li  class=""><a href="<?php echo site_url('onlineexam/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                        <?php } ?>                
                        <?php if(isset($add_question)){ ?>
                            <li  class="active"><a href="#tab_add_question"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('add_question'); ?></a> </li>                          
                        <?php } ?>                
                                                    
                            <li class="li-class-list"> 
                                
                                <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                                <?php $teacher_access_data = get_teacher_access_data(); ?>  

                                <?php echo form_open(site_url('onlineexam/addquestion'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                    
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id" id="filter_school_id" onchange="get_class_by_school(this.value, '', '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select> 
                                 
                                 <?php } ?>
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="class_id" id="filter_class_id" onchange="get_subject_by_class(this.value, '', '');" style="width: auto;">
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
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="filter_subject_id" onchange="get_online_exam_by_subject(this.value, '', '`');" style="width: auto;">                                
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    </select> 
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="online_exam_id" id="filter_online_exam_id" style="width: auto;"> 
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                   
                                    </select> 
                                  <input type="submit" name="find" value="<?php echo $this->lang->line('find'); ?>"  class="btn btn-success btn-sm"/>
                                <?php echo form_close(); ?>                                        
                        </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">  
                        <div  class="tab-pane fade in active" id="tab_add_question">
                            <div class="x_content">
                                
                                <div class="col-md-9 col-sm-9 col-xs-12 " >
                                    <div class="row"> 
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0; padding: 0;">
                                        <h3 class="head-title head-sub-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('question_bank'); ?> </small></h3>
                                        <table id="datatable-responsive_" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line('sl_no'); ?></th> 
                                                     <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                        <th><?php echo $this->lang->line('school'); ?></th>
                                                    <?php } ?>
                                                    <th><?php echo $this->lang->line('question_type'); ?></th>
                                                    <th><?php echo $this->lang->line('question_lebel'); ?></th>
                                                    <th><?php echo $this->lang->line('question'); ?></th>
                                                    <th><?php echo $this->lang->line('action'); ?></th>                                            
                                                </tr>
                                            </thead>
                                            <tbody>                                      
                                                <?php $count = 1; if(isset($questions) && !empty($questions)){ ?>
                                                    <?php foreach($questions as $obj){ ?>                                  
                                                    <tr>
                                                        <td><?php echo $count++; ?></td>  
                                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                            <td><?php echo $obj->school_name; ?></td>
                                                        <?php } ?>
                                                         <td><?php echo get_question_type($obj->question_type);  ?></td>
                                                        <td><?php echo $this->lang->line($obj->question_level); ?></td>
                                                        <td><?php echo $obj->question; ?></td>
                                                        <td>
                                                            <?php if(has_permission(ADD, 'onlineexam', 'question')){ ?>
                                                            <a href="javascript:void(0);" onclick="add_question_to_exam('<?php echo $obj->id; ?>');" class="btn btn-info btn-xs"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add_to_exam'); ?> </a>
                                                            <?php } ?>

                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12 online-exam-box" style="margin: 0;">
                                            <input type="hidden" name="school_id" id="school_id" value="<?php echo $school_id; ?>"  />
                                            <input type="hidden" name="online_exam_id" id="online_exam_id" value="<?php echo $online_exam_id; ?>"  />
                                            <h3 class="head-title head-sub-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('exam_question'); ?> </small></h3>
                                            <div class="fn_associated_question">
                                                <?php if(isset($exam_questions) && !empty($exam_questions)){ ?>
                                                    <?php foreach($exam_questions AS $key=>$obj){ ?>
                                                        <?php echo get_question_detail( $obj->online_exam_id, $obj->question_id, $key+1); ?>                                                            
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                   
                                <div class="col-md-3 col-sm-3 col-xs-12 " >   
                                    <div class="online-exam-box" >
                                        <h3 class="head-title head-sub-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('online_exam'); ?> </small></h3>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('exam_title'); ?> :</span><?php echo $online_exam->title; ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('class'); ?> :</span><?php echo $online_exam->class_name; ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('section'); ?> :</span><?php echo $online_exam->section; ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('subject'); ?> :</span><?php echo $online_exam->subject; ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('instruction'); ?> :</span><?php echo $online_exam->ins_title; ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('duration'); ?> :</span><?php echo $online_exam->duration; ?> (Minute)
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('start_date'); ?> :</span><?php echo date($this->global_setting->date_format, strtotime($online_exam->start_date)); ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('end_date'); ?> :</span><?php echo date($this->global_setting->date_format, strtotime($online_exam->end_date)); ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('mark_type'); ?> :</span><?php echo $this->lang->line($online_exam->mark_type); ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('pass_mark'); ?> :</span><?php echo $online_exam->pass_mark; ?>
                                        </div>                                        
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('is_publish'); ?> :</span><?php echo $online_exam->is_publish ? $this->lang->line('yes') : $this->lang->line('no'); ?>
                                        </div>                                       
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('is_active'); ?> :</span><?php echo $online_exam->status ? $this->lang->line('yes') : $this->lang->line('no'); ?>
                                        </div>
                                        <div class="online-exam-info">
                                            <span><?php echo $this->lang->line('note'); ?> :</span><?php echo $online_exam->note; ?>
                                        </div>
                                    </div>
                                </div>                                    
                               
                            </div>             
                        </div>
                     </div>    
                </div>
            </div>
        </div>
    </div>
</div>


 <script type="text/javascript">     

    function add_question_to_exam(question_id){ 
        
        var school_id = $('#school_id').val();
        var online_exam_id = $('#online_exam_id').val();
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('onlineexam/add_question_to_exam'); ?>",
            data   : {school_id:school_id, online_exam_id : online_exam_id, question_id:question_id},               
            async  : false,
            success: function(response){                                                   
               if(response == 1){
                   toastr.error('<?php echo $this->lang->line('question_added_failed'); ?>');                                     
               }else if(response == 2){                   
                   toastr.error('<?php echo $this->lang->line('question_already_added'); ?>');
               }else{
                   toastr.success('<?php echo $this->lang->line('question_added_success'); ?>'); 
                   $('.fn_associated_question').append(response); 
               }
            }
        });  
    }
    
    function remove_exam_question(online_exam_id,question_id, obj){
        
        var school_id = $('#school_id').val();
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('onlineexam/remove_question_from_exam'); ?>",
            data   : {school_id:school_id, online_exam_id : online_exam_id, question_id:question_id},               
            async  : false,
            success: function(response){ 
                console.log(response);
               if(response){
                   toastr.success('<?php echo $this->lang->line('delete_success'); ?>'); 
                   $(obj).parents('.question-container').remove(); 
               }else{
                   toastr.error('<?php echo $this->lang->line('delete_failed'); ?>');                   
               }
            }
        });  
    }

 </script>
 
 
 <script type="text/javascript">

    <?php if(isset($filter_school_id) && $filter_school_id != '' && isset($filter_class_id)){ ?>
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
     

    <?php if(isset($filter_class_id) && $filter_class_id != '' && isset($filter_subject_id)){ ?>
        get_subject_by_class('<?php echo $filter_class_id; ?>', '<?php echo $filter_subject_id; ?>');
    <?php } ?>
        
    function get_subject_by_class(class_id, subject_id){       
           
        var school_id = $('#filter_school_id').val();       
        if(!school_id){
            school_id = '<?php echo $school_id; ?>';
        }  
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id : subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   $('#filter_subject_id').html(response);                  
               }
            }
        });
   }
   

    <?php if(isset($filter_subject_id) && $filter_subject_id != '' && isset($online_exam_id)){ ?>
        get_online_exam_by_subject('<?php echo $filter_subject_id; ?>', '<?php echo $online_exam_id; ?>');
    <?php } ?>
    
    function get_online_exam_by_subject(subject_id, online_exam_id){       
         
        var school_id = $('#filter_school_id').val();      
        if(!school_id){
            school_id = '<?php echo $school_id; ?>';
        }  
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('onlineexam/get_online_exam_by_subject'); ?>",
            data   : {school_id:school_id, subject_id : subject_id, online_exam_id : online_exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#filter_online_exam_id').html(response);
               }
            }
        }); 
   }

</script>

 <!-- datatable with buttons -->
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
          search: true,              
          responsive: true
      });
    }); 
    
</script>
 