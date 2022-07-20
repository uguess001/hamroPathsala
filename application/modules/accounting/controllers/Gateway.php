<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Gateway.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Gateway
 * @description     : Process payment gateway notiication.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Gateway extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Payment_Model', 'payment', true);
        $this->load->model('Invoice_Model', 'invoice', true);

        $this->config->load('custom');
        $this->load->library("paypal");
    }

    /*     * ***************Function paypal_notify**********************************
     * @type            : Function
     * @function name   : paypal_notify
     * @description     : paypal peyment processing notify url                 
     *                    internally paypal send some post data
      which are procesing here.
     * @param           : null
     * @return          : null
     * ********************************************************** */

    public function paypal_notify() {

        //mail('info@aegistechnologies.net', 'Paypal notify out', json_encode($_POST));

        if (isset($_POST['ipn_track_id']) && !empty($_POST['ipn_track_id'])) {


            // mail('info@aegistechnologies.net', 'Paypal notify in', json_encode($_POST));
            /* $ipn_response = '';
              foreach ($_POST as $key => $value) {
              $value = urlencode(stripslashes($value));
              $ipn_response .= "\n$key=$value";
              } */

            $invoice = $this->invoice->get_single_invoice($_POST['custom']);
            $payment = $this->payment->get_invoice_amount($_POST['custom']);

            $school = $this->invoice->get_school_by_id($invoice->school_id);

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $_POST['custom'];
            $data['amount'] = $invoice->temp_amount;
            ;
            $data['payment_method'] = 'Paypal';
            $data['transaction_id'] = $_POST['txn_id'];
            $data['note'] = $_POST['item_name'];
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();

            $this->payment->insert('transactions', $data);
            $due_amount = $invoice->net_amount - $payment->paid_amount;

            if (floatval($data['amount']) < floatval($due_amount)) {
                $update = array('paid_status' => 'partial');
            } else {
                $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
            }
            $this->payment->update('invoices', $update, array('id' => $data['invoice_id']));
        }
    }

    public function dbbl() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dbbl_txn_id = '';
            $invoice_id = '';

            if (isset($_POST['trans_id']) && !empty($_POST['trans_id'])) {

                $dbbl_txn_id = $_POST['dbbl_txn_id'];
                $invoice_id = $_POST['invoice_id'];
            } else if (isset($_SESSION['dbbl_txn_id']) && !empty($_SESSION['dbbl_txn_id'])) {

                $dbbl_txn_id = $_SESSION['dbbl_txn_id'];
                $invoice_id = $_SESSION['invoice_id'];
            } else if (isset($_COOKIE['dbbl_txn_id']) && !empty($_COOKIE['dbbl_txn_id'])) {

                $dbbl_txn_id = $_COOKIE['dbbl_txn_id'];
                $invoice_id = $_COOKIE['invoice_id'];
            }



            $response = $this->get_dbbl_transaction($dbbl_txn_id);
            // print_r($response);
            $status = $response['status'];
            $description = implode(",", $response);

            if ($status == 'OK') {

                // save to database
                // send sms to guardian
                // transaction sttaus update

                $note = "Online fees deposit through DBBL:- DBBL txn ID: " . $dbbl_txn_id . ", DBBL Detail Info: " . $description;

                $invoice = $this->invoice->get_single_invoice($invoice_id);
                $payment = $this->payment->get_invoice_amount($invoice_id);

                $school = $this->invoice->get_school_by_id($invoice->school_id);

                $data = array();

                $data['school_id'] = $invoice->school_id;
                $data['invoice_id'] = $invoice_id;
                $data['amount'] = $invoice->temp_amount;
                $data['payment_method'] = 'DBBL';
                $data['transaction_id'] = $dbbl_txn_id;
                $data['note'] = $note;
                $data['status'] = 1;
                $data['academic_year_id'] = $school->academic_year_id;
                $data['payment_date'] = date('Y-m-d');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();

                $this->payment->insert('transactions', $data);
                $due_amount = $invoice->net_amount - $payment->paid_amount;

                if (floatval($data['amount']) < floatval($due_amount)) {
                    $update = array('paid_status' => 'partial');
                } else {
                    $update = array('paid_status' => 'paid', 'modified_at' => date('Y-m-d H:i:s'));
                }

                $this->payment->update('invoices', $update, array('id' => $data['invoice_id']));

                redirect(base_url('accounting/payment/dbbl_success/' . $invoice_id));
            } else {

                redirect(base_url('accounting/payment/dbbl_failed/' . $invoice_id));
            }
        }
    }

    private function get_dbbl_transaction($dbbl_txn_id) {

        $url = "https://ecom1.dutchbanglabank.com/ecomws/dbblecomtxn?wsdl";
        $url2 = "https://demo.l1nda.nl/api/webservice/?wsdl";

        $testPass = "385c4415dfdcf3fad5d9b22dbd85093c0374a46a";
        $livePass = "a8510e24a22220dd3a652be7a9dc93429eb65864";

        $params = array(
            "userid" => "000599991840000",
            "pwd" => $livePass,
            "transid" => $dbbl_txn_id,
            "clientip" => $_SERVER['REMOTE_ADDR']
        );

        try {

            $opts = array(
                'http' => array(
                    'user_agent' => 'PHPSoapClient'
                )
            );
            $context = stream_context_create($opts);

            $wsdlUrl = $url;
            $soapClientOptions = [
                'cache_wsdl' => WSDL_CACHE_NONE,
                'trace' => 1,
                'stream_context' => stream_context_create(
                        [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            ]
                        ]
                )
            ];

            $client = new SoapClient($wsdlUrl, $soapClientOptions);

            $result = $client->__soapCall("getresult", array($params));
            $return = $result->return;
            $trx = explode("^", $return);
            $status = $trx[0];
            $rs = explode(">", $status);

            $codeA = $trx[1];
            $cd = explode(">", $codeA);
            $secureA = $trx[2];
            $sc = explode(">", $secureA);

            $rpnA = $trx[3];
            $rp = explode(">", $rpnA);

            $acodeA = $trx[4];
            $ac = explode(">", $acodeA);

            $cardA = $trx[5];
            $crd = explode(">", $cardA);

            $amountA = $trx[6];
            $amt = explode(">", $amountA);

            $cardNameA = $trx[7];
            $crdn = explode(">", $cardNameA);

            $descA = $trx[8];
            $ds = explode(">", $descA);

            $timeA = $trx[9];
            $tm = explode(">", $timeA);

            $status1 = $rs[1];
            $code = $cd[1];
            $secoreCode = $sc[1];
            $rpn = $rp[1];
            $approval_code = $ac[1];
            $cardNumber = $crd[1];
            $amount = $amt[1];
            $cardname = $crdn[1];
            $description = $ds[1];
            $time = $tm[1];

            $array = array(
                'status' => $status1,
                'code' => $code,
                'secure_code' => $secoreCode,
                'rpn' => $rpn,
                'approval_code' => $approval_code,
                'card_number' => $cardNumber,
                'amount' => $amount,
                'card_name' => $cardname,
                'description' => $description,
                'time' => $time,
            );

            return $array;
        } catch (Exception $e) {

            $array = array(
                'status' => "SystemError",
                'code' => 0,
                'description' => $e
            );
            return $array;
        }
    }

    public function sslcommerz() {

        // getting from custom data
        $invoice_id = $_POST['value_b'];

        if (($_POST['status'] == 'VALID') && ($_POST['value_b'] == $_POST['tran_id'])) {

            // if same transaction id is ewxist then update    
            $exist = $this->invoice->get_single('transactions', array('transaction_id' => $_POST['tran_id'], 'invoice_id' => $invoice_id));
            if (empty($exist)) {

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

                // if same transaction id is ewxist then update             
                $this->payment->update('invoices', $update, array('id' => $invoice_id));
            }
        }
    }

    public function webhook() {

        $invoice_id = $this->uri->segment(4); 
        
        $data = $_POST;
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
        $ver = explode('.', phpversion());
        $major = (int) $ver[0];
        $minor = (int) $ver[1];
        if ($major >= 5 and $minor >= 4) {
            ksort($data, SORT_STRING | SORT_FLAG_CASE);
        } else {
            uksort($data, 'strcasecmp');
        }
        // You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
        // Pass the 'salt' without <>
        $mac_calculated = hash_hmac("sha1", implode("|", $data), "<YOUR_SALT>");
        if ($mac_provided == $mac_calculated) {
            if ($data['status'] == "Credit") {
                // Payment was successful, mark it as successful in your database.
                // You can acess payment_request_id, purpose etc here. 
            } else {
                // Payment was unsuccessful, mark it as failed in your database.
                // You can acess payment_request_id, purpose etc here.
            }
        } else {
            echo "MAC mismatch";
        }
    }
}
