<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('manage_due_invoice'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>           
             
            <div class="x_content quick-link no-print">
               <?php $this->load->view('quick-link'); ?>  
            </div>
                        
            <div class="x_content"> 
                 <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered  no-print">                 
                        <li  class="active"><a href="#due_invoice" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-calculator"></i> <?php echo $this->lang->line('due_invoice'); ?> </a></li>                          
                        
                        <li class="li-class-list">
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                             <select  class="form-control col-md-7 col-xs-12" onchange="get_invoice_by_school(this.value);">
                                     <option value="<?php echo site_url('accounting/invoice/due'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                 <?php foreach($schools as $obj ){ ?>
                                     <option value="<?php echo site_url('accounting/invoice/due/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                 <?php } ?>   
                             </select>
                         <?php } ?>  
                        </li>  
                    </ul>
                    <br/>
                     <div class="tab-content  no-print">
                        <div  class="tab-pane fade in active" id="due_invoice" >
                            <div class="x_content">   
                               <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                   <thead>
                                       <tr>
                                           <th><?php echo $this->lang->line('sl_no'); ?></th>
                                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <th><?php echo $this->lang->line('school'); ?></th>
                                            <?php } ?>
                                           <th><?php echo $this->lang->line('invoice_number'); ?></th>
                                           <th><?php echo $this->lang->line('student'); ?>/ <?php echo $this->lang->line('sale_to'); ?></th>
                                           <th><?php echo $this->lang->line('class'); ?></th>
                                           <th><?php echo $this->lang->line('gross_amount'); ?></th>
                                           <th><?php echo $this->lang->line('discount'); ?></th>
                                           <th><?php echo $this->lang->line('net_amount'); ?></th>
                                           <th><?php echo $this->lang->line('due_amount'); ?></th>
                                           <th><?php echo $this->lang->line('status'); ?></th>
                                           <th><?php echo $this->lang->line('action'); ?></th>                                            
                                       </tr>
                                   </thead>
                                   <tbody>   
                                       <?php $count = 1; if(isset($invoices) && !empty($invoices)){ ?>
                                           <?php foreach($invoices as $obj){ ?>
                                           <tr>
                                               <td><?php echo $count++; ?></td>
                                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                    <td><?php echo $obj->school_name; ?></td>
                                                <?php } ?>
                                               <td><?php echo $obj->custom_invoice_id; ?></td>
                                               <td>
                                                   <?php $user = get_user_by_role($obj->role_id, $obj->user_id); ?>
                                                <?php
                
                                                if(!empty($user)){    
                                                ?>
                                                    <?php echo  $user->name; ?> [<?php echo  $user->role; ?>]<br>                
                                                    <?php
                                                    if($obj->role_id == STUDENT){
                                                        echo $this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '. $this->lang->line('roll_no'). ':'. $user->roll_no;
                                                    }
                                                    ?>
                                                <?php } ?> 
                                               </td>
                                               <td><?php echo $obj->class_name; ?></td>
                                               <td><?php echo $obj->gross_amount; ?></td>
                                               <td><?php echo $obj->discount; ?></td>
                                               <td><?php echo $obj->net_amount; ?></td>
                                               <td class="red">
                                                   <?php 
                                                    $paid_amount = get_invoice_paid_amount($obj->id);
                                                    echo $paid_amount->net_amount - $paid_amount->paid_amount; 
                                                   ?>
                                               </td>
                                               <td><?php echo get_paid_status($obj->paid_status); ?></td>
                                               <td>
                                                   <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                                                   
                                                   <a  onclick="get_invoice_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-invoice-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                        <?php if($obj->paid_status != 'paid'){ ?>
                                                            <a href="<?php echo site_url('accounting/payment/index/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('pay_now'); ?></a>
                                                        <?php } ?>
                                                   <?php } ?>
                                                    
                                                    <?php if(has_permission(DELETE, 'accounting', 'invoice') && $obj->paid_status == 'unpaid'){ ?>                                                    
                                                      <a href="<?php echo site_url('accounting/invoice/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
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

<?php $this->load->view('invoice-modal'); ?> 

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
    
     function get_invoice_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }  
    
</script>