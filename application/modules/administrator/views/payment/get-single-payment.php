<div class="" data-example-id="togglable-tabs">
    <ul class="nav nav-tabs bordered">
        <!-- <li class="active"><a href="#tab_pop_paypal_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?></a> </li>
        <li class=""><a href="#tab_pop_stripe_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?></a> </li>
        <li class=""><a href="#tab_pop_pumoney_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?></a> </li>
        <li class=""><a href="#tab_pop_ccavenue_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?></a> </li>
        <li class=""><a href="#tab_pop_paytm_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?></a> </li>
        <li class=""><a href="#tab_pop_paystack_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?></a> </li>
        <li class=""><a href="#tab_pop_midtrans_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mid_trans'); ?></a>
        <li class=""><a href="#tab_pop_jazzcash_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('jazz_cash'); ?></a> </li>
        <li class="active dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->lang->line('more'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li class=""><a href="#tab_pop_sslcommerz_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ssl_commerz'); ?></a> </li>
                <li class=""><a href="#tab_pop_dbbl_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('dbbl'); ?></a> </li>
                <li class=""><a href="#tab_pop_instamojo_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('insta_mojo'); ?></a> </li>
                <li class=""><a href="#tab_pop_flutter_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('flutter_wave'); ?></a> </li>
                <li class=""><a href="#tab_pop_ipay_setting" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ipay'); ?></a> </li>
               <li  class=""><a href="#tab_pop_pesapal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pesapal'); ?></a> </li>
                    <li  class=""><a href="#tab_pop_billplz_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bill_plz'); ?></a> </li>
            </ul>
        </li> -->
    </ul>
    <br />

    <div class="tab-content">

        <div class="tab-pane fade in active" id="tab_pop_paypal_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('paypal_email'); ?></th>
                        <td><?php echo $payment_setting->paypal_email; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->paypal_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->paypal_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->paypal_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in display" id="tab_pop_stripe_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('secret_key'); ?></th>
                        <td><?php echo $payment_setting->stripe_secret; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('publishable_key'); ?></th>
                        <td><?php echo $payment_setting->stripe_publishable; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->stripe_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th> <?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->stripe_demo ? $this->lang->line('yes') : $this->lang->line('no') ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->stripe_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_pumoney_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('payumoney_key'); ?></th>
                        <td><?php echo $payment_setting->payumoney_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('key_salt'); ?></th>
                        <td><?php echo $payment_setting->payumoney_salt; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->payu_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->payumoney_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->payumoney_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in display" id="tab_pop_ccavenue_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('merchant_id'); ?></th>
                        <td><?php echo $payment_setting->cca_merchant_id; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('working_key'); ?></th>
                        <td><?php echo $payment_setting->cca_working_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('access_code'); ?></th>
                        <td><?php echo $payment_setting->cca_access_code; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->cca_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->cca_demo  ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->cca_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_paytm_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('merchant_key'); ?></th>
                        <td><?php echo $payment_setting->paytm_merchant_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('merchant_mid'); ?></th>
                        <td><?php echo $payment_setting->paytm_merchant_mid; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('website'); ?></th>
                        <td><?php echo $payment_setting->paytm_merchant_website; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('industry_type'); ?></th>
                        <td><?php echo $payment_setting->paytm_industry_type; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->paytm_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->paytm_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->paytm_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_paystack_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('secret_key'); ?></th>
                        <td><?php echo $payment_setting->stack_secret_key; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('public_key'); ?></th>
                        <td><?php echo $payment_setting->stack_public_key; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->stack_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->stack_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->stack_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_jazzcash_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('merchant_id'); ?></th>
                        <td><?php echo $payment_setting->jaz_merchant_id; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('password'); ?></th>
                        <td><?php echo $payment_setting->jaz_password; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('key_salt'); ?></th>
                        <td><?php echo $payment_setting->jaz_salt; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->jaz_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->jaz_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->jaz_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_sslcommerz_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('store_id'); ?></th>
                        <td><?php echo $payment_setting->ssl_store_id; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('password'); ?></th>
                        <td><?php echo $payment_setting->ssl_password; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->ssl_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->ssl_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->ssl_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_dbbl_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('userid'); ?></th>
                        <td><?php echo $payment_setting->dbbl_userid; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('password'); ?></th>
                        <td><?php echo $payment_setting->dbbl_password; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('submer_name'); ?></th>
                        <td><?php echo $payment_setting->dbbl_submername; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('submer_id'); ?></th>
                        <td><?php echo $payment_setting->dbbl_submerid; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('terminal_id'); ?></th>
                        <td><?php echo $payment_setting->dbbl_terminalid; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->dbbl_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->dbbl_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->dbbl_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_midtrans_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('client_key'); ?></th>
                        <td><?php echo $payment_setting->mid_client_key; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('server_key'); ?></th>
                        <td><?php echo $payment_setting->mid_server_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->mid_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->mid_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->mid_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_instamojo_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('api_key'); ?></th>
                        <td><?php echo $payment_setting->mojo_api_key; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('auth_token'); ?></th>
                        <td><?php echo $payment_setting->mojo_auth_token; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('key_salt'); ?></th>
                        <td><?php echo $payment_setting->mojo_key_salt; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->mid_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->mojo_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->mojo_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div class="tab-pane fade in" id="tab_pop_flutter_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('public_key'); ?></th>
                        <td><?php echo $payment_setting->flut_public_key; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('secret_key'); ?></th>
                        <td><?php echo $payment_setting->flut_secret_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->flut_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->flut_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->flut_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_ipay_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('vendor_id'); ?></th>
                        <td><?php echo $payment_setting->ipay_vendor_id; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('hash_key'); ?></th>
                        <td><?php echo $payment_setting->ipay_hash_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->ipay_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->ipay_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->ipay_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="tab-pane fade in" id="tab_pop_pesapal_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('customer_key'); ?></th>
                        <td><?php echo $payment_setting->pesa_cust_key; ?></td>
                    </tr>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('customer_secret'); ?></th>
                        <td><?php echo $payment_setting->pesa_cust_secret; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->pesa_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->pesa_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->pesa_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade in" id="tab_pop_billplz_setting">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="40%"><?php echo $this->lang->line('api_key'); ?></th>
                        <td><?php echo $payment_setting->bill_api_key; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_demo'); ?></th>
                        <td><?php echo $payment_setting->bill_demo ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                        <td><?php echo $payment_setting->bill_extra_charge; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('is_active'); ?></th>
                        <td><?php echo $payment_setting->bill_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>