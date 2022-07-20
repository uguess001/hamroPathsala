<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-upload"></i><small> <?php echo $this->lang->line('manage_submission'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_submission_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('evaluate'); ?></a> </li>
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_submission_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>   
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th width='25%'><?php echo $this->lang->line('assignment'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('submitted_by'); ?></th>
                                        <th><?php echo $this->lang->line('submitted_at'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>      
				    <?php $evaluate_sttaus = get_evaluation_status(); ?> 
				    <?php $guardian_access_std_data = get_guardian_access_data('student'); ?> 
                                    <?php $count = 1; if(isset($submissions) && !empty($submissions)){ ?>
                                        <?php foreach($submissions as $obj){ ?>
                                        <?php 
                                            if($this->session->userdata('role_id') == GUARDIAN){
                                                if (!in_array($obj->student_id, $guardian_access_std_data)){ continue; }
                                            }elseif($this->session->userdata('role_id') == TEACHER){
                                                if (!in_array($obj->class_id, $teacher_access_data)){ continue; }
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>                                            
                                            <td><?php echo $obj->title; ?></td>
                                             <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->section; ?></td>
                                            <td><?php echo $obj->subject; ?></td>
                                            <td><?php echo $obj->student_name; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->submitted_at)); ?></td>
                                            <td>
                                                <select  class="form-control col-md-7 col-xs-12 status-type  gsms-nice-select_"  name="evaluation_status"  id="evaluation_status" onchange="update_evatioation_status('<?php echo $obj->id; ?>', this.value);" style="height: 23px;margin-right: 10px;">
                                                    <?php foreach($evaluate_sttaus AS $key=>$value){ ?>
                                                        <option value="<?php echo $key; ?>" <?php echo $obj->evaluation_status == $key ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line($key); ?></option>
                                                    <?php } ?>
                                                </select>                                              
                                               
                                                <?php if(has_permission(VIEW, 'academic', 'submission')){ ?>
                                                    <a  onclick="get_submission_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-submission-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                    <?php if($obj->submission){ ?>
                                                        <a target="_blank" href="<?php echo UPLOAD_PATH; ?>assignment-submission/<?php echo $obj->submission; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?> </a>
                                                    <?php  } ?>
                                                <?php  } ?>                                                
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


<div class="modal fade bs-submission-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_submission_data">
            
        </div>       
      </div>
    </div>
</div>

<script type="text/javascript">
         
    function get_submission_modal(submission_id){
         
        $('.fn_submission_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('academic/submission/get_single_submission'); ?>",
          data   : {submission_id : submission_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_submission_data').html(response);
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
          search: true,              
          responsive: true
      });

     });
     
    function update_evatioation_status(submission_id, status){        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('academic/submission/update_evatioation_status'); ?>",
            data   : { submission_id : submission_id, status : status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                   toastr.success('<?php echo $this->lang->line('update_success'); ?>');
                   location.reload();
                   return false;                    
               }
            }
        });
    }   
    
</script>