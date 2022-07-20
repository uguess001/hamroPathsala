<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Payment.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Payment
 * @description     : Manage all kind of paymnet transaction by integrated payment gateway.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Payment extends My_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
         $this->load->model('Payment_Model', 'payment', true);
         $this->load->model('Invoice_Model', 'invoice', true);
         
         $this->config->load('custom');
         $this->load->library("paypal");
         $this->load->library("ccaencrypt");
         $this->load->library('sslcommerz');
         $this->load->library('midtranspay');
         $this->load->library('stripepay');
         $this->load->library('instamojo');
         $this->load->helper('paytm');
         
          // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_accounting')){                        
              redirect('dashboard/index');
            }
        }
    }

    

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Payment" user interface                 
    *                    with specific invoice data   
    * @param           : $invoice_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($invoice_id = null) {
        
        check_permission(VIEW);
        
        if(!$invoice_id){
            redirect('accounting/invoice/due');
        }
        
        $invoice         = $this->payment->get_invoice_amount($invoice_id);      
        $due_amount      = $invoice->net_amount - $invoice->paid_amount;
        $this->data['due_amount'] = $due_amount;
        $this->data['invoice_id'] = $invoice_id;
        $this->data['school_id'] = $invoice->school_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title( $this->lang->line('payment'). ' | ' . SMS);
        $this->layout->view('payment/index', $this->data); 
    }
    

    
    /*****************Function paid**********************************
    * @type            : Function
    * @function name   : paid
    * @description     : Process invoice payment with integrated payment gateway                  
    *                      
    * @param           : $invoice_id integer value
    * @return          : null 
    * ********************************************************** */
    public function paid($invoice_id) {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_payment_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_payment_data();

                create_log('Has been proceeded a payment : '. $data['amount']. ' in :' . $this->input->post('payment_method'));
                
                if($this->input->post('payment_method') == 'cash' || $this->input->post('payment_method') == 'cheque' || $this->input->post('payment_method') == 'receipt'){
                    
                    $insert_id = $this->payment->insert('transactions', $data);
                    if($this->input->post('amount') < $this->input->post('due_amount')){
                        $update = array('paid_status'=> 'partial');
                    }else{
                        $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
                    }                    
                    $this->payment->update('invoices', $update, array('id'=>$invoice_id));
                    
                    success($this->lang->line('payment_success'));
                    if($this->input->post('invoice_type') == 'sale'){
                        redirect('inventory/sale/index');
                    }else{
                        redirect('accounting/invoice/index');
                    }
                    
                }elseif($this->input->post('payment_method') == 'paypal'){
                    
                    $this->paypal($data); 
                    
                }elseif($this->input->post('payment_method') == 'stripe'){
                    
                    $this->stripe($data); 
                    
                }elseif($this->input->post('payment_method') == 'payumoney'){
                    
                    $this->pay_u_money($data);  
                    
                }elseif($this->input->post('payment_method') == 'ccavenue'){
                    
                    $this->ccavenue($data); 
                    
                }elseif($this->input->post('payment_method') == 'paytm'){
                    
                    $this->pay_tm($data);  
                    
                }elseif($this->input->post('payment_method') == 'paystack'){
                    
                    $this->pay_stack($data);
                    
                }elseif($this->input->post('payment_method') == 'dbbl'){
                    
                    $this->dbbl($data);    
                    
                }elseif($this->input->post('payment_method') == 'jazzcash'){
                    
                    $this->jazzcash($data); 
                    
                }elseif($this->input->post('payment_method') == 'sslcommerz'){
                    
                    $this->sslcommerz($data);     
                    
                }elseif($this->input->post('payment_method') == 'midtrans'){
                    
                    $this->midtrans($data);     
                    
                }elseif($this->input->post('payment_method') == 'instamojo'){
                    
                    $this->instamojo($data);     
                    
                }elseif($this->input->post('payment_method') == 'pesapal'){
                    
                    $this->pesapal($data);     
                    
                }elseif($this->input->post('payment_method') == 'flutterwave'){
                    
                    $this->flutterwave($data);     
                    
                }elseif($this->input->post('payment_method') == 'ipay'){
                    
                    $this->ipay($data);     
                    
                }elseif($this->input->post('payment_method') == 'billplz'){
                    
                    $this->billplz($data);     
                    
                }else{                    
                    
                }
                    
            } else {
                                
                $this->data['post'] = $_POST;
                $this->data['invoice'] = $this->invoice->get_single('invoices', array('id' => $invoice_id));
                $this->data['due_amount'] = $this->input->post('amount');
                $this->data['invoice_id'] = $invoice_id;
                $this->data['list'] = TRUE;
                $this->layout->title($this->lang->line('payment').' | ' .SMS);
                $this->layout->view('payment/index', $this->data); 
                
            }
        }else{
            
            error($this->lang->line('unexpected_error'));
            redirect('accounting/invoice/index/'.$invoice_id);
        }
        
    }

    /*****************Function _prepare_payment_validation**********************************
    * @type            : Function
    * @function name   : _prepare_payment_validation
    * @description     : Process "Payment" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_payment_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');   
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|callback_amount');   
        $this->form_validation->set_rules('payment_method', $this->lang->line('payment_method'), 'trim|required|callback_payment_method');   
        
        if($this->input->post('payment_method') == 'cash'){
            
        }elseif($this->input->post('payment_method') == 'cheque'){
            
            $this->form_validation->set_rules('bank_name', $this->lang->line('bank_name'), 'trim|required');
            $this->form_validation->set_rules('cheque_no', $this->lang->line('cheque_number'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'receipt'){
            $this->form_validation->set_rules('bank_receipt', $this->lang->line('bank_receipt'), 'trim|required');    
       
        }elseif($this->input->post('payment_method') == 'paypal'){
            
        }elseif($this->input->post('payment_method') == 'stripe'){
            
            /*
            $this->form_validation->set_rules('card_number', $this->lang->line('card_number'), 'trim|required');
            $this->form_validation->set_rules('card_cvv', $this->lang->line('cvv'), 'trim|required');
            $this->form_validation->set_rules('expire_month', $this->lang->line('expire_month'), 'trim|required');
            $this->form_validation->set_rules('expire_year', $this->lang->line('expire_year'), 'trim|required');
            */
            
        }elseif($this->input->post('payment_method') == 'payumoney'){
            
            $this->form_validation->set_rules('pay_name', $this->lang->line('name'), 'trim|required');
            $this->form_validation->set_rules('pay_email', $this->lang->line('email'), 'trim|required');
            $this->form_validation->set_rules('pay_phone', $this->lang->line('phone'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'ccavenue'){
            
        }elseif($this->input->post('payment_method') == 'paytm'){
            
        }elseif($this->input->post('payment_method') == 'paystack'){
            $this->form_validation->set_rules('stack_email', $this->lang->line('email'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'dbbl'){            
            $this->form_validation->set_rules('card_type', $this->lang->line('card_type'), 'trim|required');	
            
        }elseif($this->input->post('payment_method') == 'jazzcash'){            
                       
        }elseif($this->input->post('payment_method') == 'sslcommerz'){
            
            $this->form_validation->set_rules('ssl_name', $this->lang->line('name'), 'trim|required');
            $this->form_validation->set_rules('ssl_email', $this->lang->line('email'), 'trim|required');
            $this->form_validation->set_rules('ssl_phone', $this->lang->line('phone'), 'trim|required');         
            $this->form_validation->set_rules('ssl_address', $this->lang->line('address'), 'trim|required');         
            $this->form_validation->set_rules('ssl_postcode', $this->lang->line('post_code'), 'trim|required');         
            $this->form_validation->set_rules('ssl_city', $this->lang->line('city'), 'trim|required'); 
            
        }elseif($this->input->post('payment_method') == 'instamojo'){
            
            $this->form_validation->set_rules('mojo_name', $this->lang->line('name'), 'trim|required');
            $this->form_validation->set_rules('mojo_email', $this->lang->line('email'), 'trim|required');
            $this->form_validation->set_rules('mojo_phone', $this->lang->line('phone'), 'trim|required'); 
            
        }elseif($this->input->post('payment_method') == 'flutterwave'){
            
            $this->form_validation->set_rules('flat_name', $this->lang->line('name'), 'trim|required');
            $this->form_validation->set_rules('flat_email', $this->lang->line('email'), 'trim|required');
            
         }elseif($this->input->post('payment_method') == 'ipay'){
            
            $this->form_validation->set_rules('ipay_email', $this->lang->line('email'), 'trim|required');
            $this->form_validation->set_rules('ipay_phone', $this->lang->line('phone'), 'trim|required'); 
            
        }elseif($this->input->post('payment_method') == 'billplz'){
            
            $this->form_validation->set_rules('bill_email', $this->lang->line('email'), 'trim|required');
             $this->form_validation->set_rules('bill_name', $this->lang->line('name'), 'trim|required');    
        }
        
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');   
    }
    
    
    
    /*****************Function amount**********************************
    * @type            : Function
    * @function name   : amount
    * @description     : validate payment "amount"                  
    *                     is amount is correct or not  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function amount() {
        
        $invoice_id      = $this->input->post('invoice_id');        
        $invoice         = $this->payment->get_invoice_amount($invoice_id);       
        $due_amount      = $invoice->net_amount - $invoice->paid_amount;
        
        if ($this->input->post('amount') > $due_amount) {
            $this->form_validation->set_message("amount", $this->lang->line('input_valid_amount'));
            return FALSE;
        }else{
            return TRUE;
        }
        
    }
  
    /*****************Function payment_method**********************************
    * @type            : Function
    * @function name   : payment_method
    * @description     : validate payment method                  
    *                   and check payment method is correct or not  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function payment_method() {
        
        $school_id = $this->input->post('school_id');
        $payment_method  = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$school_id));
      
        if ($this->input->post('payment_method') == 'cash' || $this->input->post('payment_method') == 'cheque' || $this->input->post('payment_method') == 'receipt') {
            return TRUE;
        } elseif ($this->input->post('payment_method') == 'paypal' && $payment_method->paypal_status == 1) {
            
            if ($payment_method->paypal_email  == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'stripe' && $payment_method->stripe_status == 1) {
            if ($payment_method->stripe_secret == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'payumoney' && $payment_method->payumoney_status == 1) {

            if ($payment_method->payumoney_key == "" || $payment_method->payumoney_salt == "") {
                $this->form_validation->set_message("unique_paymentmethod", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
       } elseif ($this->input->post('payment_method') == 'ccavenue' && $payment_method->cca_status == 1) {

            if ($payment_method->cca_merchant_id == "" || $payment_method->cca_working_key == "" || $payment_method->cca_access_code == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'paytm' && $payment_method->paytm_status == 1) {

            if ($payment_method->paytm_merchant_key == "" || $payment_method->paytm_merchant_mid == "" || $payment_method->paytm_merchant_website == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'paystack' && $payment_method->stack_status == 1) {

            if ($payment_method->stack_public_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'dbbl' && $payment_method->dbbl_status == 1) {

            if ($payment_method->dbbl_userid == "" || $payment_method->dbbl_password == "" || $payment_method->dbbl_submername == "" || $payment_method->dbbl_submerid == "" || $payment_method->dbbl_terminalid == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }  
            
        } elseif ($this->input->post('payment_method') == 'jazzcash' && $payment_method->jaz_status == 1) {

            if ($payment_method->jaz_merchant_id == "" || $payment_method->jaz_password == "" || $payment_method->jaz_salt == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            } 
            
        } elseif ($this->input->post('payment_method') == 'sslcommerz' && $payment_method->ssl_status == 1) {

            if ($payment_method->ssl_store_id == "" || $payment_method->ssl_password == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'midtrans' && $payment_method->mid_status == 1) {

            if ($payment_method->mid_client_key == "" || $payment_method->mid_server_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }  
            
        } elseif ($this->input->post('payment_method') == 'instamojo' && $payment_method->mojo_status == 1) {

            if ($payment_method->mojo_api_key == "" || $payment_method->mojo_auth_token == "" || $payment_method->mojo_key_salt == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'flutterwave' && $payment_method->flut_status == 1) {

            if ($payment_method->flut_public_key == "" || $payment_method->flut_secret_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }  
            
        } elseif ($this->input->post('payment_method') == 'ipay' && $payment_method->ipay_status == 1) {

            if ($payment_method->ipay_vendor_id == "" || $payment_method->ipay_hash_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            } 
            
        } elseif ($this->input->post('payment_method') == 'pesapal' && $payment_method->pesa_status == 1) {

            if ($payment_method->pesa_cust_key == "" || $payment_method->pesa_cust_secret == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }  
            
        } elseif ($this->input->post('payment_method') == 'billplz' && $payment_method->bill_status == 1) {

            if ($payment_method->bill_api_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }  
        }             
    }
    
    /*****************Function _get_posted_payment_data**********************************
    * @type            : Function
    * @function name   : _get_posted_payment_data
    * @description     : Prepare "Payment" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_payment_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'amount';
        $items[] = 'invoice_id';
        $items[] = 'payment_method';       
        $items[] = 'note';
        
        $data = elements($items, $_POST); 

        if($this->input->post('payment_method') == 'cheque'){
            $data['bank_name'] = $this->input->post('bank_name');
            $data['cheque_no'] = $this->input->post('cheque_no');
            
        }else if($this->input->post('payment_method') == 'payumoney'){
            $data['name'] = $this->input->post('pay_name');
            $data['email'] = $this->input->post('pay_email');
            $data['phone'] = $this->input->post('pay_phone');
            
        }else if($this->input->post('payment_method') == 'stripe'){
            /*
            $data['card_number'] = $this->input->post('card_number');
            $data['card_cvv'] = $this->input->post('card_cvv');
            $data['expire_month'] = $this->input->post('expire_month');
            $data['expire_year'] = $this->input->post('expire_year');
            */
            
        }else if($this->input->post('payment_method') == 'paystack'){
            $data['email'] = $this->input->post('stack_email');
            
        }else if($this->input->post('payment_method') == 'receipt'){
            $data['bank_receipt'] = $this->input->post('bank_receipt');
            
        }else if($this->input->post('payment_method') == 'dbbl'){
            $data['card_type'] = $this->input->post('card_type');
            
        }else if($this->input->post('payment_method') == 'sslcommerz'){
            
            $data['name'] = $this->input->post('ssl_name');
            $data['email'] = $this->input->post('ssl_email');
            $data['phone'] = $this->input->post('ssl_phone');	
            $data['address'] = $this->input->post('ssl_address');	
            $data['city'] = $this->input->post('ssl_city');	
            $data['postcode'] = $this->input->post('ssl_postcode');	
            
        }else if($this->input->post('payment_method') == 'instamojo'){
            
            $data['name'] = $this->input->post('mojo_name');
            $data['email'] = $this->input->post('mojo_email');
            $data['phone'] = $this->input->post('mojo_phone');
            
        }else if($this->input->post('payment_method') == 'flutterwave'){
            
            $data['name'] = $this->input->post('flat_name');
            $data['email'] = $this->input->post('flat_email');
            
        }else if($this->input->post('payment_method') == 'ipay'){
            
            $data['phone'] = $this->input->post('ipay_phone');
            $data['email'] = $this->input->post('ipay_email');   
            
        }else if($this->input->post('payment_method') == 'billplz'){
            
            $data['name'] = $this->input->post('bill_name');
            $data['email'] = $this->input->post('bill_email');
         }
              
        $data['status'] = 1;
        
        $school = $this->payment->get_school_by_id($data['school_id']);
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('accounting/payment/index/'.$data['invoice_id']);
        }        
        $data['academic_year_id'] = $school->academic_year_id;  
        
        $data['payment_date'] = date('Y-m-d');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id(); 

        return $data;
    }
    
    
    
    /* iPay Payment START */    
    
    /*****************Function ipay**********************************
    * @type            : Function
    * @function name   : ipay
    * @description     : Payment processing using "ipay" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function ipay($data) {

        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $school   = $this->payment->get_single('schools', array('status'=>1, 'id'=>$data['school_id']));
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->ipay_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->ipay_extra_charge/100*$data['amount']);
        }   
        
        $fields = array(
                "live"=> $payment_setting->ipay_demo ? 0 : 1,
                "oid"=> 'inv'.uniqid(),
                "inv"=> time(),
                "ttl"=> number_format((float) ($pay_amount), 2, '.', ''),
                "tel"=> $data['phone'],
                "eml"=> $data['email'],
                "vid"=> strtolower($payment_setting->ipay_vendor_id),
                "curr"=> strtoupper($school->currency),
                "p1"=> "airtel",
                "p2"=> $data['note'] ? $data['note'] : "Fee Collention for via IPay",
                "p3"=> $data['invoice_id'],
                "p4"=> number_format((float) ($pay_amount), 2, '.', ''),
                "cbk"=> base_url('accounting/payment/ipay_success/' . $data['invoice_id']),
                "cst"=> "1",
                "crl"=> "2"
        );
        
        $ipay_data = array();
        $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
        $hashkey = $payment_setting->ipay_hash_key; 
        $generated_hash = hash_hmac('sha1',$datastring , $hashkey);
        $ipay_data['fields'] = $fields;
        $ipay_data['generated_hash'] = $generated_hash;
        
        $this->load->view('payment/i_pay', $ipay_data);       
        
    }
    
    
     /*****************Function ipay_success**********************************
    * @type            : Function
    * @function name   : ipay_success
    * @description     : ipay peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function ipay_success(){
       
        $invoice_id = $this->uri->segment(4);
            
        //print_r($_REQUEST);
        // Array ( [status] => aei7p7yrx4ae34 [txncd] => 251429953787 [msisdn_id] => JOHN DOE [msisdn_idnum] => 8801762022554 [p1] => airtel [p2] => Fee Collention for via IPay [p3] => 36 [p4] => 100.00 [uyt] => 1688553039 [agt] => 1872783740 [qwh] => 1150920921 [ifd] => 252182381 [afd] => 848264269 [poi] => 900669445 [id] => inv62b01600d4537 [ivm] => inv62b01600d4537 [mc] => 100.00 [channel] => MPESA )
        //die();
         if (isset($_GET['status']) && isset($_GET['txncd'])) {
        
            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));

            $payment = $this->payment->get_invoice_amount($invoice_id);                
            $school = $this->payment->get_school_by_id($invoice->school_id);

            $transaction_id = $_GET['txncd']; 
            $reference = $_GET['id'];

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'iPay';
            $data['transaction_id'] = $transaction_id;
            $data['reference'] = $reference;
            $data['note'] = $_GET['p2'].' : Via :- '. $_GET['channel'];
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();

            $this->payment->insert('transactions', $data);
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if (floatval($data['amount']) < floatval($due_mount)) {
                $update = array('paid_status' => 'partial');
            } else {
                $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
            }

            $this->payment->update('invoices', $update, array('id' => $invoice_id));
            success($this->lang->line('payment_success'));
            
        }else{
            
            error($this->lang->line('payment_failed'));
        }
        
       redirect('accounting/invoice/index/' . $invoice_id);             
    }   

    /* iPay Payment END */  
    
    
    /* flutterwave Payment START */    
    
    /*****************Function flutterwave**********************************
    * @type            : Function
    * @function name   : flutterwave
    * @description     : Payment processing using "flutterwave" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function flutterwave($data) {

        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $school   = $this->payment->get_single('schools', array('status'=>1, 'id'=>$data['school_id']));
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->flut_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->flut_extra_charge/100*$data['amount']);
        }
        
        
       
        $flat_data = array();  
        $flat_data['public_key'] = $payment_setting->flut_public_key;
        $flat_data['email'] = $data['email'];
        $flat_data['name'] = $data['name'];
        $flat_data['tx_ref'] = 'txn-'.uniqid();
        $flat_data['amount'] = number_format((float) ($pay_amount), 2, '.', '');
        $flat_data['currency'] = strtoupper($school->currency);
        $flat_data['token'] = $data['invoice_id'];
        $flat_data['redirect_url'] = base_url('accounting/payment/flutterwave_success/' . $data['invoice_id']);
      
        $this->load->view('payment/flutter_wave', $flat_data);
       
        
    }
    
    
     /*****************Function flutterwave_success**********************************
    * @type            : Function
    * @function name   : flutterwave_success
    * @description     : flutterwave peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function flutterwave_success(){
       
        $invoice_id = $this->uri->segment(4);
                
         if (isset($_GET['status']) && isset($_GET['tx_ref']) && $_GET['status'] == 'successful') {
        
            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));

            $payment = $this->payment->get_invoice_amount($invoice_id);                
            $school = $this->payment->get_school_by_id($invoice->school_id);

            $transaction_id = $_GET['transaction_id']; 
            $reference = $_GET['tx_ref'];

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'flutterwave';
            $data['transaction_id'] = $transaction_id;
            $data['reference'] = $reference;
            $data['note'] = 'Online Payment via Flutter Wave';
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();

            $this->payment->insert('transactions', $data);
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if (floatval($data['amount']) < floatval($due_mount)) {
                $update = array('paid_status' => 'partial');
            } else {
                $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
            }

            $this->payment->update('invoices', $update, array('id' => $invoice_id));
            success($this->lang->line('payment_success'));
            
        }else{
            
            error($this->lang->line('payment_failed'));
        }
        
       redirect('accounting/invoice/index/' . $invoice_id);             
    }   

    /* flutterwave Payment END */  

    
    
    /* Instamojo Payment START */    
    
    /*****************Function instamojo**********************************
    * @type            : Function
    * @function name   : instamojo
    * @description     : Payment processing using "instamojo" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function instamojo($data) {

        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->mojo_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->mojo_extra_charge/100*$data['amount']);
        }         
       
        $mojo_data = array();        
        $mojo_data['purpose'] = 'Collect Student Fee';
        $mojo_data['amount'] = number_format((float) ($pay_amount), 2, '.', '');
        $mojo_data['phone'] = $data['phone'];
        $mojo_data['buyer_name'] = $data['name'];
        $mojo_data['email'] = $data['email'];
        $mojo_data['redirect_url'] = base_url('accounting/payment/instamojo_success/' . $data['invoice_id']);
        $mojo_data['webhook']   = base_url('accounting/gateway/webhook/' . $data['invoice_id']);
      
        
        $response  = $this->instamojo->payment($mojo_data);
        
          
        $json = json_decode($response, true);
        if ($json['success']) {
               
            $url = $json['payment_request']['longurl'];
            header("Location: $url");
            
        } else {
            
          
             $error = '';  
             if(!is_array($json['message'])){
                  $error .= $json['message'];  
             }
             
             foreach ($json['message'] as $value) {
                foreach ($value as $key => $value1) {
                    $error .= $value1.". ";
                }                                        
            }
           
            error($this->lang->line('payment_failed'). ' Api Error: '. $error);
            redirect('accounting/invoice/index/' . $data['invoice_id']); 
        }
        
        redirect('accounting/invoice/index/' . $data['invoice_id']);  
        
    }
    
    
     /*****************Function instamojo_success**********************************
    * @type            : Function
    * @function name   : instamojo_success
    * @description     : instamojo peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function instamojo_success(){
       
        $invoice_id = $this->uri->segment(4); 
        
         if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'Credit') {
        
            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));

            $payment = $this->payment->get_invoice_amount($invoice_id);                
            $school = $this->payment->get_school_by_id($invoice->school_id);

            $payment_id = $_GET['payment_id']; 
            $payment_request_id = $status['payment_request_id'];

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'instamojo';
            $data['transaction_id'] = $payment_id;
            $data['reference'] = $payment_request_id;
            $data['note'] = 'Online Payment via Instamojo';
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();

            $this->payment->insert('transactions', $data);
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if (floatval($data['amount']) < floatval($due_mount)) {
                $update = array('paid_status' => 'partial');
            } else {
                $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
            }

            $this->payment->update('invoices', $update, array('id' => $invoice_id));
            success($this->lang->line('payment_success'));
            
        }else{
            
            error($this->lang->line('payment_failed'));
        }
        
       redirect('accounting/invoice/index/' . $invoice_id);             
    }   

    /* Instamojo Payment END */  

    
    
    /* ccavenue Payment START */    
    
    /*****************Function ccavenue**********************************
    * @type            : Function
    * @function name   : ccavenue
    * @description     : Payment processing using "ccavenue" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function ccavenue($data) {

        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->stripe_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->stripe_extra_charge/100*$data['amount']);
        } 
     
        $cca_data = array();        
        $cca_data['tid']          = abs(crc32(uniqid()));
        $cca_data['merchant_id']  = $payment_setting->cca_merchant_id;
        $cca_data['order_id']     = abs(crc32(uniqid()));
        $cca_data['amount']       = number_format((float) ($pay_amount), 2, '.', '');
        $cca_data['currency']     = 'INR';
        $cca_data['redirect_url'] = base_url('accounting/payment/ccavenue_success/' . $data['invoice_id']);
        $cca_data['cancel_url']   = base_url('accounting/payment/ccavenue_success/' . $data['invoice_id']);
        $cca_data['language']     = "EN";
        $cca_data['billing_name'] = $this->session->userdata('name');

        $merchant_data = "";
        foreach ($cca_data as $key => $value) {
            $merchant_data .= $key . '=' . $value . '&';
        }
        
        
        if ($payment_setting->cca_demo == TRUE) {          
            $data['api_link'] = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        } else {
            $data['api_link'] = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }
        
        $data['encrypt_request']  = $this->ccaencrypt->encrypt($merchant_data, $payment_setting->cca_working_key);
        $data['access_code'] = $payment_setting->cca_access_code;            
        $this->load->view('payment/cc_avenue', $data);
        
    }
    
    
     /*****************Function ccavenue_success**********************************
    * @type            : Function
    * @function name   : ccavenue_success
    * @description     : ccavenue peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function ccavenue_success(){
       
        $invoice_id = $this->uri->segment(4); 
        
        if(isset($_POST["encResp"]) && !empty($_POST["encResp"])){
        
            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));

            $working_key  =  $payment_setting->cca_working_key;	            
            $encResponse = $_POST["encResp"];            
            $rcvdString  = $this->ccaencrypt->decrypt($encResponse,$working_key);
            $order_status="";
            $decryptValues=explode('&', $rcvdString);
            $dataSize=sizeof($decryptValues);            

            for($i = 0; $i < $dataSize; $i++) 
            {
                $information=explode('=',$decryptValues[$i]);
                if($i==3){	$order_status=$information[1];}
            }            

            if($order_status==="Success"){

                $payment = $this->payment->get_invoice_amount($invoice_id);                
                $school = $this->payment->get_school_by_id($invoice->school_id);

                $tracking_id = $status['tracking_id'];
                $bank_ref_no = $status['bank_ref_no'];
                
                $data['school_id'] = $invoice->school_id;
                $data['invoice_id'] = $invoice_id;
                $data['amount'] = $invoice->temp_amount;
                $data['payment_method'] = 'ccavenue';
                $data['transaction_id'] = $tracking_id;
                $data['reference'] = $bank_ref_no;
                $data['note'] = 'Online Payment via CCAvenue';
                $data['status'] = 1;
                $data['academic_year_id'] = $school->academic_year_id;
                $data['payment_date'] = date('Y-m-d');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();

                $this->payment->insert('transactions', $data);
                $due_mount = $invoice->net_amount - $payment->paid_amount;

                if (floatval($data['amount']) < floatval($due_mount)) {
                    $update = array('paid_status' => 'partial');
                } else {
                    $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
                }

                $this->payment->update('invoices', $update, array('id' => $invoice_id));
                success($this->lang->line('payment_success'));

            }else{
                
                error($this->lang->line('payment_success').'. Reason: '.$order_status);
            } 
            
        }else{
            
            error($this->lang->line('payment_failed'));
        }
        
       redirect('accounting/invoice/index/' . $invoice_id);             
    }   

    /* ccavenue Payment END */  

    
    
     /* stripe Payment START */
    
      /*****************Function stripe**********************************
    * @type            : Function
    * @function name   : stripe
    * @description     : Payment processing using "stripe" payment gateway                 
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function stripe($data){   
        
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->stripe_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->stripe_extra_charge/100*$data['amount']);
        } 
        
        $invoice   = $this->payment->get_single('invoices', array('status'=>1, 'id'=>$data['invoice_id']));
        $school = $this->payment->get_school_by_id($data['school_id']);
        
        $stripe_data = array(
            'image_url' =>  UPLOAD_PATH.'/logo/'. $school->logo,
            'success_url' =>  base_url('accounting/payment/stripe_success/'.$data['invoice_id'].'/{CHECKOUT_SESSION_ID}'),
            'cancel_url' => base_url('accounting/payment/stripe_success/'.$data['invoice_id'].'/{CHECKOUT_SESSION_ID}'),           
            'description' => "Collection Online Fees : Invoice NO#" . $invoice->custom_invoice_id,
            'amount' => $pay_amount,
            'currency' => $school->currency,
        );
        
        $response = $this->stripepay->payment($stripe_data);
        
        
        $stripe_data['session_id'] = $response['id'];
        $stripe_data['stripe_publishable'] = $payment_setting->stripe_publishable;
        $this->load->view('payment/stripe', $stripe_data);	
        
    }
    
    /*****************Function stripe_success**********************************
    * @type            : Function
    * @function name   : stripe_success
    * @description     : stripe peyment processing success url                
                         load user interface with success message 
    *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function stripe_success()
    {
        
        $invoice_id = $this->uri->segment(4);         
        $session_id = $this->uri->segment(5);         
        
         if (!empty($session_id)) {

            try { 
                
                $response = $this->stripepay->verify($session_id);
                if (isset($response->payment_status) && $response->payment_status == 'paid') {
                    
                    $invoice = $this->invoice->get_single_invoice($invoice_id);
                    $payment = $this->payment->get_invoice_amount($invoice_id);
                    $school = $this->payment->get_school_by_id($invoice->school_id);

                    $ref_id = $response->payment_intent;
                    
                    $data['school_id'] = $invoice->school_id;
                    $data['invoice_id'] = $invoice_id;
                    $data['amount'] = $invoice->temp_amount;
                    $data['payment_method'] = 'stripe';
                    $data['transaction_id'] = $ref_id;
                    $data['reference'] = $ref_id;
                    $data['note'] = 'Online Payment via Stripe Pay';
                    $data['status'] = 1;
                    $data['academic_year_id'] = $school->academic_year_id;
                    $data['payment_date'] = date('Y-m-d');
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();

                    $this->payment->insert('transactions', $data);
                    $due_mount = $invoice->net_amount - $payment->paid_amount;

                    if (floatval($data['amount']) < floatval($due_mount)) {
                        $update = array('paid_status' => 'partial');
                    } else {
                        $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
                    }

                    $this->payment->update('invoices', $update, array('id' => $invoice_id));
                    success($this->lang->line('payment_success'));
                
                } else {
                     error($this->lang->line('payment_failed').' : Payment Status '.$response->payment_status);
                }
         
            } catch (\Exception $ex) {

                 error($this->lang->line('payment_failed').' '.$ex->getMessage());
            }    
            
        }else{              
              error($this->lang->line('payment_failed'));
        }
          
        redirect('accounting/invoice/index/' . $invoice_id); 
    }    
    
     /* stripe Payment END */
    
    
    
     /* midtrans Payment START */
    
    /*****************Function midtrans**********************************
    * @type            : Function
    * @function name   : midtrans
    * @description     : Payment processing using "midtrans" payment gateway                 
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function midtrans($data){   
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->mid_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->mid_extra_charge/100*$data['amount']);
        } 
        
        $order_id = rand();
        $response = $this->midtranspay->getSnapToken(round($pay_amount), $order_id);  
        
        if(!$response){
            error('Access denied due to unauthorized transaction, please check client or server key');
            redirect('accounting/invoice/index/' . $data['invoice_id']); 
        }
        
        $data['snap_token'] = $response;        
        $data['mid_client_key'] = $payment_setting->mid_client_key;
        $this->load->view('payment/mid_trans', $data);	
        
    }
    
    /*****************Function midtrans_success**********************************
    * @type            : Function
    * @function name   : midtrans_success
    * @description     : midtrans peyment processing success url                
                         load user interface with success message 
    *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function midtrans_success()
    {
        $invoice_id = $this->uri->segment(4);         
        $response = json_decode($_POST['data']);
        
        if (!empty($response)) {

            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment = $this->payment->get_invoice_amount($invoice_id);
            $school = $this->payment->get_school_by_id($invoice->school_id);

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'midtrans';
            $data['transaction_id'] = $response->transaction_id;
            $data['note'] = 'Online Payment via midtrans';
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();

            $this->payment->insert('transactions', $data);
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if (floatval($data['amount']) < floatval($due_mount)) {
                $update = array('paid_status' => 'partial');
            } else {
                $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
            }

            $this->payment->update('invoices', $update, array('id' => $invoice_id));
            success($this->lang->line('payment_success'));
                
            
        }else{              
              error($this->lang->line('payment_failed'));
        }
          
        redirect('accounting/invoice/index/' . $invoice_id); 
    }    
    
    /* midtrans Payment END  */
    
    
    /* sslcommerz Payment START */
    
     /*****************Function sslcommerz**********************************
    * @type            : Function
    * @function name   : sslcommerz
    * @description     : Payment processing using "sslcommerz" payment gateway                 
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function sslcommerz($data){   
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->ssl_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->ssl_extra_charge/100*$data['amount']);
        } 
        
        
        $post_data = array();
        $post_data['total_amount'] = floatval($pay_amount);
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "SSLC" . uniqid();
        $post_data['success_url'] = base_url('accounting/payment/sslcommerz_success');
        $post_data['fail_url'] = base_url('accounting/payment/sslcommerz_success');
        $post_data['cancel_url'] = base_url('accounting/payment/sslcommerz_success');
        $post_data['ipn_url'] = base_url('accounting/gateway/sslcommerz');

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $data['name'];
        $post_data['cus_email'] = $data['email'];
        $post_data['cus_phone'] = $data['phone'];
        $post_data['cus_add1'] = $data['address'];
        $post_data['cus_city'] = $data['city'];
        $post_data['cus_state'] = $data['city'];
        $post_data['cus_postcode'] = $data['postcode'];
        $post_data['cus_country'] = "Bangladesh";
        
        
        #Shipment Information
        $post_data['shipping_method'] = "No";
        $post_data['num_of_item'] = "1";
        
        #Product Information
        $post_data['product_name'] = "Student Fee Collection";
        $post_data['product_category'] = "Fee Collection";
        $post_data['product_profile'] = "non-physical-goods";
        $post_data['value_a'] = $data['invoice_id'];
        $post_data['value_b'] = $post_data['tran_id'];
       
        $this->sslcommerz->sendRequest($post_data);
        
    }
    
    /*****************Function sslcommerz_success**********************************
    * @type            : Function
    * @function name   : sslcommerz_success
    * @description     : sslcommerz peyment processing success url                
                         load user interface with success message 
    *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function sslcommerz_success()
    {
        // getting from custom data
        $invoice_id = $_POST['value_b'];
         
        if (($_POST['status'] == 'VALID') && ($_POST['value_b'] == $_POST['tran_id'])) {

            if ($this->sslcommerz->validateTxn($_POST['currency_amount'], "BDT", $_POST)) {

                $invoice = $this->invoice->get_single_invoice($invoice_id);
                $payment = $this->payment->get_invoice_amount($invoice_id);
                $school = $this->payment->get_school_by_id($invoice->school_id);

                $data['school_id'] = $invoice->school_id;
                $data['invoice_id'] = $invoice_id;
                $data['amount'] = $invoice->temp_amount;
                $data['payment_method'] = 'sslcommerz';
                $data['transaction_id'] = $_POST['tran_id'];
                $data['note'] = 'Online Payment via sslCommerz';
                $data['status'] = 1;
                $data['academic_year_id'] = $school->academic_year_id;
                $data['payment_date'] = date('Y-m-d');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();

                $this->payment->insert('transactions', $data);
                $due_mount = $invoice->net_amount - $payment->paid_amount;

                if (floatval($data['amount']) < floatval($due_mount)) {
                    $update = array('paid_status' => 'partial');
                } else {
                    $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
                }

                $this->payment->update('invoices', $update, array('id' => $invoice_id));
                success($this->lang->line('payment_success'));
                
            }else{
                
                error($this->lang->line('payment_failed').' | '. $_POST['status']);
            }
        }else{              
              error($this->lang->line('payment_failed').' | '. $_POST['status']);
          }
          
        redirect('accounting/invoice/index/' . $invoice_id); 
    }
    
    /* sslcommerz Payment START */
    
    /* jazzcash Payment START */    
     /*****************Function jazzcash**********************************
    * @type            : Function
    * @function name   : jazzcash
    * @description     : Payment processing using "jazzcash" payment gateway                 
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function jazzcash($data)
    {        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice   = $this->payment->get_single('invoices', array('status'=>1, 'id'=>$data['invoice_id']));
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->jaz_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->jaz_extra_charge/100*$data['amount']);
        }         
                 
        $jaz_Salt = $payment_setting->jaz_salt;        
        
        $post_data =  array(
            "pp_Version"                => "2.0",
            "pp_TxnType"                => "MPAY",
            "pp_Language"               => "EN",
            "pp_IsRegisteredCustomer"   => "Yes", // x
            "pp_TokenizedCardNumber"    => "", // x
            "pp_CustomerEmail"          => "", // x
            "pp_CustomerMobile"         => "", // x
            "pp_CustomerID"             => uniqid(), // x
            "pp_MerchantID"             => $payment_setting->jaz_merchant_id,
            "pp_Password"               => $payment_setting->jaz_password,
            "pp_TxnRefNo"               => 'T'. date('YmdHis'),
            "pp_Amount"                 => floatval($pay_amount)*100,
            "pp_DiscountedAmount"       => "", // x
            "pp_DiscountBank"           => "", // x
            "pp_TxnCurrency"            => "PKR",
            "pp_TxnDateTime"            => date('YmdHis'),
            "pp_BillReference"          => uniqid(),
            "pp_Description"            => "Online Payment from a Student. Invoice No :- " . $invoice->custom_invoice_id,
            "pp_TxnExpiryDateTime"      => date('YmdHis', strtotime("+1 month")),
            "pp_ReturnURL"              => base_url('accounting/payment/jazzcash_success/' . $data['invoice_id']),
            "ppmpf_1"                   => "1",
            "ppmpf_2"                   => "2",
            "ppmpf_3"                   => "3",
            "ppmpf_4"                   => "4",
            "ppmpf_5"                   => "5",
        );

        $sorted_string  = $jaz_Salt . '&';
        $sorted_string .= $post_data['pp_Amount'] . '&';
        $sorted_string .= $post_data['pp_BillReference'] . '&';
        $sorted_string .= $post_data['pp_CustomerID'] . '&';
        $sorted_string .= $post_data['pp_Description'] . '&';
        $sorted_string .= $post_data['pp_IsRegisteredCustomer'] . '&';
        $sorted_string .= $post_data['pp_Language'] . '&';
        $sorted_string .= $post_data['pp_MerchantID'] . '&';
        $sorted_string .= $post_data['pp_Password'] . '&';
        $sorted_string .= $post_data['pp_ReturnURL'] . '&';
        $sorted_string .= $post_data['pp_TxnCurrency'] . '&';
        $sorted_string .= $post_data['pp_TxnDateTime'] . '&';
        $sorted_string .= $post_data['pp_TxnExpiryDateTime'] . '&';
        $sorted_string .= $post_data['pp_TxnRefNo'] . '&';
        $sorted_string .= $post_data['pp_TxnType'] . '&';
        $sorted_string .= $post_data['pp_Version'] . '&';
        $sorted_string .= $post_data['ppmpf_1'] . '&';
        $sorted_string .= $post_data['ppmpf_2'] . '&';
        $sorted_string .= $post_data['ppmpf_3'] . '&';
        $sorted_string .= $post_data['ppmpf_4'] . '&';
        $sorted_string .= $post_data['ppmpf_5'];

        //sha256 Hash Encoding
        $pp_SecureHash = hash_hmac('sha256', $sorted_string, $jaz_Salt);
        $post_data['pp_SecureHash'] =  $pp_SecureHash;
        
        $form_data = array();
        
        if ($payment_setting->jaz_demo == 1) {
            $form_data['api_url'] = "https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/";
        } else {
            $form_data['api_url'] = "https://jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/";
        }
        
        $form_data['post_data'] = $post_data;
        $this->load->view('payment/jazz_cash', $form_data);	
        
    }

   
    /*****************Function jazzcash_success**********************************
    * @type            : Function
    * @function name   : jazzcash_success
    * @description     : jazzcash peyment processing success url                
                         load user interface with success message 
    *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function jazzcash_success()
    {
        $invoice_id = $this->uri->segment(4);
       
        if (isset($_POST['pp_ResponseCode']) && $_POST['pp_ResponseCode'] == '000') {
            
            $txn_id = $_POST['pp_TxnRefNo'];            
           
            $invoice = $this->invoice->get_single_invoice($invoice_id);
            $payment = $this->payment->get_invoice_amount($invoice_id);   
            $school = $this->payment->get_school_by_id($invoice->school_id);    

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'jazzCash';
            $data['transaction_id'] = $txn_id;            
            $data['note'] = 'Online Payment via JazzCash'; 
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($data['amount']) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }
            
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));
            success($this->lang->line('payment_success'));
        
        } else {
            
            error($this->lang->line('payment_failed').' | '. $_POST['pp_ResponseMessage']);
        }
        
        redirect('accounting/invoice/index/' . $invoice_id); 
    }
    /* Jazzcash Payment END */  
        
        
    /* DBBL Payment Start */  
	
    /*****************Function dbbl**********************************
    * @type            : Function
    * @function name   : dbbl
    * @description     : Payment processing using "dbbl" payment gateway                 
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function dbbl($data)
    {
		
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->dbbl_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->dbbl_extra_charge/100*$data['amount']);
        }        
		
        $data = array(
                'userid' => $payment_setting->dbbl_userid,
                'password' => $payment_setting->dbbl_password,
                'submername' => $payment_setting->dbbl_submername,
                'submerid' => $payment_setting->dbbl_submerid,
                'terminalid' => $payment_setting->dbbl_terminalid,
                'dbbl_demo' => $payment_setting->dbbl_demo,
                'amount' => $pay_amount,
                'url' => base_url('accounting/payment/dbbl_success/' . $data['invoice_id']),
                'card_type' => $data['card_type'],
                'invoice_id' => $data['invoice_id'],			
        );
       
	 $this->load->view('payment/dbbl', $data);	
    }
	    
	
    /*****************Function dbbl_failed**********************************
    * @type            : Function
    * @function name   : dbbl_failed
    * @description     : dbbl peyment processing failed url                
                         load user interface with some failed message 
     *                   while user failed dbbl paymnet.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function dbbl_failed(){    
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }
    
    /*****************Function dbbl_success**********************************
    * @type            : Function
    * @function name   : dbbl_success
    * @description     : dbbl peyment processing success url                
                         load user interface with success message 
    *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function dbbl_success(){ 
        $invoice_id = $this->uri->segment(4);
        success($this->lang->line('payment_success'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }
	
     /* DBBL Payment Start */  
    
    
    
    /* PayUMoney Payment Start */    
    
    /*****************Function pay_u_money**********************************
    * @type            : Function
    * @function name   : pay_u_money
    * @description     : Payment processing using "Payumoney" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_u_money($data) {
        
        //https://developer.payumoney.com/general/
       
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
               
        
        if ($payment_setting->payumoney_demo == TRUE) {
            $api_link = "https://test.payu.in/_payment";
        } else {
            $api_link = "https://secure.payu.in/_payment";
        }
        

        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
        
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->payu_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->payu_extra_charge/100*$data['amount']);
        }
        
        $array['key'] = $payment_setting->payumoney_key; //'gtKFFx'; 
        $array['salt'] = $payment_setting->payumoney_salt; //'eCwWELxi'; 
        $array['payu_base_url'] = $api_link; // For Test
        $array['surl'] = base_url('accounting/payment/payumoney_success/' . $data['invoice_id']);
        $array['furl'] = base_url('accounting/payment/payumoney_failed/' . $data['invoice_id']);
        $array['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $array['action'] = $api_link;
        $array['amount'] = $pay_amount;
        $array['firstname'] = $data['name'];
        $array['email'] = $data['email'];
        $array['phone'] = $data['phone'];
        $array['productinfo'] = 'Invoice' . ': ' .$data['note'];
        $array['hash'] = $this->_generate_hash($array);

        $this->load->view('payment/pay_u_money', $array);
    }

    
    /*****************Function _generate_hash**********************************
    * @type            : Function
    * @function name   : _generate_hash
    * @description     : generate hash id for payumoney peyment processing                  
    *                       
    * @param           : $array array() value
    * @return          : $hash string value
    * ********************************************************** */
    private function _generate_hash($array) {
        
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($array['key']) || empty($array['txnid']) || empty($array['amount']) || empty($array['firstname']) || empty($array['email']) || empty($array['phone']) || empty($array['productinfo']) || empty($array['surl']) || empty($array['furl'])) {
            return false;
        } else {
            
            /*
            $hash = '';
            $salt = $array['salt'];
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';
            foreach ($hashVarsSeq as $hash_var) {
                $hash_string .= isset($array[$hash_var]) ? $array[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $salt;
            */
            
            $retHashSeq = $array['key']."|".$array['txnid']."|".$array['amount']."|".$array['productinfo']."|".$array['firstname']."|".$array['email']."|||||||||||".$array['salt'];
            $hash = strtolower(hash('sha512', $retHashSeq));
            return $hash;
        }
    }

    
    /*****************Function payumoney_failed**********************************
    * @type            : Function
    * @function name   : payumoney_failed
    * @description     : payumoney peyment processing failed url                 
    *                    load user interface with payment failed message   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function payumoney_failed() {
        
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/index/' . $invoice_id);
        
    }

    
    /*****************Function payumoney_success**********************************
    * @type            : Function
    * @function name   : payumoney_success
    * @description     : payumoney peyment processing success url                 
    *                    load user interface with payment success message   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function payumoney_success() {
        
        // print_r($_POST); die();        
        //mail('info@aegistechnologies.net', 'PayUMoney', json_encode($_POST));
        
        $invoice_id = $this->uri->segment(4);
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
        
        $status         = $_POST["status"];
        $firstname      = $_POST["firstname"];
        $amount         = $_POST["amount"];
        $txnid          = $_POST["txnid"];
        $posted_hash    = $_POST["hash"];
        $key            = $_POST["key"];
        $productinfo    = $_POST["productinfo"];
        $email          = $_POST["email"];
        $phone          = $_POST["phone"];
        $salt           = $payment_setting->payumoney_salt;
        
        /*
        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }*/
       
        $retHashSeq = $key."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|||||||||||".$salt;
        $hash = strtolower(hash("sha512", $retHashSeq));
                     
        if ($status === "success") {                
               
            $payment = $this->payment->get_invoice_amount($invoice_id);  

            $school = $this->payment->get_school_by_id($invoice->school_id);

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'PayUMoney';
            $data['transaction_id'] = $txnid;
            $data['name'] = $firstname;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['note'] = $productinfo;
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($amount) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }                    
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));

            success($this->lang->line('payment_success'));
            redirect('accounting/invoice/index/' . $invoice_id);

        } else {
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/index/' . $invoice_id);
        }
        
    }
    

    /* PayUmoney Payment End */
    
    
    /* Paypal payment start */
    
    
    /*****************Function paypal**********************************
    * @type            : Function
    * @function name   : paypal
    * @description     : Payment processing using "Paypal" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function paypal($data)
    {
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
        
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->paypal_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->paypal_extra_charge/100*$data['amount']);
        }
        
        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('no_note', 0);
        $this->paypal->add_field('item_name', 'Invoice');
        $this->paypal->add_field('amount', $pay_amount);
        $this->paypal->add_field('custom', $data['invoice_id']);
        $this->paypal->add_field('business', $payment_setting->paypal_email);
        $this->paypal->add_field('tax', 1);
        $this->paypal->add_field('quantity', 1);
        $this->paypal->add_field('currency_code', 'USD');

        $this->paypal->add_field('notify_url', base_url('accounting/gateway/paypal_notify'));
        $this->paypal->add_field('cancel_return', base_url('accounting/payment/paypal_cancel/' . $data['invoice_id']));
        $this->paypal->add_field('return', base_url('accounting/payment/paypal_success/' . $data['invoice_id']));
        
               
        
        if($payment_setting->paypal_demo){
            $this->paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $this->paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        }
        
        $this->paypal->submit_paypal_post();
    }

    /*****************Function paypal_cancel**********************************
    * @type            : Function
    * @function name   : paypal_cancel
    * @description     : paypal peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel paypal paymnet.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function paypal_cancel(){    
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }

    
    /*****************Function paypal_success**********************************
    * @type            : Function
    * @function name   : paypal_success
    * @description     : paypal peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function paypal_success(){ 
        $invoice_id = $this->uri->segment(4);
        success($this->lang->line('payment_success'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }
 
    /* Paypal payment end */
    
 
        
    /* PAY TM Payment Start */    
    
    /*****************Function pay_tm**********************************
    * @type            : Function
    * @function name   : pay_tm
    * @description     : Payment processing using "pay_tm" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_tm($data) {
  
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
       
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->paytm_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->paytm_extra_charge/100*$data['amount']);
        }
        
        
        if ($payment_setting->paytm_demo == TRUE) {

           // Key in your staging and production MID available in your dashboard
           define("merchantMid", "rxazcv89315285244163");
           // Key in your staging and production merchant key available in your dashboard
           define("merchantKey", "gKpu7IKaLSbkchFS");
           define("mobileNo", $this->session->userdata('phone') ? $this->session->userdata('phone') : '7777777777' );
           define("email", define("mobileNo", $this->session->userdata('email') ? $this->session->userdata('email') : 'username@emailprovider.com' )); 
           define("website", "WEBSTAGING");
           define("industryTypeId", "Retail");
           $transactionURL = "https://securegw-stage.paytm.in/theia/processTransaction";

        }else{

           // Key in your staging and production MID available in your dashboard
            define("merchantMid", $payment_setting->paytm_merchant_mid);
           // Key in your staging and production merchant key available in your dashboard
            define("merchantKey", $payment_setting->paytm_merchant_key);
            define("mobileNo", $this->session->userdata('phone') ? $this->session->userdata('phone') : '7777777777' );
            define("email", define("mobileNo", $this->session->userdata('email') ? $this->session->userdata('email') : 'username@emailprovider.com' ));
            define("website", $payment_setting->paytm_merchant_website);
            define("industryTypeId", $payment_setting->paytm_industry_type);
            $transactionURL = "https://securegw.paytm.in/theia/processTransaction"; //

        }
                
        define("orderId", "ORDS" . time().$data['invoice_id']);
        define("channelId", "WEB");
        define("custId", 'CUST'.$invoice->id);
        define("txnAmount", $pay_amount);
        define("callbackUrl", base_url('accounting/payment/pay_tm_success/' . $data['invoice_id']));
       
     
        $paytmParams = array();
        $paytmParams["MID"] = merchantMid;
        $paytmParams["ORDER_ID"] = orderId;
        $paytmParams["CUST_ID"] = custId;
        $paytmParams["MOBILE_NO"] = mobileNo;
        $paytmParams["EMAIL"] = email;
        $paytmParams["CHANNEL_ID"] = channelId;
        $paytmParams["TXN_AMOUNT"] = txnAmount;
        $paytmParams["WEBSITE"] = website;
        $paytmParams["INDUSTRY_TYPE_ID"] = industryTypeId;
        $paytmParams["CALLBACK_URL"] = callbackUrl;
        $paytmChecksum = getChecksumFromArray($paytmParams, merchantKey);
       
               
        $data['paytmParams'] = $paytmParams;
        $data['paytmChecksum'] = $paytmChecksum;
        $data['transactionURL'] = $transactionURL;
        
        $this->load->view('payment/pay_tm', $data);
    }
    
    
     /*****************Function pay_tm_success**********************************
    * @type            : Function
    * @function name   : pay_tm_success
    * @description     : pay_tm peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_tm_success(){
        
        //mail('info@aegistechnologies.net', 'PAY TM Return', json_encode($_POST));
        
        $invoice_id = $this->uri->segment(4);
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment = $this->payment->get_invoice_amount($invoice_id);   
        $school = $this->payment->get_school_by_id($invoice->school_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
        
       
        $paytmParams = array();
        $isValidChecksum = "FALSE";        
        if ($payment_setting->paytm_demo == TRUE) {
            
            $merchantKey = "gKpu7IKaLSbkchFS";
            
        }else{
             $merchantKey = $payment_setting->paytm_merchant_key; 
        }  
       
        $paytmParams = $_POST;        
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
	
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
         $isValidChecksum = verifychecksum_e($paytmParams, $merchantKey, $paytmChecksum);
        
        if($isValidChecksum == "TRUE") {
            
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                                
                $data['school_id'] = $invoice->school_id;
                $data['invoice_id'] = $invoice_id;
                $data['amount'] = $invoice->temp_amount;
                $data['payment_method'] = 'PayTM';
                $data['transaction_id'] = $_POST["TXNID"];            
                $data['note'] = $_POST["RESPMSG"]; 
                $data['status'] = 1;
                $data['academic_year_id'] = $school->academic_year_id;
                $data['payment_date'] = date('Y-m-d');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id(); 

                $this->payment->insert('transactions', $data);                
                $due_mount = $invoice->net_amount - $payment->paid_amount;

                if(floatval($data['amount']) < floatval($due_mount)){
                    $update = array('paid_status'=> 'partial');
                }else{
                    $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
                }                    
                $this->payment->update('invoices', $update, array('id'=>$invoice_id));

                success($this->lang->line('payment_success'));
                redirect('accounting/invoice/index/' . $invoice_id);
                
            }else{
                error($this->lang->line('payment_failed'));
                redirect('accounting/invoice/index/' . $invoice_id); 
            }
        }else{
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/index/' . $invoice_id); 
        }
     
    }
    
    
     /*****************Function pay_tm_cancel**********************************
    * @type            : Function
    * @function name   : pay_tm_cancel
    * @description     : pay_tm peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel pay_tm paymnet 
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_tm_cancel(){
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }

    /* PAY TM Payment END */  

    
    
    
    /* PAY STACK Payment START */  
    
        /*****************Function pay_stack**********************************
    * @type            : Function
    * @function name   : pay_stack
    * @description     : Payment processing using "Pay Stack" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_stack($data)
    {
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
                 
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $this->data['amount'] = $data['amount'];
        
        if($payment_setting->stack_extra_charge > 0){
            $this->data['amount'] = ($data['amount'] + ($payment_setting->stack_extra_charge/100*$data['amount']))*100;
        }
        
        $this->data['stack_secret_key'] = $payment_setting->stack_secret_key;
        $this->data['public_key'] = $payment_setting->stack_public_key;
        $this->data['email'] = $data['email']; // customer email
        $this->data['reference'] = uniqid().'-'.$data['invoice_id']; // unique reference 
        $this->data['invoice_id'] = $data['invoice_id'];
        $this->load->view('payment/pay_stack', $this->data);
        
    }
    

    /*****************Function stack_cancel**********************************
    * @type            : Function
    * @function name   : stack_cancel
    * @description     : stack peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel stack paymnet 
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_stack_cancel(){
        
        $invoice_id = '';
        $ref_id = $this->uri->segment(4);
        
        if($ref_id){
            $ref_ids = explode('-', $ref_id);
            $invoice_id = $ref_ids[1];
        }        
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/index/' . $invoice_id);
    }
    
    
    /*****************Function update_paystack_payment**********************************
    * @type            : Function
    * @function name   : update_paystack_payment
    * @description     : stack peyment processing success url                
                         load user interface with some success message                     
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_stack_success(){
        
        $invoice_id = '';
        $ref_id = $this->uri->segment(4);
        $txn_id = $this->uri->segment(5);
        
        if($ref_id){
            $ref_ids = explode('-', $ref_id);
            $invoice_id = $ref_ids[1];
        } 
        
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment = $this->payment->get_invoice_amount($invoice_id);   
        $school = $this->payment->get_school_by_id($invoice->school_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
     
     
        if (!empty($invoice)) {

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'PayStack';
            $data['transaction_id'] = $txn_id;            
            $data['reference'] = $ref_id;            
            $data['note'] = 'Pay Stack Payment'; 
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($data['amount']) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }
            
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));

           success($this->lang->line('payment_success'));
           redirect('accounting/invoice/index/' . $invoice_id);         
           
        }else{
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/index/' . $invoice_id);
        }       
       
    }
    /* PAY STACK Payment END */  
    
    
}
