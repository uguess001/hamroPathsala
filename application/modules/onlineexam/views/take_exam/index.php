<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mouse-pointer"></i><small> <?php echo $this->lang->line('manage_take_exam'); ?> </small></h3>
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
                    
                    <ul  class="nav nav-tabs nav-tab-find bordered">
                        
                        <?php if(isset($instruction)){ ?>
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="<?php echo site_url('onlineexam/takeexam/index'); ?>"  aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php }else{ ?>
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_exam_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php } ?>
                        
                        <?php if(has_permission(VIEW, 'onlineexam', 'takeexam')){ ?>
                            <?php if(isset($instruction)){ ?>
                                <li  class="<?php if(isset($instruction)){ echo 'active'; }?>"><a href=""  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('instruction'); ?></a> </li>                          
                             <?php } ?>                               
                        <?php } ?>                
                                        
                        
                        <li class="li-class-list">
                                
                             <?php $guardian_access_data = get_guardian_access_data('class');  ?>
                             <?php $teacher_access_data = get_teacher_access_data(); ?>    
                                
                            <?php echo form_open(site_url('onlineexam/takeexam/index'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="class_id" id="filter_class_id" onchange="get_subject_by_class_filter(this.value, '');" style="width: auto;">
                                    <?php if($this->session->userdata('role_id') != STUDENT){ ?>
                                       <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php } ?>        
                                    <?php foreach($classes as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                            <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php }else{ ?> 
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php } ?>                                                                                     
                                    <?php } ?>                                            
                                </select> 
                                <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="filter_subject_id" style="width: auto;">                                
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php foreach($subjects as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT){ ?>                                       
                                            <option value="<?php $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php } ?>                                                                                     
                                    <?php } ?>                                            
                                </select> 
                                <input type="submit" name="find" value="<?php echo $this->lang->line('find'); ?>"  class="btn btn-info btn-sm"/>
                            <?php echo form_close(); ?>
                        </li>
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_exam_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>   
                                        <th><?php echo $this->lang->line('exam_title'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('total_question'); ?></th>
                                        <th><?php echo $this->lang->line('is_publish'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>  
                                    
                                    <?php $count = 1; if(isset($online_exams) && !empty($online_exams)){ ?>
                                        <?php foreach($online_exams as $obj){ ?>
                                        <?php 
                                            if($this->session->userdata('role_id') == STUDENT){
                                                if ($obj->class_id != $this->session->userdata('class_id')){ continue; }                                          
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>                                           
                                            <td><?php echo $obj->title; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->subject; ?></td>
                                            <td><?php echo get_total_question_by_exam($obj->id); ?></td>
                                            <td><?php echo $obj->is_publish ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td>
                                                <?php if(has_permission(VIEW, 'onlineexam', 'takeexam')){ ?>
                                                    <a href="<?php echo site_url('onlineexam/takeexam/instruction/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('start_exam'); ?> </a>
                                                <?php } ?>                                                    
                                            </td>
                                        </tr>
                                        
                                        <?php } ?>
                                    <?php } ?>
                                        
                                </tbody>
                            </table>
                            </div>
                        </div>                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <script type="text/javascript">
     
      <?php if(isset($filter_class_id) && $filter_class_id != '' && isset($filter_subject_id)){ ?>
        get_subject_by_class_filter('<?php echo $filter_class_id; ?>', '<?php echo $filter_subject_id; ?>');
    <?php } ?>
        
    function get_subject_by_class_filter(class_id, subject_id){       
        
        var school_id =  '<?php echo $filter_school_id; ?>'; 
        
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

    function get_exam_list_by_class(url){          
        if(url){
            window.location.href = url; 
        }
    } 
    
</script>
 