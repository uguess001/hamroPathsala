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
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_rating_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th> 
                                        <th><?php echo $this->lang->line('photo'); ?></th> 
                                        <th><?php echo $this->lang->line('teacher'); ?></th> 
                                        <th><?php echo $this->lang->line('department'); ?></th> 
                                        <th><?php echo $this->lang->line('rating'); ?></th> 
                                        <th><?php echo $this->lang->line('status'); ?></th> 
                                        <th><?php echo $this->lang->line('comment'); ?></th> 
                                        <th><?php echo $this->lang->line('action'); ?></th> 
                                    </tr>
                                </thead>
                                <tbody>   
                                    
                                    <?php $count = 1; if(isset($teacher_list) && !empty($teacher_list)){ ?>
                                        <?php foreach($teacher_list as $obj){ ?> 
                                        <?php $rating = get_teacher_rating($obj->id); ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <td>
                                                <?php  if($obj->photo != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $obj->photo; ?>" alt="" width="50" /> 
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="50" /> 
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $obj->name; ?></td>
                                            <td><?php echo $obj->department; ?></td>
                                            <td>
                                                <?php if(isset($rating) && !empty($rating)){ ?>
                                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="fa fa-star" <?php if($rating->rating >= $i) { echo 'style="color:orange;"'; }else{  echo 'style="color:gray;"';} ?>></span>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>                                            
                                            <td><?php echo isset($rating) ? $this->lang->line($rating->rating_status) : ''; ?></td>                                             
                                            <td><?php echo isset($rating) ? $rating->comment : ''; ?></td>    
                                            <td>
                                                <?php if(empty($rating)){ ?>
                                                    <?php if(has_permission(ADD, 'teacher', 'rating')){ ?>                                                   
                                                        <a  onclick="get_rating_modal('<?php echo $obj->school_id; ?>', '<?php echo $obj->id; ?>');"  data-toggle="modal" data-target=".bs-rating-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-star"></i> <?php echo $this->lang->line('rate'); ?></a>
                                                    <?php } ?>
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

<div class="modal fade bs-rating-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_rating_data">            
        </div>       
      </div>
    </div>
</div>

<!-- datatable with buttons -->
<script type="text/javascript">
         
    function get_rating_modal(school_id, teacher_id){
         
        $('.fn_rating_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('teacher/rating/get_rating_form'); ?>",
          data   : {school_id:school_id, teacher_id : teacher_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_rating_data').html(response);
             }
          }
       });
    }
</script>

 <script type="text/javascript">
     
    function get_rating(rate) {

        $('#rating').val(rate);

        for (i = 1; i <= 5; i++) {
            $("#rating_" + i).attr("style", "color:gray;");
        }

        for (i = 1; i <= rate; i++) {
            $("#rating_" + i).attr("style", "color:#ffb500f0;");
        }

    }
    
    function save_rating() {
      
        $.ajax({
            url: '<?php echo site_url('teacher/rating/save_rating'); ?>',
            type: "POST",
            data: { teacher_id : $('#teacher_id').val(), rating : $('#rating').val(), comment : $('#comment').val()},
            dataType: 'json',                    
            success: function (response) {
                if (response.status == "error") {
                    var message = "";
                    $.each(response.error, function (index, value) {
                        message += value;
                    });
                    toastr.error(message);
                } else {
                    toastr.success(response.success);
                    window.location.reload(true);
                }
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