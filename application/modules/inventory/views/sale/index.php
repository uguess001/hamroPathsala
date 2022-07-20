<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title no-print">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_sale'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link no-print">
                <?php $this->load->view('quick-link'); ?>                 
            </div>
            
            <div class="x_content no-print">
                <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_sale_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'inventory', 'sale')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('inventory/sale/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_sale"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_sale"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?> 
                            
                        <li class="li-class-list">
                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_sale_by_school(this.value);">
                                        <option value="<?php echo site_url('inventory/sale/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('inventory/sale/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  
                        </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_sale_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                         <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                           <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('invoice_number'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?>/<?php echo $this->lang->line('sale_to'); ?></th>
                                        <th><?php echo $this->lang->line('gross_amount'); ?></th>
                                        <th><?php echo $this->lang->line('discount'); ?></th>
                                        <th><?php echo $this->lang->line('net_amount'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                               
                                    </tr>
                                </thead>
                                <tbody>   
                                                               
                                    <?php $count = 1; if(isset($sales) && !empty($sales)){ ?>
                                        <?php foreach($sales as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                               <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->custom_invoice_id; ?></td>
                                            <td>
                                                <?php
                                                    $user = get_user_by_role($obj->role_id, $obj->user_id);
                                                ?>
                                                <?php echo  $user->name; ?> [<?php echo  $user->role; ?>]<br>                
                                                <?php
                                                if($user->role_id == STUDENT){
                                                        echo $this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '. $this->lang->line('roll_no'). ':'. $user->roll_no;
                                                    }
                                                ?>                                                
                                            </td>
                                            <td><?php echo $obj->gross_amount; ?></td>
                                            <td><?php echo $obj->discount; ?></td>
                                            <td><?php echo $obj->net_amount; ?></td>
                                            <td><?php echo get_paid_status($obj->paid_status); ?></td>
                                            <td>                                                      
                                                <?php if(has_permission(VIEW, 'inventory', 'sale')){ ?>
                                                    <a  onclick="get_sale_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-sale-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                     <?php if($obj->paid_status != 'paid'){ ?>
                                                        <a href="<?php echo site_url('accounting/payment/index/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('pay_now'); ?></a>
                                                    <?php } ?> 
                                                <?php } ?>
                                               
                                                <?php if(has_permission(DELETE, 'inventory', 'sale') && $obj->paid_status == 'unpaid'){ ?>    
                                                    <a href="<?php echo site_url('inventory/sale/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_sale">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('inventory/sale/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <div class="row">  
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/school_list_form'); ?>
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        
                                        <div class="item form-group">
                                            <h5  class="column-title"><strong><?php echo $this->lang->line('sale_information'); ?>:</strong></h5>
                                        </div>
                                        
                                        <div class="item form-group">
                                            <label for="role_id"><?php echo $this->lang->line('user_type'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="add_role_id" required="required" onchange="get_user_by_role(this.value, '', 'add');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                                <?php foreach($roles as $obj ){  ?>
                                                    <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                    <?php if(in_array($obj->id, array(GUARDIAN))){ continue;} ?>
                                                    <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                    <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('role_id'); ?></div> 
                                        </div>

                                        <div class="item form-group display">
                                            <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="add_class_id"  onchange="get_user('', this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php foreach($classes as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>

                                        <div class="item form-group">
                                            <label for="user_id"><?php echo $this->lang->line('sale_to'); ?> <span class="required">*</span></label>
                                                <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="add_user_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                        </div>
                                        
                                        <div class="item form-group">
                                            <label for="income_head_id"><?php echo $this->lang->line('income_head'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-12 col-xs-12"  name="income_head_id"  id="add_income_head_id"  >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php foreach($income_heads as $obj ){ ?>
                                                    <option value="<?php echo $obj->id; ?>"  ><?php echo $obj->title; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('income_head_id'); ?></div>
                                        </div>

                                        <div class="item form-group">
                                            <label for="date"><?php echo $this->lang->line('date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="date"  id="add_date" value="" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('date'); ?></div>
                                        </div> 
                                        
                                        <div class="item form-group">
                                            <label for="note"><?php echo $this->lang->line('note'); ?> </label>
                                            <textarea  class="form-control" name="note" id="note" style="height: 60px;"></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                          
                                    </div>
                                        
                                    <div class="col-md-8 col-sm-8 col-xs-12">                                          
                                        <div class="row">                  
                                           <div class="col-md-12 col-sm-12 col-xs-12">
                                               <h5  class="column-title">
                                                   <strong><?php echo $this->lang->line('item_information'); ?>:</strong>
                                                   <a onclick="add_more_product('add');" class="btn btn-success btn-xs right" style="float: right;"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add_more'); ?> </a>
                                               </h5>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="col-md-12 col-sm-12 col-xs-12">
                                           <table id="_datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                               <thead>
                                                   <tr>
                                                       <th><?php echo $this->lang->line('sl_no'); ?></th>                                                 
                                                       <th><?php echo $this->lang->line('category'); ?></th>
                                                       <th><?php echo $this->lang->line('product'); ?></th>
                                                       <th> <?php echo $this->lang->line('quantity'); ?></th>
                                                       <th> <?php echo $this->lang->line('unit_price'); ?></th>
                                                       <th><?php echo $this->lang->line('subtotal'); ?></th>
                                                       <th><?php echo $this->lang->line('action'); ?></th>                                            
                                                   </tr>
                                               </thead>

                                               <tbody class="fn_add_product_container"> 
                                                   <?php $unique_id = time();  ?>
                                                   <tr class="fn_add_product_item">
                                                       <td class="fn_add_item_count">1</td>
                                                       <td>
                                                           <input type="hidden" id="default_category" value="<?php echo $unique_id; ?>" />
                                                           <select  class="form-control col-md-7 col-xs-12"  name="category_id[]"  id="add_category_id_<?php echo $unique_id; ?>" onchange="get_product_by_category(this, this.value, '', 'add'); reset_total_price(this, 'add');">
                                                               <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                               <?php if(isset($categories) && !empty($categories)){ ?>
                                                                   <?php foreach($categories as $obj){ ?>
                                                                       <option value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option>
                                                                   <?php } ?>
                                                               <?php } ?>
                                                           </select>
                                                       </td>
                                                       <td>
                                                           <select  class="form-control col-md-12 col-xs-12 fn_add_product_count"  name="product_id[]"  id="add_product_id_<?php echo $unique_id; ?>" onchange="reset_total_price(this, 'add');">
                                                               <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                                           </select>
                                                       </td>
                                                       <td>
                                                           <input  class="form-control col-md-7 col-xs-12 fn_add_qty_count"  name="qty[]"  id="add_qty_<?php echo $unique_id; ?>" onkeyup="check_quantity(this, 'add');" value="0" type="number">
                                                       </td>
                                                       <td>
                                                           <input  class="form-control col-md-7 col-xs-12"  name="unit_price[]"  id="add_unit_price_<?php echo $unique_id; ?>" onkeyup="claculate_total_price(this, '', 'add');" value="0" type="number">
                                                       </td>
                                                       <td>
                                                           <input  class="form-control col-md-7 col-xs-12 fn_add_total_price_count"  name="total_price[]"  id="add_total_price_<?php echo $unique_id; ?>" value="0"  type="number" readonly="readonly">
                                                       </td>
                                                       <td>
                                                           <input type="hidden" name="unique_id" id="add_unique_id_<?php echo $unique_id; ?>" class="fn_unique_id" value="<?php echo $unique_id; ?>" />
                                                           <a href="javascript:void();" onclick="remove_product_item(this, 'add');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                       </td>
                                                   </tr>
                                               </tbody>
                                           </table>
                                           </div>
                                       </div>                                 

                                       <div class="row">                  
                                           <div class="col-md-12 col-sm-12 col-xs-12">
                                               <h5  class="column-title"><strong><?php echo $this->lang->line('payment_information'); ?>:</strong></h5>
                                           </div>
                                       </div>
                                       <div class="row">                                    
        
                                           <div class="col-md-3 col-sm-3 col-xs-12">
                                               <div class="item form-group">
                                                   <label for="paid_status"><?php echo $this->lang->line('paid_status'); ?> <span class="required">*</span></label>
                                                    <select  class="form-control col-md-7 col-xs-12" name="paid_status" id="add_paid_status" required="required"  onchange="check_paid_status(this.value, 'add');">
                                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                                        <option value="paid"><?php echo $this->lang->line('paid'); ?></option>                                           
                                                        <option value="partial"><?php echo $this->lang->line('partial'); ?></option>                                           
                                                        <option value="unpaid"><?php echo $this->lang->line('unpaid'); ?></option>                                           
                                                    </select>
                                                   <div class="help-block"><?php echo form_error('paid_status'); ?></div>
                                               </div>
                                           </div>
                                           
                                           <div class="display fn_add_paid_status">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                                    <select  class="form-control col-md-7 col-xs-12"  name="payment_method"  id="add_payment_method" required="required" onchange="check_payment_method(this.value, 'add');">
                                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                        <?php $payments = get_payment_methods(); ?>
                                                        <?php foreach($payments as $key=>$value ){ ?>
                                                            <?php if(in_array($key, array('cheque', 'cash','receipt'))){ ?>
                                                            <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                                            <?php } ?>                                            
                                                        <?php } ?>                                            
                                                    </select>
                                                    <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                                </div>
                                            </div>
                                               
                                           </div> 

                                           <!-- For cheque Start-->
                                           <div class="display fn_add_cheque">

                                               <div class="col-md-3 col-sm-3 col-xs-12">
                                                   <div class="item form-group">
                                                       <label for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span></label>
                                                       <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="add_bank_name" value="" placeholder="<?php echo $this->lang->line('bank_name'); ?>"  type="text" autocomplete="off">
                                                       <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 col-sm-3 col-xs-12">
                                                   <div class="item form-group">
                                                       <label for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span></label>
                                                       <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="add_cheque_no" value="" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text" autocomplete="off">
                                                       <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                                   </div>
                                               </div>

                                           </div>
                                          <!-- For cheque END--> 
                                           
                                            <!-- For bank_receipt Start-->
                                            <div class="display fn_add_receipt" >
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="bank_receipt"><?php echo $this->lang->line('bank_receipt'); ?> <span class="required">*</span></label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="bank_receipt"  id="add_bank_receipt" value="" placeholder="<?php echo $this->lang->line('bank_receipt'); ?> "  type="text" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('bank_receipt'); ?></div>
                                                </div>                                     
                                                </div>                                     
                                            </div>
                                        <!-- For bank_receipt End-->
                                       </div>
                                           
                                        <div class="row">  
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                               <div class="item form-group">
                                                   <label for="discount"><?php echo $this->lang->line('discount'); ?></label>
                                                   <input  class="form-control col-md-7 col-xs-12"  name="discount"  id="add_discount" onkeyup="calculate_discount(this, 'add');" value="" type="number" autocomplete="off">
                                                   <div class="help-block"><?php echo form_error('discount'); ?></div>
                                               </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                   <label for="grand_total"><?php echo $this->lang->line('grand_total'); ?> <span class="required">*</span></label>
                                                   <input  name="hidden_grand_total"  id="add_hidden_grand_total" value="" type="hidden" >
                                                   <input  class="form-control col-md-7 col-xs-12"  name="grand_total"  id="add_grand_total" value="" required="required" type="number" autocomplete="off">
                                                   <div class="help-block"><?php echo form_error('grand_total'); ?></div>
                                                </div>
                                            </div>
                                           
                                        </div> 
                                    </div>
                                    
                                </div>
                                
                          
                                                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <a href="<?php echo site_url('inventory/sale/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
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


<?php $this->load->view('sale-modal'); ?> 


<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
  
<script type="text/javascript">
      
    var form = 'add';
    $("document").ready(function() {
        <?php if(isset($filter_school_id) && !empty($filter_school_id)){ ?>
            form = 'edit';
            $(".fn_school_id").trigger('change');
        <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
        get_class_by_school(school_id);
        get_category_by_school(school_id, form);
        get_fee_type_by_school(form);
        
    });
    
    function get_category_by_school(school_id, form){
    
        var default_category = $('#default_category').val();
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/sale/get_category_by_school'); ?>",
            data   : { school_id : school_id},               
            async  : false,
            success: function(response){                                                   
                if(response)
                {  
                   $('#'+form+'_category_id_'+default_category).html(response);  
                }
            }
        });
    }
    
    
    function get_fee_type_by_school(form){       
         
        var school_id = $('#'+form+'_school_id').val();        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/sale/get_fee_type_by_school'); ?>",
            data   : { school_id : school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#'+form+'_income_head_id').html(response);
               }
            }
        });  
    }
    
     
    function get_class_by_school(school_id){        
        
       if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
            $('#add_role_id').prop('selectedIndex',0);
            $('#add_user_id').prop('selectedIndex',0);
            $('#add_class_id').prop('selectedIndex',0);
           return false;
       }
       
       var class_id = '';
        <?php if(isset($class_id)){ ?>
          class_id = <?php echo $class_id; ?>
        <?php } ?>
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#add_class_id').html(response);                     
               }
            }
        });
    }
   
    
 </script> 
 
<script type="text/javascript">
    
    var form = 'add';   
            
    $('#add_date').datepicker();       
    
    function reset_total_price(obj, form){
        
       var unique_id = $(obj).parents('.fn_add_product_item').find('.fn_unique_id').val();
       $('#'+form+'_qty_'+unique_id).val(0);
       $('#'+form+'_unit_price_'+unique_id).val(0);
       $('#'+form+'_total_price_'+unique_id).val(0);
       
       claculate_grand_total(form);
    }
    
    function check_quantity(obj, form){
        
        var unique_id = $(obj).parents('.fn_add_product_item').find('.fn_unique_id').val();
        var category_id = $('#'+form+'_category_id_'+unique_id).val();
        var product_id = $('#'+form+'_product_id_'+unique_id).val();
        var qty = $('#'+form+'_qty_'+unique_id).val();
        var unit_price = $('#'+form+'_unit_price_'+unique_id).val();
        
        var total_qty = 0;
        // we have to process same product qty
         $('.fn_add_product_count').each(function(){
            var prod_id = $(this).val();          
            if(product_id == prod_id){                
                var other_qty = $(this).parent().siblings().find('.fn_add_qty_count').val();
                total_qty += parseFloat(other_qty);
            }
        });
                       
        // first we have to 
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/sale/check_quantity'); ?>",
            data   : { category_id : category_id,  product_id : product_id, qty:total_qty},               
            async  : false,
            success: function(response){                                                   
               if(response == 1)
               {       
                   if(unit_price > 0){
                       claculate_total_price('', unique_id, form);
                   }
                  
               }else{
                   
                    toastr.error('<?php echo $this->lang->line('insufficient_quantity'); ?>'); 
                    $('#'+form+'_qty_'+unique_id).val(0);
                    reset_total_price(obj, form);
               }
            }
        });
    }
        
    function claculate_total_price(obj, unique_id, form){
        
        if(!unique_id){
            unique_id = $(obj).parents('.fn_add_product_item').find('.fn_unique_id').val();
        }
        
        var qty = $('#'+form+'_qty_'+unique_id).val();
        var unit_price = $('#'+form+'_unit_price_'+unique_id).val();
        $('#'+form+'_total_price_'+unique_id).val(qty*unit_price);
               
        // first we have to         
        claculate_grand_total(form);
    }
        
    function claculate_grand_total(form){
               
        var grand_total = 0;
        
        $('.fn_add_total_price_count').each(function(){
           var total_price = $(this).val();
           grand_total += parseFloat(total_price);
        });
        
        $('#'+form+'_discount').val(0);
        $('#'+form+'_grand_total').val(parseFloat(grand_total));
        $('#'+form+'_hidden_grand_total').val(parseFloat(grand_total));
    }
    
    function calculate_discount(obj, form){
        
         var original = $('#'+form+'_hidden_grand_total').val();
         var discount = $('#'+form+'_discount').val();
         if(parseFloat(discount) <=  parseFloat(original)){
            $('#'+form+'_grand_total').val(parseFloat(original)-parseFloat(discount));
         }else{
            var discount = $('#'+form+'_discount').val(0); 
            $('#'+form+'_grand_total').val(parseFloat(original));
         }
    }
            
    function check_paid_status(paid_status, form) {

        if (paid_status == "paid" || paid_status == "partial") {
            
            $('.fn_'+form+'_paid_status').show(); 
            $('#_'+form+'_payment_method').prop('required', true);                

        } else{
            
            $('.fn_'+form+'_cheque').hide();           
            $('.fn_'+form+'_receipt').hide();           
            $('.fn_'+form+'_paid_status').hide();  
            $('#_'+form+'_payment_method').prop('required', false);               
        }

        $('select#_'+form+'_payment_method').prop('selectedIndex', 0);
    }
        
    function check_payment_method(payment_method, form) {

        if (payment_method == "cheque") {  
            
            $('.fn_'+form+'_cheque').show(); 
            $('.fn_'+form+'_receipt').hide(); 
            $('#'+form+'_bank_name').prop('required', true);
            $('#'+form+'_cheque_no').prop('required', true);
            $('#'+form+'_bank_receipt').prop('required', false); 
            
         }else if (payment_method == "receipt") {

            $('.fn_'+form+'_receipt').show();                
            $('.fn_'+form+'_cheque').hide();     
            $('#'+form+'_bank_receipt').prop('required', true);
            $('#'+form+'_bank_name').prop('required', false);
            $('#'+form+'_cheque_no').prop('required', false);
            
        }else{            
            
            $('.fn_'+form+'_receipt').hide();  
            $('.fn_'+form+'_cheque').hide();   
            $('#'+form+'_bank_receipt').prop('required', false);                 
            $('#'+form+'_bank_name').prop('required', false);
            $('#'+form+'_cheque_no').prop('required', false);
        } 
    }

    
    <?php if(isset($sale)){ ?>
        get_product_by_category('', '<?php echo $sale->category_id; ?>', '<?php echo $sale->product_id; ?>', 'edit');
    <?php } ?>
    
    function get_product_by_category(obj, category_id, product_id, form){       
         
        var unique_id = $(obj).parents('.fn_add_product_item').find('.fn_unique_id').val();
        var school_id = $('#'+form+'_school_id').val();        
             
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/sale/get_product_by_category'); ?>",
            data   : { school_id : school_id, category_id : category_id,  product_id : product_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#'+form+'_product_id_'+unique_id).html(response);
               }
            }
        });  
   }   
   
   function add_more_product(form){
   
        var school_id = $('#'+form+'_school_id').val(); 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/sale/add_more_product'); ?>",
            data   : {school_id : school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('.fn_'+form+'_product_container').append(response);
               }
            }
        });  
   }
   
    function remove_product_item(obj, form){
      
        if(confirm('<?php echo $this->lang->line('confirm_alert'); ?>')){
            $(obj).parents('.fn_add_product_item').remove();
            claculate_grand_total(form);
        }
    }
   
</script>
 
 
 <script type="text/javascript">
     
    var form = 'add';
    <?php if(isset($sale)){ ?>  
         get_user_by_role('<?php echo $sale->role_id; ?>', '<?php echo $sale->user_id; ?>', 'edit');
    <?php } ?>
      
    function get_user_by_role(role_id, user_id, form){       
      
      
       if(role_id == <?php echo STUDENT; ?>){
           $('.display').show();
           $('#'+form+'_class_id').prop('required', true);
           
            <?php if(!isset($sale)){ ?> 
                $('select#'+form+'_class_id').prop('selectedIndex', 0);
            <?php } ?>            
           
           $('#'+form+'_user_id').html('<option value="">--<?php echo $this->lang->line('select'); ?>--</option>'); 
       }else{
           get_user(role_id, '', user_id);
           $('#'+form+'_class_id').prop('required', false);
           $('.display').hide();
       }       
   }
   
   
    <?php if(isset($sale)){ ?> 
          get_user('<?php echo $sale->role_id; ?>', '<?php echo $sale->class_id; ?>', '<?php echo $sale->user_id; ?>');
    <?php } ?>
   
   function get_user(role_id, class_id, user_id){
              
        var school_id =  $('#add_school_id').val();
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           $('select#add_role_id').prop('selectedIndex', 0);
           return false;
        }        
        
        if(role_id == ''){
            role_id = $('#add_role_id').val();
        }           
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_by_role'); ?>",
            data   : {school_id : school_id, role_id : role_id , class_id : class_id, user_id : user_id, message : false},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#add_user_id').html(response); 
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
    
    function get_sale_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }

</script> 
