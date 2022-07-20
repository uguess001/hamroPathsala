<section class="content invoice profile_img layout-box">
      <!-- title row -->
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_ text-center" style="text-align: center !important;">
               <?php if($settings->logo){ ?>
                  <img src="<?php echo UPLOAD_PATH; ?>logo/<?php echo $settings->logo; ?>" alt="" width="100" /> 
               <?php }else if($settings->front_logo){ ?>
                  <img src="<?php echo UPLOAD_PATH; ?>logo/<?php echo $settings->front_logo; ?>" alt="" width="100"/> 
               <?php }else{ ?>                                                        
                  <img src="<?php echo UPLOAD_PATH; ?>logo/<?php echo $settings->brand_logo; ?>" alt="" width="100"/>
               <?php } ?> 
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_" style="text-align: center !important;">             
                <h3><?php echo $settings->school_name; ?></h3>
                 <?php echo $settings->address; ?>
                <br><?php echo $this->lang->line('phone'); ?>: <?php echo $settings->phone; ?>,
                <?php echo $this->lang->line('email'); ?>: <?php echo $settings->email; ?>              
          </div>            
      </div>
       <div class="row"><hr/></div>
      <!-- info row -->
      <div class="row invoice-info">          
          <div class="col-md-6 col-sm-6 col-xs-6 invoice-col_"> 
               <?php
                    $user = get_user_by_role($sale->role_id, $sale->user_id);
                ?>
                <strong><?php echo $this->lang->line('sale_to'); ?>:</strong> <?php echo  $user->name; ?> [<?php echo  $user->role; ?>]<br>                
                <?php
                if($user->role_id == STUDENT){
                        echo '<strong>'.$this->lang->line('class').':</strong> '.$user->class_name.', <strong>'. $this->lang->line('section').':</strong> '.$user->section.', <strong>'. $this->lang->line('roll_no'). ':</strong>'. $user->roll_no . ']<br>';
                    }
                ?>
                <strong><?php echo $this->lang->line('phone'); ?>:</strong> <?php echo $user->phone; ?>            
          </div>
          <!-- /.col -->
          <div class="col-md-6 col-sm-6 col-xs-6 invoice-col">             
                <strong><?php echo $this->lang->line('invoice'); ?>: </strong> #<?php echo $sale->custom_invoice_id; ?>                                                     
                <br><strong><?php echo $this->lang->line('status'); ?>:</strong> <?php echo get_paid_status($sale->paid_status); ?>
                <br><strong><?php echo $this->lang->line('date'); ?>:</strong> <?php echo date($this->global_setting->date_format, strtotime($sale->date)); ?>
          </div>
          <!-- /.col -->
      </div>   
      
   </section>    
   <section class="content invoice"> 
       <!-- Table row -->
       <div class="row">
           <div class="col-xs-12 table">
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
                        <?php if(isset($sale_items) && !empty($sale_items)){ ?>
                            <?php $counter = 1; foreach($sale_items as $item){ ?>
                            <tr>
                                <td  style="width:10%"><?php echo $counter++; ?></td>
                                <td> <?php echo $item->title; ?></td>
                                <td> <?php echo $item->category; ?></td>
                                <td> <?php echo $item->product; ?></td>
                                <td> <?php echo $item->qty; ?></td>
                                <td> <?php echo $item->unit_price; ?></td>
                                <td> <?php echo $settings->currency_symbol; ?><?php echo $item->net_amount; ?></td>
                            </tr> 
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
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
                                <td><?php echo $settings->currency_symbol; ?><?php echo $sale->gross_amount; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('discount'); ?></th>
                                <td><?php echo $settings->currency_symbol; ?><?php  echo $sale->inv_discount; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('total'); ?>:</th>
                                <td><?php echo $settings->currency_symbol; ?><?php echo $sale->net_amount; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('paid_amount'); ?>:</th>
                                <td><?php echo $settings->currency_symbol; ?><?php echo $paid_amount ? $paid_amount : 0.00; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('due_amount'); ?>:</th>
                                <td><span class="btn-danger" style="padding: 5px;border-radius: 4px;"><?php echo $settings->currency_symbol; ?><?php echo $sale->net_amount-$paid_amount; ?></span></td>
                            </tr>
                            <?php if($sale->paid_status == 'paid'){ ?>
                                <tr>
                                    <th><?php echo $this->lang->line('paid_date'); ?>:</th>
                                    <td><?php echo date($this->global_setting->date_format, strtotime($sale->date)); ?></td>
                                </tr>
                            <?php } ?>
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
                <?php if(isset($settings->footer) && $settings->footer != ''){ ?>
                   <?php echo $settings->footer; ?>
                <?php }else{ ?>
                   <?php echo 'Copyright © '. date('Y').' <a target="_blank" href="http://aegistechnologies.net">Aegis Technologies.</a> All rights reserved.'; ?> 
                <?php } ?>
           </p> 
       </div>

   </section>  
  
       
<!-- this row will not appear when printing -->
<div class="row no-print">
    <div class="col-xs-12">
        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
        <?php if($sale->paid_status != 'paid'){ ?>
            <a href="<?php echo site_url('accounting/payment/index/'.$sale->inv_id); ?>"><button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('pay_now'); ?></button></a>
        <?php } ?>
    </div>
</div>