<?php $arr = array($this->lang->line('sale_to').'/ '.$this->lang->line('student_copy'), $this->lang->line('school_copy'), $this->lang->line('bank_copy')); ?>   
<?php $count = 1; $total_count = count($arr);  foreach($arr as $key=>$value){ ?>   
   <section class="content invoice profile_img_">
       <!-- title row -->
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_ text-center" style="text-align: center !important;">
               <?php if($school->logo){ ?>
                  <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
               <?php }else if($school->frontend_logo){ ?>
                  <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
               <?php }else{ ?>                                                        
                  <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
               <?php } ?> 
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_" style="text-align: center !important;">
              <address>
                  <h3><?php echo $school->school_name; ?></h3>
                   <?php echo $school->address; ?>
                  <br><?php echo $this->lang->line('phone'); ?>: <?php echo $school->phone; ?>,
                  <?php echo $this->lang->line('email'); ?>: <?php echo $school->email; ?>
              </address>
          </div>            
      </div>

      <!-- info row -->
      <div class="row invoice-info">          
          <div class="col-md-6 col-sm-6 col-xs-6 invoice-col_ text-center">                
              <address>
                   <strong><?php echo $this->lang->line('student'); ?>/<?php echo $this->lang->line('sale_to'); ?>:</strong><br>              
               <?php
                    $user = get_user_by_role($receipt->role_id, $receipt->user_id);
                
                if(!empty($user)){    
                ?>
                    <strong><?php echo $this->lang->line('sale_to'); ?>:</strong> <?php echo  $user->name; ?> [<?php echo  $user->role; ?>]<br>                
                    <?php
                    if($receipt->role_id == STUDENT){
                        echo '<strong>'.$this->lang->line('class').':</strong> '.$user->class_name.', <strong>'. $this->lang->line('section').':</strong> '.$user->section.', <strong>'. $this->lang->line('roll_no'). ':</strong>'. $user->roll_no . ']<br>';
                    }
                    ?>
                    <strong><?php echo $this->lang->line('phone'); ?>:</strong> <?php echo $user->phone; ?> 
                
                <?php } ?>
              </address>
          </div>
          <!-- /.col -->
          <div class="col-md-6 col-sm-6 col-xs-6 invoice-col text-center">
              <address>
                  <strong><?php echo $this->lang->line('invoice'); ?>: </strong> #<?php echo $receipt->custom_invoice_id; ?>                                                     
                  <br><strong><?php echo $this->lang->line('status'); ?>:</strong> <?php echo get_paid_status($receipt->paid_status); ?>
                  <br><strong><?php echo $this->lang->line('date'); ?>:</strong> <?php echo date($this->global_setting->date_format, strtotime($receipt->date)); ?>
              </address>
          </div>
          <!-- /.col -->
      </div>   
      <div class="row">
           <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_" style="text-align: center !important;">
               <address>
                   <h4><?php echo $value; ?></h4>                    
               </address>
           </div>            
       </div>
   </section>    
   <section class="content invoice"> 
       <!-- Table row -->
       <div class="row">
           <div class="col-xs-12 table">
               
                <?php if($receipt->invoice_type == 'sale'){ ?>
                   <table class="table table-striped">
                   <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('fee_type'); ?></th>
                            <th><?php echo $this->lang->line('category'); ?></th>
                            <th><?php echo $this->lang->line('product'); ?></th>
                            <th><?php echo $this->lang->line('quantity'); ?></th>
                            <th><?php echo $this->lang->line('unit_price'); ?></th>
                            <th><?php echo $this->lang->line('subtotal'); ?></th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php if(isset($receipt_items) && !empty($receipt_items)){ ?>
                            <?php $counter = 1; foreach($receipt_items as $item){ ?>
                            <tr>
                                <td  style="width:10%"><?php echo $counter++; ?></td>
                                <td> <?php echo $item->title; ?></td>
                                <td> <?php echo $item->category; ?></td>
                                <td> <?php echo $item->product; ?></td>
                                <td> <?php echo $item->qty; ?></td>
                                <td> <?php echo $item->unit_price; ?></td>
                                <td> <?php echo $school->currency_symbol; ?><?php echo $item->net_amount; ?></td>
                            </tr> 
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                    </table>
                   <?php }else{ ?>                   
               
                  <table class="table table-striped"> 
                   <thead>
                       <tr>
                           <th><?php echo $this->lang->line('sl_no'); ?></th>
                           <th><?php echo $this->lang->line('fee_type'); ?></th>
                           <th><?php echo $this->lang->line('gross_amount'); ?></th>
                           <th><?php echo $this->lang->line('discount'); ?></th>
                           <th><?php echo $this->lang->line('net_amount'); ?></th>
                       </tr>
                   </thead>
                   <tbody> 
                       <?php if(isset($receipt_items) && !empty($receipt_items)){ ?>
                           <?php $counter = 1; foreach($receipt_items as $item){ ?>
                           <tr>
                               <td  style="width:10%"><?php echo $counter++; ?></td>
                               <td  style="width:25%"> <?php echo $item->title; ?></td>
                               <td> <?php echo $school->currency_symbol; ?><?php echo $item->gross_amount; ?></td>
                               <td><?php echo $school->currency_symbol; ?><?php echo round($item->discount,2); ?></td>
                               <td><?php echo $school->currency_symbol; ?><?php echo round($item->net_amount, 2); ?></td>
                           </tr> 
                           <?php } ?>
                       <?php } ?>
                   </tbody>
                  </table>
                   <?php } ?>
           </div>
           <!-- /.col -->
       </div>

       <div class="row">
           <!-- accepted payments column -->
           <div class="col-xs-6">
               <p class="lead"><?php echo $this->lang->line('payment_method'); ?>:</p>
               <img src="<?php echo IMG_URL; ?>visa.png" alt="Visa">
               <img src="<?php echo IMG_URL; ?>mastercard.png" alt="Mastercard">
               <img src="<?php echo IMG_URL; ?>american-express.png" alt="American Express">
               <img src="<?php echo IMG_URL; ?>paypal.png" alt="Paypal">                       
           </div>
           <!-- /.col -->
           <div class="col-xs-6">
               <div class="table-responsive">
                   <table class="table">
                       <tbody>
                           <tr>
                               <th style="width:56%"><?php echo $this->lang->line('subtotal'); ?>:</th>
                               <td><?php echo $school->currency_symbol; ?><?php echo $receipt->gross_amount; ?></td>
                           </tr>
                           <tr>
                               <th><?php echo $this->lang->line('discount'); ?></th>
                               <td><?php echo $school->currency_symbol; ?><?php  echo $receipt->inv_discount; ?></td>
                           </tr>
                           <tr>
                               <th><?php echo $this->lang->line('total'); ?>:</th>
                               <td><?php echo $school->currency_symbol; ?><?php echo $receipt->net_amount; ?></td>
                           </tr>
                           <tr>
                               <th><?php echo $this->lang->line('paid_amount'); ?>:</th>
                               <td><?php echo $school->currency_symbol; ?><?php echo $paid_amount ? $paid_amount : 0.00; ?></td>
                           </tr>
                           <tr>
                               <th><?php echo $this->lang->line('due_amount'); ?>:</th>
                               <td><span class="btn-danger" style="padding: 5px;"><?php echo $school->currency_symbol; ?><?php echo $receipt->net_amount-$paid_amount; ?></span></td>
                           </tr>                       
                       </tbody>
                   </table>
               </div>
           </div>
           <!-- /.col -->
       </div>
       <!-- /.row -->

        <div class="row">
            <div class="col-xs-12"></div>
        </div>
       <!-- /.row -->
       <div class="row">       
           <p class="white text-center">
                <?php if(isset($this->school_setting->footer) && $this->school_setting->footer != ''){ ?>
                   <?php echo $this->school_setting->footer; ?>
                <?php }else{ ?>
                   <?php echo $this->global_setting->brand_footer ? $this->global_setting->brand_footer : 'Copyright © '. date('Y').' <a target="_blank" href="http://aegistechnologies.net">Aegis Technologies.</a> All rights reserved.'; ?> 
                <?php } ?>
           </p> 
       </div>

   </section>  

<?php if($count < $total_count){ ?>
       <hr/><div class="pagebreak">&nbsp;</div> 
    <?php } ?>
 <?php $count++; } ?>   
       
<!-- this row will not appear when printing -->
<div class="row no-print">
    <div class="col-xs-12">
        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
    </div>
</div>