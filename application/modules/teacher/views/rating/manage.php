<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-star"></i><small> <?php echo $this->lang->line('manage_rating'); ?></small></h3>
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
                        
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_rating_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                            
                        <li class="li-class-list">
                            <?php echo form_open(site_url('teacher/rating/manage'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id"  onchange="get_teacher_by_school(this.value, '');">
                                        <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                         <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>
                                    <select  class="form-control col-md-7 col-xs-12" id="filter_teacher_id" name="teacher_id"  style="width:auto;" onchange="this.form.submit();">
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    </select>
                            <?php }else{ ?>
                                <select  class="form-control col-md-7 col-xs-12" id="filter_teacher_id" name="teacher_id"  style="width:auto;" onchange="this.form.submit();">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php foreach($teachers as $obj ){ ?>
                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_teacher_id) && $filter_teacher_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?> 
                                </select>
                             <?php }?>
                            <?php echo form_close(); ?>
                        </li>
                    </ul>
                    
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_rating_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                           <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('photo'); ?></th> 
                                        <th><?php echo $this->lang->line('teacher'); ?></th> 
                                        <th><?php echo $this->lang->line('department'); ?>Department</th> 
                                        <th><?php echo $this->lang->line('rating'); ?></th> 
                                        <th><?php echo $this->lang->line('comment'); ?></th>                                         
                                        <th><?php echo $this->lang->line('student'); ?></th>                                         
                                        <th><?php echo $this->lang->line('action'); ?></th> 
                                    </tr>
                                </thead>
                                <tbody>   
                                    
                                    <?php $count = 1; if(isset($ratings) && !empty($ratings)){ ?>
                                        <?php foreach($ratings as $obj){ ?> 
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                               <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td>
                                                <?php  if($obj->photo != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $obj->photo; ?>" alt="" width="50" /> 
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="50" /> 
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $obj->teacher; ?></td>
                                            <td><?php echo $obj->department; ?></td>
                                            <td>                                                
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                        <span class="fa fa-star" <?php if($obj->rating >= $i) { echo 'style="color:orange;"'; }else{  echo 'style="color:gray;"';} ?>></span>
                                                <?php } ?>                                               
                                            </td>                                      
                                            <td><?php echo $obj->comment; ?></td>                                             
                                            <td><?php echo $obj->student_name; ?></td>  
                                            <td>
                                                <?php  if($obj->rating_status == 'pending'){ ?>
                                                    <a  onclick="update_rating(<?php echo $obj->id; ?>, 'approved');"   class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('approve'); ?></a>
                                                <?php }else{ ?>
                                                    <a  onclick="update_rating(<?php echo $obj->id; ?>, 'pending');"   class="btn btn-danger btn-xs"><i class="fa fa-close"></i> <?php echo $this->lang->line('pending'); ?></a>
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
     
    function get_teacher_by_id(url){          
        if(url){
            window.location.href = url; 
        }
    }
    
    
    <?php if(isset($filter_teacher_id)){ ?>
        get_teacher_by_school('<?php echo $filter_school_id; ?>', '<?php echo $filter_teacher_id; ?>');
    <?php } ?>
    
    function get_teacher_by_school(school_id, teacher_id){        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_teacher_by_school'); ?>",
            data   : { school_id : school_id, teacher_id : teacher_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_teacher_id').html(response);                     
               }
            }
        });
    }
        
    function update_rating(rating_id, status) {
      
        $.ajax({
            url: '<?php echo site_url('teacher/rating/approve_rating'); ?>',
            type: "POST",
            data: { rating_id : rating_id, status:status},                             
            success: function () {                
                toastr.success('<?php echo $this->lang->line('update_success'); ?>');
                window.location.reload(true);               
            },
            error: function () {}
        });
        
    };
       
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
     
</script>
<style type="text/css">
    .rating .fa{
        color:orange;        
    }
 </style> 