<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Payment.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Payment
 * @description     : Manage payment gateway settings.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Payment extends MY_Controller {

    public $data = array();

    function __construct() {
        
        parent::__construct();
        $this->load->model('Setting_Model', 'setting', true);
        
        if($this->session->userdata('role_id') == SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard/index');
        }
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_payment_gateway')){                        
              redirect('dashboard/index');
            }
        }
         
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['setting'] = $this->setting->get_single('payment_settings', $condition);           
        }
        
        
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Payment Setting" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);     
        
       
        $this->data['paypal'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

            
    /*****************Function paypal**********************************
    * @type            : Function
    * @function name   : paypal
    * @description     : Load "Paypal Setting Tab" user interface                 
    *                     and process to save paypal setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function paypal() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_paypal_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/paypal');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }
       
        $this->data['paypal'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

        
    /*****************Function _prepare_paypal_validation**********************************
    * @type            : Function
    * @function name   : _prepare_paypal_validation
    * @description     : Process "paypal" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_paypal_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        //$this->form_validation->set_rules('paypal_api_username', $this->lang->line('teacher'), 'trim|required');
        //$this->form_validation->set_rules('paypal_api_password', $this->lang->line('teacher'), 'trim|required');
        //$this->form_validation->set_rules('paypal_api_signature', $this->lang->line('teacher'), 'trim|required');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('paypal_email', $this->lang->line('paypal_email'), 'trim|required');
        $this->form_validation->set_rules('paypal_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('paypal_status', $this->lang->line('is_active'), 'trim|required');
    }

                
    /*****************Function stripe**********************************
    * @type            : Function
    * @function name   : stripe
    * @description     : Load "Stripe Setting Tab" user interface                 
    *                     and process to save stripe setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function stripe() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_stripe_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/stripe');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['stripe'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

            
    /*****************Function _prepare_stripe_validation**********************************
    * @type            : Function
    * @function name   : _prepare_stripe_validation
    * @description     : Process "stripe" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_stripe_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('stripe_secret', $this->lang->line('secret_key'), 'trim|required');
        $this->form_validation->set_rules('stripe_publishable', $this->lang->line('publishable_key'), 'trim|required');
        $this->form_validation->set_rules('stripe_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('stripe_status', $this->lang->line('is_active'), 'trim|required');
    }

                
    /*****************Function payumoney**********************************
    * @type            : Function
    * @function name   : payumoney
    * @description     : Load "Payumoney Setting Tab" user interface                 
    *                     and process to save payumoney setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function payumoney() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_payumoney_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/payumoney');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['payumoney'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

                
    /*****************Function _prepare_payumoney_validation**********************************
    * @type            : Function
    * @function name   : _prepare_payumoney_validation
    * @description     : Process "payumoney" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_payumoney_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('payumoney_key', $this->lang->line('payumoney_key'), 'trim|required');
        $this->form_validation->set_rules('payumoney_salt', $this->lang->line('key_salt'), 'trim|required');
        $this->form_validation->set_rules('payumoney_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('payumoney_status', $this->lang->line('is_active'), 'trim|required');
    }
    
    
        
                
    /*****************Function ccavenue**********************************
    * @type            : Function
    * @function name   : ccavenue
    * @description     : Load "CCAvenue Setting Tab" user interface                 
    *                     and process to save payumoney setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function ccavenue() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_ccavenue_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated CCAvenue payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added CCAvenue payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/ccavenue');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['ccavenue'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

                
    /*****************Function _prepare_ccavenue_validation**********************************
    * @type            : Function
    * @function name   : _prepare_ccavenue_validation
    * @description     : Process "ccavenue" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_ccavenue_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('cca_merchant_id', $this->lang->line('merchant_id'), 'trim|required');
        $this->form_validation->set_rules('cca_working_key', $this->lang->line('working_key'), 'trim|required');
        $this->form_validation->set_rules('cca_access_code', $this->lang->line('access_code'), 'trim|required');
        $this->form_validation->set_rules('cca_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('cca_status', $this->lang->line('is_active'), 'trim|required');
    }

    
    
                
    /*****************Function paytm**********************************
    * @type            : Function
    * @function name   : paytm
    * @description     : Load "PayTM Setting Tab" user interface                 
    *                     and process to save paytm setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function paytm() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_paytm_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated PauTM payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added PayTM payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/paytm');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['paytm'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

                
    /*****************Function _prepare_paytm_validation**********************************
    * @type            : Function
    * @function name   : _prepare_paytm_validation
    * @description     : Process "PayTM" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_paytm_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('paytm_merchant_key', $this->lang->line('merchant_key'), 'trim|required');
        $this->form_validation->set_rules('paytm_merchant_mid', $this->lang->line('merchant_mid'), 'trim|required');
        $this->form_validation->set_rules('paytm_merchant_website', $this->lang->line('website'), 'trim|required');
        $this->form_validation->set_rules('paytm_industry_type', $this->lang->line('industry_type'), 'trim|required');
        $this->form_validation->set_rules('paytm_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('paytm_status', $this->lang->line('is_active'), 'trim|required');
    }

    
    
                    
    /*****************Function paystack**********************************
    * @type            : Function
    * @function name   : paystack
    * @description     : Load "paystack Setting Tab" user interface                 
    *                     and process to save paystack setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function paystack() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_paystack_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated PauStack payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added PayStack payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/paystack');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['paystack'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_paystack_validation**********************************
    * @type            : Function
    * @function name   : _prepare_paystack_validation
    * @description     : Process "PayStack" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_paystack_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('stack_secret_key', $this->lang->line('secret_key'), 'trim|required');
        $this->form_validation->set_rules('stack_public_key', $this->lang->line('public_key'), 'trim|required');
        $this->form_validation->set_rules('stack_demo', $this->lang->line('is_demo'), 'trim|required');
        $this->form_validation->set_rules('stack_status', $this->lang->line('is_active'), 'trim|required');
    }

    
    /*****************Function Jazzcash**********************************
    * @type            : Function
    * @function name   : paystack
    * @description     : Load "jazzcash Setting Tab" user interface                 
    *                     and process to save jazzcash setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function jazzcash() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_jazzcash_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated jazzcash payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added PayStack payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/jazzcash');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['jazzcash'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_jazzcash_validation**********************************
    * @type            : Function
    * @function name   : _prepare_jazzcash_validation
    * @description     : Process "Jazzcash" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_jazzcash_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('jaz_merchant_id', $this->lang->line('merchant_id'), 'trim|required');
        $this->form_validation->set_rules('jaz_salt', $this->lang->line('jaz_salt'), 'trim|required');
        $this->form_validation->set_rules('jaz_password', $this->lang->line('password'), 'trim|required');
    }   
    
    /*****************Function SSLcommerz**********************************
    * @type            : Function
    * @function name   : SSLcommerz
    * @description     : Load "SSLcommerz Setting Tab" user interface                 
    *                     and process to save sslcommerz setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function sslcommerz() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_sslcommerz_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated sslcommerz payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added sslcommerz payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/sslcommerz');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['sslcommerz'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    /*****************Function _prepare_sslcommerz_validation**********************************
    * @type            : Function
    * @function name   : _prepare_sslcommerz_validation
    * @description     : Process "sslcommerz" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_sslcommerz_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('ssl_store_id', $this->lang->line('store_id'), 'trim|required');
        $this->form_validation->set_rules('ssl_password', $this->lang->line('password'), 'trim|required');
    }
    
    public function dbbl() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_dbbl_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated sslcommerz payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added dbbl payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/dbbl');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['dbbl'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    
    /*****************Function _prepare_dbbl_validation**********************************
    * @type            : Function
    * @function name   : _prepare_sslcommerz_validation
    * @description     : Process "dbbl" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_dbbl_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('dbbl_userid', $this->lang->line('userid'), 'trim|required');
        $this->form_validation->set_rules('dbbl_password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('dbbl_submername', $this->lang->line('submer_name'), 'trim|required');
        $this->form_validation->set_rules('dbbl_submerid', $this->lang->line('submer_id'), 'trim|required');
        $this->form_validation->set_rules('dbbl_terminalid', $this->lang->line('terminal_id'), 'trim|required');
        
    }
    
    /*****************Function Midtrans**********************************
    * @type            : Function
    * @function name   : SSLcommerz
    * @description     : Load "Midtrans Setting Tab" user interface                 
    *                     and process to save Midtrans setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function midtrans() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_midtrans_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated midtrans payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added midtrans payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/midtrans');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['midtrans'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_midtrans_validation**********************************
    * @type            : Function
    * @function name   : _prepare_midtrans_validation
    * @description     : Process "midtrans" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_midtrans_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('mid_client_key', $this->lang->line('client_key'), 'trim|required');
        $this->form_validation->set_rules('mid_server_key', $this->lang->line('server_key'), 'trim|required');
    }
    
    /*****************Function InstaMojo**********************************
    * @type            : Function
    * @function name   : InstaMojo
    * @description     : Load "InstaMojo Setting Tab" user interface                 
    *                     and process to save InstaMojo setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function instamojo() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_instamojo_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated instamojo payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added instamojo payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/instamojo');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['instamojo'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_instamojo_validation**********************************
    * @type            : Function
    * @function name   : _prepare_instamojo_validation
    * @description     : Process "instamojo" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_instamojo_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('mojo_api_key', $this->lang->line('api_key'), 'trim|required');
        $this->form_validation->set_rules('mojo_auth_token', $this->lang->line('auth_token'), 'trim|required');
        $this->form_validation->set_rules('mojo_key_salt', $this->lang->line('key_salt'), 'trim|required');
    }
    
    /*****************Function Pesapal**********************************
    * @type            : Function
    * @function name   : Pesapal
    * @description     : Load "Pesapal Setting Tab" user interface                 
    *                     and process to save Pesapal setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function pesapal() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_pesapal_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated pesapal payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added pesapal payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/pesapal');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['pesapal'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_pesapal_validation**********************************
    * @type            : Function
    * @function name   : _prepare_pesapal_validation
    * @description     : Process "pesapal" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_pesapal_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('pesa_cust_key', $this->lang->line('customer_key'), 'trim|required');
        $this->form_validation->set_rules('pesa_cust_secret', $this->lang->line('customer_secret'), 'trim|required');
    }
    
    /*****************Function Flutter Wave**********************************
    * @type            : Function
    * @function name   : Flutter Wave
    * @description     : Load "Flutter Wave Setting Tab" user interface                 
    *                     and process to save Flutter Wave setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function flutter() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_flutter_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated flutter payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added flutter payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/flutter');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['flutter'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_flutter_validation**********************************
    * @type            : Function
    * @function name   : _prepare_flutter_validation
    * @description     : Process "flutter" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_flutter_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('flut_public_key', $this->lang->line('public_key'), 'trim|required');
        $this->form_validation->set_rules('flut_secret_key', $this->lang->line('secret_key'), 'trim|required');
    }
    
    /*****************Function iPay**********************************
    * @type            : Function
    * @function name   : iPay
    * @description     : Load "iPay Setting Tab" user interface                 
    *                     and process to save iPay setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function ipay() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_ipay_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated ipay payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added ipay payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/ipay');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['ipay'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_ipay_validation**********************************
    * @type            : Function
    * @function name   : _prepare_ipay_validation
    * @description     : Process "ipay" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_ipay_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('ipay_vendor_id', $this->lang->line('vendor_id'), 'trim|required');
        $this->form_validation->set_rules('ipay_hash_key', $this->lang->line('hash_key'), 'trim|required');
    }
    
    /*****************Function Billplz**********************************
    * @type            : Function
    * @function name   : Billplz
    * @description     : Load "Billplz Setting Tab" user interface                 
    *                     and process to save Billplz setting inormation into database  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function billplz() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_billplz_validation();

            if ($this->form_validation->run() == TRUE) {
                $data = $this->_get_posted_payment_data();
                if ($this->input->post('id')) {
                    $update = $this->setting->update('payment_settings', $data, array('id' => $this->input->post('id')));
                    if ($update) {
                        
                        create_log('Has been updated ipay payment gateway setting');
                        success($this->lang->line('update_success'));
                    } else {
                        error($this->lang->line('update_failed'));
                    }
                } else {
                    $insert_id = $this->setting->insert('payment_settings', $data);
                    if ($insert_id) {
                        
                        create_log('Has been added billplz payment gateway setting');
                        success($this->lang->line('insert_success'));
                    } else {
                        error($this->lang->line('insert_failed'));
                    }
                }
                redirect('setting/payment/billplz');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['billplz'] = TRUE;
        $this->layout->title($this->lang->line('payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function _prepare_billplz_validation**********************************
    * @type            : Function
    * @function name   : _prepare_billplz_validation
    * @description     : Process "billplz" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_billplz_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('bill_api_key', $this->lang->line('api_key'), 'trim|required');
    }
    
    /*****************Function _get_posted_payment_data**********************************
    * @type            : Function
    * @function name   : _get_posted_payment_data
    * @description     : Prepare "Payment Settings" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_payment_data() {

        $items = array();

        if ($this->input->post('paypal')) {
            
            //$items[] = 'paypal_api_username';
            //$items[] = 'paypal_api_password';
            //$items[] = 'paypal_api_signature';
            $items[] = 'paypal_email';
            $items[] = 'paypal_demo';
            $items[] = 'paypal_status';
            $items[] = 'paypal_extra_charge';
        }

        if ($this->input->post('stripe')) {
            
            $items[] = 'stripe_secret';
            $items[] = 'stripe_publishable';
            $items[] = 'stripe_demo';
            $items[] = 'stripe_status';
            $items[] = 'stripe_extra_charge';
        }

        if ($this->input->post('payumoney')) {
            
            $items[] = 'payumoney_key';
            $items[] = 'payumoney_salt';
            $items[] = 'payumoney_demo';
            $items[] = 'payumoney_status';
            $items[] = 'payu_extra_charge';
        }
        
        if ($this->input->post('ccavenue')) {
            
            $items[] = 'cca_merchant_id';
            $items[] = 'cca_working_key';
            $items[] = 'cca_access_code';
            $items[] = 'cca_demo';
            $items[] = 'cca_status';
            $items[] = 'cca_extra_charge';
        }
        
        if ($this->input->post('paytm')) {
            
            $items[] = 'paytm_merchant_key';
            $items[] = 'paytm_merchant_mid';
            $items[] = 'paytm_merchant_website';
            $items[] = 'paytm_industry_type';
            $items[] = 'paytm_demo';
            $items[] = 'paytm_status';
            $items[] = 'paytm_extra_charge';
        }
        
        if ($this->input->post('paystack')) {
            
            $items[] = 'stack_secret_key';
            $items[] = 'stack_public_key';
            $items[] = 'stack_demo';
            $items[] = 'stack_extra_charge';
            $items[] = 'stack_status';       
        }
        
        if ($this->input->post('jazzcash')) {
            
            $items[] = 'jaz_merchant_id';
            $items[] = 'jaz_password';
            $items[] = 'jaz_salt';
            $items[] = 'jaz_demo';
            $items[] = 'jaz_extra_charge';
            $items[] = 'jaz_status';
        }
        
        if ($this->input->post('sslcommerz')) {
            
            $items[] = 'ssl_store_id';
            $items[] = 'ssl_password';
            $items[] = 'ssl_demo';
            $items[] = 'ssl_extra_charge';
            $items[] = 'ssl_status';
        }
        
        if ($this->input->post('dbbl')) {
            
            $items[] = 'dbbl_userid';
            $items[] = 'dbbl_password';
            $items[] = 'dbbl_submername';
            $items[] = 'dbbl_submerid';
            $items[] = 'dbbl_terminalid';
            $items[] = 'dbbl_extra_charge';
            $items[] = 'dbbl_demo';
            $items[] = 'dbbl_status';
        }
        
        if ($this->input->post('midtrans')) {
            
            $items[] = 'mid_client_key';
            $items[] = 'mid_server_key';
            $items[] = 'mid_demo';
            $items[] = 'mid_extra_charge';
            $items[] = 'mid_status';
        }
        
        if ($this->input->post('instamojo')) {
            
            $items[] = 'mojo_api_key';
            $items[] = 'mojo_auth_token';
            $items[] = 'mojo_key_salt';
            $items[] = 'mojo_demo';
            $items[] = 'mojo_extra_charge';
            $items[] = 'mojo_status';
        }
        
        if ($this->input->post('pesapal')) {
            
            $items[] = 'pesa_cust_key';
            $items[] = 'pesa_cust_secret';
            $items[] = 'pesa_demo';
            $items[] = 'pesa_extra_charge';
            $items[] = 'pesa_status';
        }
        
        if ($this->input->post('flutter')) {
            
            $items[] = 'flut_public_key';
            $items[] = 'flut_secret_key';
            $items[] = 'flut_demo';
            $items[] = 'flut_extra_charge';
            $items[] = 'flut_status';
        }
        
        if ($this->input->post('ipay')) {
            
            $items[] = 'ipay_vendor_id';
            $items[] = 'ipay_hash_key';
            $items[] = 'ipay_demo';
            $items[] = 'ipay_extra_charge';
            $items[] = 'ipay_status';
        }
        
        if ($this->input->post('billplz')) {
            
            $items[] = 'bill_api_key';
            $items[] = 'bill_demo';
            $items[] = 'bill_extra_charge';
            $items[] = 'bill_status';
        }
        
        $items[] = 'school_id';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
        }

        return $data;
    }

}
