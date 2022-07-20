<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-gears "></i><small> <?php echo $this->lang->line('setting_opening_hour'); ?></small></h3>
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
                        <li  class="active"><a href="#tab_ohour"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('opening_hour'); ?></a> </li> 
                     </ul>
                     <br/>
                     <div class="tab-content">
                         <div class="tab-pane fade in active"id="tab_ohour">
                            <div class="x_content"> 
                                <?php $action = isset($openinghour) ? 'edit' : 'add'; ?>
                                <?php echo form_open_multipart(site_url('setting/openinghour/'. $action), array('name' => 'setting', 'id' => 'setting', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                <input type="hidden" value="<?php echo isset($openinghour) ? $openinghour->id : ''; ?>" name="id" />
                               
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                               
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monday"><?php echo $this->lang->line('monday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $monday = explode('-', $openinghour->monday);
                                           $monday_1 = isset($monday[0]) ? $monday[0] : '';
                                           $monday_2 = isset($monday[1]) ? $monday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="monday_1"  id="monday_1" value="<?php  echo $monday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="monday_2"  id="monday_2" value="<?php  echo $monday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('monday'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tuesday"><?php echo $this->lang->line('tuesday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $tuesday = explode('-', $openinghour->tuesday);
                                           $tuesday_1 = isset($tuesday[0]) ? $tuesday[0] : '';
                                           $tuesday_2 = isset($tuesday[1]) ? $tuesday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="tuesday_1"  id="tuesday_1" value="<?php echo $tuesday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="tuesday_2"  id="tuesday_2" value="<?php echo $tuesday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('tuesday'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wednesday"><?php echo $this->lang->line('wednesday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $wednesday = explode('-', $openinghour->wednesday);
                                           $wednesday_1 = isset($wednesday[0]) ? $wednesday[0] : '';
                                           $wednesday_2 = isset($wednesday[1]) ? $wednesday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="wednesday_1"  id="wednesday_1" value="<?php  echo $wednesday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="wednesday_2"  id="wednesday_2" value="<?php  echo $wednesday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('wednesday'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="thursday"><?php echo $this->lang->line('thursday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $thursday = explode('-', $openinghour->thursday);
                                           $thursday_1 = isset($thursday[0]) ? $thursday[0] : '';
                                           $thursday_2 = isset($thursday[1]) ? $thursday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="thursday_1"  id="thursday_1" value="<?php echo $thursday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="thursday_2"  id="thursday_2" value="<?php echo $thursday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('thursday'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="friday"><?php echo $this->lang->line('friday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $friday = explode('-', $openinghour->friday);
                                           $friday_1 = isset($friday[0]) ? $friday[0] : '';
                                           $friday_2 = isset($friday[1]) ? $friday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="friday_1"  id="friday_1" value="<?php echo $friday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="friday_2"  id="friday_2" value="<?php echo $friday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('friday'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="saturday"><?php echo $this->lang->line('saturday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $saturday = explode('-', $openinghour->saturday);
                                           $saturday_1 = isset($saturday[0]) ? $saturday[0] : '';
                                           $saturday_2 = isset($saturday[1]) ? $saturday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="saturday_1"  id="saturday_1" value="<?php echo $saturday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="saturday_2"  id="saturday_2" value="<?php echo $saturday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('saturday'); ?></div>
                                    </div>
                                </div>
                              
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sunday"><?php echo $this->lang->line('sunday'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <?php
                                           $sunday = explode('-', $openinghour->sunday);
                                           $sunday_1 = isset($sunday[0]) ? $sunday[0] : '';
                                           $sunday_2 = isset($sunday[1]) ? $sunday[1] : '';
                                        ?>
                                        
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="sunday_1"  id="sunday_1" value="<?php echo $sunday_1; ?>" type="text" autocomplete="off">
                                        <span class="separate"> <=> </span>
                                        <input  class="form-control col-md-3 col-xs-6 timepicker"  name="sunday_2"  id="sunday_2" value="<?php echo $sunday_2; ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('sunday'); ?></div>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>

                                <?php echo form_close(); ?>
                            </div>  
                        </div>  
                     </div>
                </div>
             </div>
        </div>
    </div>
</div>

<style type="text/css">
    .timepicker{
       width: 30%;
       margin-right: 10px;
    }
    .separate{
        float: left;
        padding-right: 10px;
        padding-top: 5px;
    }
</style>

<link href="<?php echo VENDOR_URL; ?>timepicker/timepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>timepicker/timepicker.js"></script>

<script type="text/javascript">
    $('.timepicker').timepicker({defaultTime: ''}); 
    $("#setting").validate();      
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
        
        $("#add").validate();  
        $("#edit").validate();  
     
</script>
