<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-gears"></i><small> <?php echo $this->lang->line('manage_payment_setting'); ?></small></h3>
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

                    <ul class="nav nav-tabs bordered">
                        <li class="<?php if (isset($list)) {
                                        echo 'active';
                                    } ?>"><a href="#tab_payment_list" role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if (has_permission(ADD, 'administrator', 'payment')) { ?>
                            <?php if (isset($edit)) { ?>
                                <li class="<?php if (isset($add)) {
                                                echo 'active';
                                            } ?>"><a href="<?php echo site_url('administrator/payment/add'); ?>" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>
                            <?php } else { ?>
                                <li class="<?php if (isset($add)) {
                                                echo 'active';
                                            } ?>"><a href="#tab_add_payment" role="tab" data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>
                            <?php } ?>
                        <?php } ?>

                        <?php if (isset($edit)) { ?>
                            <li class="active"><a href="#tab_edit_payment" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>
                        <?php } ?>
                    </ul>
                    <br />

                    <div class="tab-content">
                        <div class="tab-pane fade in <?php if (isset($list)) {
                                                            echo 'active';
                                                        } ?>" id="tab_payment_list">
                            <div class="x_content">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                            <th><?php echo $this->lang->line('Khalti'); ?></th>

                                            <th><?php echo $this->lang->line('status'); ?></th>
                                            <th><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;
                                        if (isset($payment_settings) && !empty($payment_settings)) { ?>
                                            <?php foreach ($payment_settings as $obj) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><?php echo $obj->school_name; ?></td>
                                                    <td><?php echo $obj->khalti_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                                    <td><?php echo $obj->status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                                    <td>
                                                        <?php if (has_permission(VIEW, 'administrator', 'payment')) { ?>
                                                            <a onclick="get_payment_modal(<?php echo $obj->id; ?>);" data-toggle="modal" data-target=".bs-payment-modal-lg" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a><br />
                                                        <?php } ?>
                                                        <?php if (has_permission(EDIT, 'administrator', 'payment')) { ?>
                                                            <a href="<?php echo site_url('administrator/payment/edit/' . $obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                        <?php } ?>
                                                        <?php if (has_permission(DELETE, 'administrator', 'payment')) { ?>
                                                            <a href="<?php echo site_url('administrator/payment/delete/' . $obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade in <?php if (isset($add)) {
                                                            echo 'active';
                                                        } ?>" id="tab_add_payment">
                            <div class="x_content">
                                <?php echo form_open_multipart(site_url('administrator/payment/add'), array('name' => 'add', 'id' => 'add', 'class' => 'form-horizontal form-label-left'), ''); ?>

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <?php $this->load->view('layout/school_list_form'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li class="active"><a href="#tab_khalti_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('khalti'); ?></a> </li>

                                            <!--<li  class="active"><a href="#tab_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?></a> </li>                         
                                            <li  class=""><a href="#tab_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?></a> </li>                  
                                            <li  class=""><a href="#tab_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?></a> </li> 
                                            
                                            <li  class=""><a href="#tab_jazzcash_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('jazz_cash'); ?></a> </li>
                                            <li  class=""><a href="#tab_sslcommerz_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ssl_commerz'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_dbbl_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('dbbl'); ?></a> </li>
                                            <li  class=""><a href="#tab_midtrans_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mid_trans'); ?></a> </li>                          
                                           
                                            <li  class=""><a href="#tab_instamojo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('insta_mojo'); ?></a> </li>                         
                                            <li  class=""><a href="#tab_flutter_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('flutter_wave'); ?></a> </li> 
                                            <li  class=""><a href="#tab_ipay_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ipay'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_pesapal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pesapal'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_billplz_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bill_plz'); ?></a> </li>-->

                                        </ul>
                                    </div>

                                    <div class="col-xs-9">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab_khalti_setting">

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_email"><?php echo $this->lang->line('khalti_email'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="khalti_email" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_email : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_email'); ?>" required="required" type="email" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('khalti_email'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_public_key"><?php echo $this->lang->line('khalti_public_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="khalti_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_public_key : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_public_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('khalti_public_key'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_secretkey"><?php echo $this->lang->line('khalti_secretkey'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" name="khalti_secretkey" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_secretkey : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_secretkey'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('khalti_secretkey'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control col-md-7 col-xs-12" name="khalti_demo" required="required">
                                                            <option value="1" <?php if (isset($payment_setting) && $payment_setting->khalti_demo == '1') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if (isset($payment_setting) && $payment_setting->khalti_demo == '0') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('khalti_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control col-md-7 col-xs-12" name="khalti_status" required="required">
                                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if (isset($payment_setting) && $payment_setting->khalti_status == '0') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if (isset($payment_setting) && $payment_setting->khalti_status == '1') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('khalti_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://khalti.com/" target="_blank"><img src="<?php echo IMG_URL; ?>khalti-setting.png" alt="" style="max-width:150px;" /></a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="<?php echo site_url('administrator/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <?php if (isset($edit)) { ?>

                            <div class="tab-pane fade in active" id="tab_edit_payment">
                                <div class="x_content">
                                    <?php echo form_open_multipart(site_url('administrator/payment/edit/' . $payment_setting->id), array('name' => 'edit', 'id' => 'edit', 'class' => 'form-horizontal form-label-left'), ''); ?>

                                    <div class="row">
                                        <div class="col-xs-3"></div>
                                        <div class="col-xs-9">
                                            <?php $this->load->view('layout/school_list_edit_form'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <ul class="nav nav-tabs tabs-left">
                                                <li class="active"><a href="#tab_edit_khalti_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('khalti'); ?></a> </li>

                                            </ul>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="tab-content">

                                                <div class="tab-pane fade in active" id="tab_edit_khalti_setting">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_email"><?php echo $this->lang->line('khalti_email'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="khalti_email" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_email : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_email'); ?>" required="required" type="email" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('khalti_email'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_public_key"><?php echo $this->lang->line('khalti_public_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="khalti_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_public_key : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_public_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('khalti_public_key'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_secretkey"><?php echo $this->lang->line('khalti_secretkey'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="khalti_secretkey" value="<?php echo isset($payment_setting) ? $payment_setting->khalti_secretkey : ''; ?>" placeholder="<?php echo $this->lang->line('khalti_secretkey'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('khalti_secretkey'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="khalti_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->khalti_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->khalti_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('khalti_demo'); ?></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="khalti_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="khalti_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->khalti_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->khalti_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('khalti_status'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.khalti.com" target="_blank"><img src="<?php echo IMG_URL; ?>khalti-setting.png" alt="" /></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade in  display" id="tab_edit_stripe_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_secret"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stripe_secret" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_secret : ''; ?>" placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stripe_secret'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_publishable"><?php echo $this->lang->line('publishable_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stripe_publishable" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_publishable : ''; ?>" placeholder="<?php echo $this->lang->line('publishable_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stripe_publishable'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="stripe_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->stripe_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->stripe_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('stripe_demo'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stripe_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stripe_extra_charge'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="stripe_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->stripe_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->stripe_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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
                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_pumoney_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_key"><?php echo $this->lang->line('payumoney_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="payumoney_key" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_key : ''; ?>" placeholder="<?php echo $this->lang->line('payumoney_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('payumoney_key'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="payumoney_salt" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_salt : ''; ?>" placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('payumoney_salt'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="payumoney_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->payumoney_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->payumoney_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('payumoney_demo'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payu_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="payu_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->payu_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('payu_extra_charge'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="payumoney_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->payumoney_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->payumoney_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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
                                                </div>

                                                <div class="tab-pane fade in display" id="tab_edit_ccavenue_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_merchant_id"><?php echo $this->lang->line('merchant_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="cca_merchant_id" value="<?php echo isset($payment_setting) ? $payment_setting->cca_merchant_id : ''; ?>" placeholder="<?php echo $this->lang->line('merchant_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('cca_merchant_id'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_working_key"><?php echo $this->lang->line('working_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="cca_working_key" value="<?php echo isset($payment_setting) ? $payment_setting->cca_working_key : ''; ?>" placeholder="<?php echo $this->lang->line('working_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('cca_working_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_access_code"><?php echo $this->lang->line('access_code'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="cca_access_code" value="<?php echo isset($payment_setting) ? $payment_setting->cca_access_code : ''; ?>" placeholder="<?php echo $this->lang->line('access_code'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('cca_access_code'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="cca_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->cca_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->cca_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('cca_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="cca_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->cca_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('cca_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cca_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="cca_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->cca_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->cca_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_paytm_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_key"><?php echo $this->lang->line('merchant_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="paytm_merchant_key" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_key : ''; ?>" placeholder="<?php echo $this->lang->line('merchant_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('paytm_merchant_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_mid"><?php echo $this->lang->line('merchant_mid'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="paytm_merchant_mid" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_mid : ''; ?>" placeholder="<?php echo $this->lang->line('merchant_mid'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('paytm_merchant_mid'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_website"><?php echo $this->lang->line('website'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="paytm_merchant_website" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_website : ''; ?>" placeholder="<?php echo $this->lang->line('website'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('paytm_merchant_website'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_industry_type"><?php echo $this->lang->line('industry_type'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="paytm_industry_type" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_industry_type : ''; ?>" placeholder="<?php echo $this->lang->line('industry_type'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('paytm_industry_type'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="paytm_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->paytm_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->paytm_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('paytm_demo'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="paytm_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('paytm_extra_charge'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="paytm_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->paytm_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->paytm_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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
                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_paystack_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stack_secret_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_secret_key : ''; ?>" placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stack_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_public_key : ''; ?>" placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="stack_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->stack_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->stack_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="stack_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stack_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="stack_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->stack_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->stack_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_jazzcash_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_merchant_id"><?php echo $this->lang->line('merchant_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="jaz_merchant_id" value="<?php echo isset($payment_setting) ? $payment_setting->jaz_merchant_id : ''; ?>" placeholder="<?php echo $this->lang->line('merchant_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('jaz_merchant_id'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="jaz_password" value="<?php echo isset($payment_setting) ? $payment_setting->jaz_password : ''; ?>" placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('jaz_password'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="jaz_salt" value="<?php echo isset($payment_setting) ? $payment_setting->jaz_salt : ''; ?>" placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('jaz_salt'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="jaz_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->jaz_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->jaz_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('jaz_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="jaz_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->jaz_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('jaz_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jaz_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="jaz_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->jaz_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->jaz_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('jaz_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.jazzcash.com.pk" target="_blank"><img src="<?php echo IMG_URL; ?>jazzcash-setting.png" alt="" /></a>
                                                            <div class="instructions">Pakistani Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_sslcommerz_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_store_id"><?php echo $this->lang->line('store_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ssl_store_id" value="<?php echo isset($payment_setting) ? $payment_setting->ssl_store_id : ''; ?>" placeholder="<?php echo $this->lang->line('store_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ssl_store_id'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ssl_password" value="<?php echo isset($payment_setting) ? $payment_setting->ssl_password : ''; ?>" placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ssl_password'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="ssl_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->ssl_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->ssl_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('ssl_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ssl_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->ssl_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ssl_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ssl_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="ssl_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->ssl_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->ssl_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('ssl_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.sslcommerz.com" target="_blank"><img src="<?php echo IMG_URL; ?>sslcommerz-setting.png" alt="" /></a>
                                                            <div class="instructions">Bangladeshi Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_dbbl_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_userid"><?php echo $this->lang->line('userid'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_userid" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_userid : ''; ?>" placeholder="<?php echo $this->lang->line('userid'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_userid'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_password" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_password : ''; ?>" placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_password'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_submername"><?php echo $this->lang->line('submer_name'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_submername" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_submername : ''; ?>" placeholder="<?php echo $this->lang->line('submer_name'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_submername'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_submerid"><?php echo $this->lang->line('submer_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_submerid" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_submerid : ''; ?>" placeholder="<?php echo $this->lang->line('submer_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_submerid'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_terminalid"><?php echo $this->lang->line('terminal_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_terminalid" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_terminalid : ''; ?>" placeholder="<?php echo $this->lang->line('terminal_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_terminalid'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="dbbl_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->dbbl_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->dbbl_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('dbbl_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="dbbl_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->dbbl_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('dbbl_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dbbl_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="dbbl_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->dbbl_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->dbbl_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('dbbl_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.dutchbanglabank.com/" target="_blank"><img src="<?php echo IMG_URL; ?>dbbl-setting.png" alt="" width="100" /></a>
                                                            <div class="instructions" style="margin:10px 0px;">Return URL: https://project root url/accounting/gateway/dbbl</div>
                                                            <div class="instructions" style="margin:10px 0px;">Bangladeshi Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_midtrans_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_client_key"><?php echo $this->lang->line('client_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mid_client_key" value="<?php echo isset($payment_setting) ? $payment_setting->mid_client_key : ''; ?>" placeholder="<?php echo $this->lang->line('client_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mid_client_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_server_key"><?php echo $this->lang->line('server_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mid_server_key" value="<?php echo isset($payment_setting) ? $payment_setting->mid_server_key : ''; ?>" placeholder="<?php echo $this->lang->line('server_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mid_server_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="mid_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->mid_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->mid_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('mid_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mid_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->mid_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mid_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mid_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="mid_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->mid_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->mid_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('mid_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://midtrans.com" target="_blank"><img src="<?php echo IMG_URL; ?>midtrans-setting.png" alt="" /></a>
                                                            <div class="instructions">Indonesian Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_instamojo_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mojo_api_key" value="<?php echo isset($payment_setting) ? $payment_setting->mojo_api_key : ''; ?>" placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mojo_api_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mojo_auth_token" value="<?php echo isset($payment_setting) ? $payment_setting->mojo_auth_token : ''; ?>" placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mojo_auth_token'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_key_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mojo_key_salt" value="<?php echo isset($payment_setting) ? $payment_setting->mojo_key_salt : ''; ?>" placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mojo_key_salt'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="mojo_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->mojo_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->mojo_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('mojo_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="mojo_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->mojo_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('mojo_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mojo_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="mojo_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->mojo_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->mojo_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('mojo_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.instamojo.com" target="_blank"><img src="<?php echo IMG_URL; ?>instamojo-setting.png" alt="" /></a>
                                                            <div class="instructions">Indian Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_flutter_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="flut_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->flut_public_key : ''; ?>" placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('flut_public_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="flut_secret_key" value="<?php echo isset($payment_setting) ? $payment_setting->flut_secret_key : ''; ?>" placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('flut_secret_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="flut_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->flut_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->flut_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('flut_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="flut_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->flut_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('flut_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flut_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="flut_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->flut_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->flut_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
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

                                                </div>

                                                <div class="tab-pane fade in " id="tab_edit_ipay_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_vendor_id"><?php echo $this->lang->line('vendor_id'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ipay_vendor_id" value="<?php echo isset($payment_setting) ? $payment_setting->ipay_vendor_id : ''; ?>" placeholder="<?php echo $this->lang->line('vendor_id'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ipay_vendor_id'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_hash_key"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ipay_hash_key" value="<?php echo isset($payment_setting) ? $payment_setting->ipay_hash_key : ''; ?>" placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ipay_hash_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="ipay_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->ipay_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->ipay_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('ipay_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="ipay_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->ipay_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('ipay_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipay_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="ipay_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->ipay_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->ipay_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('ipay_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.ipayafrica.com/ " target="_blank"><img src="<?php echo IMG_URL; ?>ipay-setting.png" alt="" /></a>
                                                            <div class="instructions">African Countries Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="tab-pane fade in " id="tab_edit_pesapal_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_cust_key"><?php echo $this->lang->line('customer_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="pesa_cust_key" value="<?php echo isset($payment_setting) ? $payment_setting->pesa_cust_key : ''; ?>" placeholder="<?php echo $this->lang->line('customer_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('pesa_cust_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_cust_secret"><?php echo $this->lang->line('customer_secret'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="pesa_cust_secret" value="<?php echo isset($payment_setting) ? $payment_setting->pesa_cust_secret : ''; ?>" placeholder="<?php echo $this->lang->line('customer_secret'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('pesa_cust_secret'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="pesa_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->pesa_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->pesa_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('pesa_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="pesa_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->pesa_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('pesa_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesa_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="pesa_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->pesa_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->pesa_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('pesa_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.pesapal.com" target="_blank"><img src="<?php echo IMG_URL; ?>pesapal-setting.png" alt="" /></a>
                                                            <div class="instructions">African Countries Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="tab-pane fade in " id="tab_edit_billplz_setting">
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="bill_api_key" value="<?php echo isset($payment_setting) ? $payment_setting->bill_api_key : ''; ?>" placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('bill_api_key'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="bill_demo" required="required">
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->bill_demo == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->bill_demo == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('bill_demo'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12" name="bill_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->bill_extra_charge : ''; ?>" placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                            <div class="help-block"><?php echo form_error('bill_extra_charge'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="bill_status" required="required">
                                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                <option value="0" <?php if (isset($payment_setting) && $payment_setting->bill_status == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('no'); ?></option>
                                                                <option value="1" <?php if (isset($payment_setting) && $payment_setting->bill_status == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            </select>
                                                            <div class="help-block"><?php echo form_error('bill_status'); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.billplz.com" target="_blank"><img src="<?php echo IMG_URL; ?>billplz-setting.png" alt="" /></a>
                                                            <div class="instructions">Malaysian Payment Gateway</div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-xs-3"></div>
                                        <div class="col-xs-9">
                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <input type="hidden" value="<?php echo isset($payment_setting) ? $payment_setting->id : '' ?>" name="id" />
                                                    <a href="<?php echo site_url('administrator/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                    <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-payment-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">�</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('payment_setting'); ?></h4>
            </div>
            <div class="modal-body fn_payment_data">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function get_payment_modal(payment_id) {

        $('.fn_payment_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loader.gif" /></p>');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('administrator/payment/get_single_payment'); ?>",
            data: {
                payment_id: payment_id
            },
            success: function(response) {
                if (response) {
                    $('.fn_payment_data').html(response);
                }
            }
        });
    }
</script>



<!-- datatable with buttons -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable-responsive').DataTable({
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