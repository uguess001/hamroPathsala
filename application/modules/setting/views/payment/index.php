<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-dollar"></i><small> <?php echo $this->lang->line('payment_setting'); ?></small></h3>
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
                        <li  class="<?php echo isset($paypal) ? 'active':''; ?>"><a href="#tab_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?></a> </li>                          
                        <li  class="<?php echo isset($stripe) ? 'active':''; ?>"><a href="#tab_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?></a> </li>                         
                        <li  class="<?php echo isset($payumoney) ? 'active':''; ?>"><a href="#tab_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?></a> </li>                          
                        <li  class="<?php echo isset($ccavenue) ? 'active':''; ?>"><a href="#tab_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?></a> </li>                          
                        <li  class="<?php echo isset($paytm) ? 'active':''; ?>"><a href="#tab_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?></a> </li>                          
                        <li  class="<?php echo isset($paystack) ? 'active':''; ?>"><a href="#tab_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?></a> </li> 
                        
                        <li  class="<?php echo isset($jazzcash) ? 'active':''; ?>"><a href="#tab_jazzcash_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('jazz_cash'); ?></a> </li>                         
                        <li  class="<?php echo isset($sslcommerz) ? 'active':''; ?>"><a href="#tab_sslcommerz_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ssl_commerz'); ?></a> </li> 
                        <li  class="<?php echo isset($dbbl) ? 'active':''; ?>"><a href="#tab_dbbl_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('dbbl'); ?></a> </li>
                        <li  class="<?php echo isset($instamojo) ? 'active':''; ?>"><a href="#tab_instamojo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('insta_mojo'); ?></a></li>
                            <li  class="<?php echo isset($midtrans) || isset($flutter) || isset($ipay) ? 'active':''; ?> dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->lang->line('more'); ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li  class="<?php echo isset($midtrans) ? 'active':''; ?>"><a href="#tab_midtrans_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mid_trans'); ?></a> </li>
                                    <li  class="<?php echo isset($flutter) ? 'active':''; ?>"><a href="#tab_flutter_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('flutter_wave'); ?></a> </li> 
                                    <li  class="<?php echo isset($ipay) ? 'active':''; ?>"><a href="#tab_ipay_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ipay'); ?></a> </li>                          
                                   <!-- <li  class="<?php echo isset($pesapal) ? 'active':''; ?>"><a href="#tab_pesapal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pesapal'); ?></a> </li>                          
                                    <li  class="<?php echo isset($billplz) ? 'active':''; ?>"><a href="#tab_billplz_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bill_plz'); ?></a> </li> -->
                                </ul>
                            </li>                          
                    </ul>
                    <br/>
                    <div class="tab-content">
               
                        <div class="tab-pane fade in <?php echo isset($paypal) ? 'active':''; ?>" id="tab_paypal_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paypal'), array('name' => 'paypal', 'id' => 'paypal', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paypal" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <!--<div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_username">paypal_api_username <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_username" value="<?php echo isset($setting) ? $setting->paypal_api_username : ''; ?>"  placeholder="paypal_api_username" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_username'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_password">paypal_api_password <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_password" value="<?php echo isset($setting) ? $setting->paypal_api_password : ''; ?>"  placeholder="paypal_api_password" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_password'); ?></div>
                                    </div>
                                </div>                  
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_signature">paypal_api_signature <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_signature" value="<?php echo isset($setting) ? $setting->paypal_api_signature : ''; ?>"  placeholder="paypal_api_signature" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_signature'); ?></div>
                                    </div>
                                </div> -->                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_email"><?php echo $this->lang->line('paypal_email'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_email" value="<?php echo isset($setting) ? $setting->paypal_email : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal_email'); ?>" required="required" type="email"  autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paypal_email'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paypal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paypal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paypal_demo'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_extra_charge" value="<?php echo isset($setting) ? $setting->paypal_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paypal_extra_charge'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paypal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paypal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paypal_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.paypal.com" target="_blank"><img src="<?php echo IMG_URL; ?>paypal-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        
                        <div class="tab-pane fade in <?php echo isset($stripe) ? 'active':''; ?> display" id="tab_stripe_setting">
                           <div class="x_content"> 
                              <?php echo form_open_multipart(site_url('setting/payment/stripe'), array('name' => 'stripe', 'id' => 'stripe', 'class'=>'form-horizontal form-label-left'), ''); ?>
                              <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                              <input type="hidden" value="1" name="stripe" />
                              <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                              
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_secret"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_secret" value="<?php echo isset($setting) ? $setting->stripe_secret : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                      <div class="help-block"><?php echo form_error('stripe_secret'); ?></div>
                                  </div>
                              </div>   
                              
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_publishable"><?php echo $this->lang->line('publishable_key'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_publishable" value="<?php echo isset($setting) ? $setting->stripe_publishable : ''; ?>"  placeholder="<?php echo $this->lang->line('publishable_key'); ?>" required="required" type="text" autocomplete="off">
                                      <div class="help-block"><?php echo form_error('stripe_publishable'); ?></div>
                                  </div>
                              </div>   

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_demo" required="required">
                                          <option value="1" <?php if(isset($setting) && $setting->stripe_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                          <option value="0" <?php if(isset($setting) && $setting->stripe_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                      </select>
                                      <div class="help-block"><?php echo form_error('stripe_demo'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_extra_charge"> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_extra_charge" value="<?php echo isset($setting) ? $setting->stripe_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                      <div class="help-block"><?php echo form_error('stripe_extra_charge'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_status" required="required">
                                          <option value="1" <?php if(isset($setting) && $setting->stripe_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                          <option value="0" <?php if(isset($setting) && $setting->stripe_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                      </select>
                                      <div class="help-block"><?php echo form_error('stripe_status'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <a href="https://stripe.com/" target="_blank"><img src="<?php echo IMG_URL; ?>stripe-setting.png" alt="" /></a> 
                                  </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-3">
                                      <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                      <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit') ?></button>
                                  </div>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                       </div> 

                        <div class="tab-pane fade in <?php echo isset($payumoney) ? 'active':''; ?>" id="tab_pumoney_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/payumoney'), array('name' => 'payumoney', 'id' => 'payumoney', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="payumoney" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_key"><?php echo $this->lang->line('payumoney_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_key" value="<?php echo isset($setting) ? $setting->payumoney_key : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payumoney_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_salt" value="<?php echo isset($setting) ? $setting->payumoney_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payumoney_salt'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->payumoney_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->payumoney_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('payumoney_demo'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payu_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payu_extra_charge" value="<?php echo isset($setting) ? $setting->payu_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payu_extra_charge'); ?></div>
                                    </div>
                                </div> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->payumoney_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->payumoney_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('payumoney_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.payumoney.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paym-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        
                        <div class="tab-pane fade in <?php echo isset($ccavenue) ? 'active':''; ?> display" id="tab_ccavenue_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/ccavenue'), array('name' => 'ccavenue', 'id' => 'ccavenue', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="ccavenue" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" /> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_merchant_id"><?php echo $this->lang->line('merchant_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="cca_merchant_id" value="<?php echo isset($setting) ? $setting->cca_merchant_id : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('cca_merchant_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_working_key"><?php echo $this->lang->line('working_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="cca_working_key" value="<?php echo isset($setting) ? $setting->cca_working_key : ''; ?>"  placeholder="<?php echo $this->lang->line('working_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('cca_working_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_access_code"><?php echo $this->lang->line('access_code'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="cca_access_code" value="<?php echo isset($setting) ? $setting->cca_access_code : ''; ?>"  placeholder="<?php echo $this->lang->line('access_code'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('cca_access_code'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="cca_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->cca_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->cca_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('cca_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="cca_extra_charge" value="<?php echo isset($setting) ? $setting->cca_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('cca_extra_charge'); ?></div>
                                    </div>
                                </div>
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="cca_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->cca_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->cca_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('cca_status'); ?></div>
                                    </div>
                                </div>
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.ccavenue.com/" target="_blank"><img src="<?php echo IMG_URL; ?>ccavenue-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                         
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                                                
                        <div class="tab-pane fade in <?php echo isset($paytm) ? 'active':''; ?>" id="tab_paytm_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paytm'), array('name' => 'paytm', 'id' => 'paytm', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paytm" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_key"><?php echo $this->lang->line('merchant_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_key" value="<?php echo isset($setting) ? $setting->paytm_merchant_key : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_mid"><?php echo $this->lang->line('merchant_mid'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_mid" value="<?php echo isset($setting) ? $setting->paytm_merchant_mid : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_mid'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_mid'); ?></div>
                                    </div>
                                </div> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_website"><?php echo $this->lang->line('website'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_website" value="<?php echo isset($setting) ? $setting->paytm_merchant_website : ''; ?>"  placeholder="<?php echo $this->lang->line('website'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_website'); ?></div>
                                    </div>
                                </div>                  
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_industry_type"><?php echo $this->lang->line('industry_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_industry_type" value="<?php echo isset($setting) ? $setting->paytm_industry_type : ''; ?>"  placeholder="<?php echo $this->lang->line('industry_type'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_industry_type'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paytm_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paytm_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paytm_demo'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_extra_charge" value="<?php echo isset($setting) ? $setting->paytm_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paytm_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paytm_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paytm_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paytm.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paytm-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                                                 
                        <div class="tab-pane fade in <?php echo isset($paystack) ? 'active':''; ?>" id="tab_paystack_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paystack'), array('name' => 'paystack', 'id' => 'paystack', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paystack" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($setting) ? $setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($setting) ? $setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" id="stack_extra_charge" value="<?php echo isset($setting) ? $setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a> 
                                        <div class="instructions">Nigeria & African Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        
                        <div class="tab-pane fade in <?php echo isset($jazzcash) ? 'active':''; ?>" id="tab_jazzcash_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/jazzcash'), array('name' => 'jazzcash', 'id' => 'jazzcash', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="jazzcash" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_merchant_id"><?php echo $this->lang->line('merchant_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="jaz_merchant_id" value="<?php echo isset($setting) ? $setting->jaz_merchant_id : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('jaz_merchant_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="jaz_password" value="<?php echo isset($setting) ? $setting->jaz_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('jaz_password'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="jaz_salt" value="<?php echo isset($setting) ? $setting->jaz_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('jaz_salt'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="jaz_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->jaz_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->jaz_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('jaz_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="jaz_extra_charge" id="stack_extra_charge" value="<?php echo isset($setting) ? $setting->jaz_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('jaz_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="jaz_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->jaz_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->jaz_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('jaz_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://jazzcash.com/" target="_blank"><img src="<?php echo IMG_URL; ?>jazzcash-setting.png" alt="" /></a> 
                                        <div class="instructions">Pakistani Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($sslcommerz) ? 'active':''; ?>" id="tab_sslcommerz_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/sslcommerz'), array('name' => 'sslcommerz', 'id' => 'sslcommerz', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="jazzcash" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_store_id"><?php echo $this->lang->line('store_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ssl_store_id" value="<?php echo isset($setting) ? $setting->ssl_store_id : ''; ?>"  placeholder="<?php echo $this->lang->line('store_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ssl_store_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ssl_password" value="<?php echo isset($setting) ? $setting->ssl_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ssl_password'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ssl_demo" id="ssl_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ssl_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ssl_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ssl_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ssl_extra_charge" id="ssl_extra_charge" value="<?php echo isset($setting) ? $setting->ssl_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ssl_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ssl_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ssl_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ssl_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ssl_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href=" https://www.sslcommerz.com" target="_blank"><img src="<?php echo IMG_URL; ?>sslcommerz-setting.png" alt="" /></a> 
                                        <div class="instructions">Bangladeshi Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($dbbl) ? 'active':''; ?>" id="tab_dbbl_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/dbbl'), array('name' => 'dbbl', 'id' => 'dbbl', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="dbbl" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_userid"><?php echo $this->lang->line('userid'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_userid" value="<?php echo isset($setting) ? $setting->dbbl_userid : ''; ?>"  placeholder="<?php echo $this->lang->line('userid'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_userid'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_password" value="<?php echo isset($setting) ? $setting->dbbl_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_password'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_submername"><?php echo $this->lang->line('submer_name'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_submername" value="<?php echo isset($setting) ? $setting->dbbl_submername : ''; ?>"  placeholder="<?php echo $this->lang->line('submer_name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_submername'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_submerid"><?php echo $this->lang->line('submer_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_submerid" value="<?php echo isset($setting) ? $setting->dbbl_submerid : ''; ?>"  placeholder="<?php echo $this->lang->line('submer_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_submerid'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_terminalid"><?php echo $this->lang->line('terminal_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_terminalid" value="<?php echo isset($setting) ? $setting->dbbl_terminalid : ''; ?>"  placeholder="<?php echo $this->lang->line('terminal_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_terminalid'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="dbbl_demo" id="dbbl_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->dbbl_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->dbbl_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('dbbl_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="dbbl_extra_charge" id="dbbl_extra_charge" value="<?php echo isset($setting) ? $setting->ssl_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('dbbl_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ssl_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->dbbl_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->dbbl_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('dbbl_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.dutchbanglabank.com" target="_blank"><img src="<?php echo IMG_URL; ?>dbbl/dbbl.png" alt="" width="100" /></a> 
                                        <div class="instructions" style="margin:10px 0px;">Return URL: https://project root url/accounting/gateway/dbbl</div>
                                        <div class="instructions" style="margin:10px 0px;">Bangladeshi Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($midtrans) ? 'active':''; ?>" id="tab_midtrans_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/midtrans'), array('name' => 'midtrans', 'id' => 'midtrans', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="midtrans" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_client_key"><?php echo $this->lang->line('client_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mid_client_key" value="<?php echo isset($setting) ? $setting->mid_client_key : ''; ?>"  placeholder="<?php echo $this->lang->line('client_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mid_client_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_server_key"><?php echo $this->lang->line('server_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mid_server_key" value="<?php echo isset($setting) ? $setting->mid_server_key : ''; ?>"  placeholder="<?php echo $this->lang->line('server_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mid_server_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="mid_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->jaz_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->jaz_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('mid_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mid_extra_charge" id="mid_extra_charge" value="<?php echo isset($setting) ? $setting->mid_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mid_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="mid_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->mid_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->mid_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('mid_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://midtrans.com/" target="_blank"><img src="<?php echo IMG_URL; ?>midtrans-setting.png" alt="" /></a> 
                                        <div class="instructions">Indonesian Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        
                        
                        <div class="tab-pane fade in <?php echo isset($instamojo) ? 'active':''; ?>" id="tab_instamojo_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/instamojo'), array('name' => 'instamojo', 'id' => 'instamojo', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="instamojo" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mojo_api_key" value="<?php echo isset($setting) ? $setting->mojo_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mojo_api_key'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mojo_auth_token" value="<?php echo isset($setting) ? $setting->mojo_auth_token : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mojo_auth_token'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_key_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mojo_key_salt" value="<?php echo isset($setting) ? $setting->mojo_key_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mojo_key_salt'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="mojo_demo" id="ssl_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->mojo_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->mojo_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('mojo_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mojo_extra_charge" id="ssl_extra_charge" value="<?php echo isset($setting) ? $setting->mojo_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mojo_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="mojo_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->mojo_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->mojo_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('mojo_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://instamojo.com/" target="_blank"><img src="<?php echo IMG_URL; ?>instamojo-setting.png" alt="" /></a> 
                                        <div class="instructions">Indian Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($pesapal) ? 'active':''; ?>" id="tab_pesapal_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/pesapal'), array('name' => 'pesapal', 'id' => 'pesapal', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="pesapal" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_cust_key"><?php echo $this->lang->line('customer_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="pesa_cust_key" value="<?php echo isset($setting) ? $setting->pesa_cust_key : ''; ?>"  placeholder="<?php echo $this->lang->line('customer_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('pesa_cust_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_cust_secret"><?php echo $this->lang->line('customer_secret'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="pesa_cust_secret" value="<?php echo isset($setting) ? $setting->pesa_cust_secret : ''; ?>"  placeholder="<?php echo $this->lang->line('customer_secret'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('pesa_cust_secret'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="pesa_demo" id="pesa_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->pesa_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->pesa_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('pesa_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="pesa_extra_charge" id="pesa_extra_charge" value="<?php echo isset($setting) ? $setting->pesa_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('pesa_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="pesa_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->pesa_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->pesa_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('pesa_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://pesapal.com/" target="_blank"><img src="<?php echo IMG_URL; ?>Pesapal-setting.png" alt="" /></a> 
                                        <div class="instructions">African Countries Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($flutter) ? 'active':''; ?>" id="tab_flutter_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/flutter'), array('name' => 'flutter', 'id' => 'flutter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="flutter" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="flut_public_key" value="<?php echo isset($setting) ? $setting->flut_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('flut_public_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="flut_secret_key" value="<?php echo isset($setting) ? $setting->flut_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('flut_secret_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="flut_demo" id="flut_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->flut_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->flut_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('flut_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="flut_extra_charge" id="flut_extra_charge" value="<?php echo isset($setting) ? $setting->flut_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('flut_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="flut_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->flut_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->flut_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('flut_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://flutterwave.com" target="_blank"><img src="<?php echo IMG_URL; ?>flutterwave-setting.png" alt="" /></a> 
                                        <div class="instructions">Multinational Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($ipay) ? 'active':''; ?>" id="tab_ipay_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/ipay'), array('name' => 'ipay', 'id' => 'ipay', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="ipay" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_vendor_id"><?php echo $this->lang->line('vendor_id'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ipay_vendor_id" value="<?php echo isset($setting) ? $setting->ipay_vendor_id : ''; ?>"  placeholder="<?php echo $this->lang->line('vendor_id'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ipay_vendor_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_hash_key"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ipay_hash_key" value="<?php echo isset($setting) ? $setting->ipay_hash_key : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ipay_hash_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ipay_demo" id="ipay_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ipay_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ipay_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ipay_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ipay_extra_charge" id="flut_extra_charge" value="<?php echo isset($setting) ? $setting->ipay_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ipay_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ipay_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ipay_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ipay_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ipay_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.ipayafrica.com/" target="_blank"><img src="<?php echo IMG_URL; ?>ipay-setting.png" alt="" /></a> 
                                        <div class="instructions">African Countries Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade in <?php echo isset($billplz) ? 'active':''; ?>" id="tab_billplz_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/billplz'), array('name' => 'billplz', 'id' => 'billplz', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="billplz" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="bill_api_key" value="<?php echo isset($setting) ? $setting->bill_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('bill_api_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="bill_demo" id="bill_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->bill_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->bill_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('bill_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="bill_extra_charge" id="flut_extra_charge" value="<?php echo isset($setting) ? $setting->bill_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('bill_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="bill_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->bill_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->bill_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('bill_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://billplz.com/" target="_blank"><img src="<?php echo IMG_URL; ?>billplz-setting.png" alt="" /></a> 
                                        <div class="instructions">African Countries Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
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
<script type="text/javascript">
    $("#paypal").validate();  
    $("#stripe").validate();  
    $("#payumoney").validate();  
    $("#ccavenue").validate();  
    $("#paytm").validate();  
    $("#paystack").validate();
    $("#jazzcash").validate(); 
    $("#sslcommerz").validate(); 
    $("#dbbl").validate(); 
    $("#instamojo").validate(); 
    $("#midtrans").validate(); 
    $("#pesapal").validate(); 
    $("#flutter").validate(); 
    $("#ipay").validate(); 
    $("#billplz").validate(); 
</script>