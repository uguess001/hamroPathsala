<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/midtrans/Midtrans.php';

class Midtranspay {

    public $mid_client_key;
    public $mid_server_key;
    public $mid_demo;

    public function __construct() {

        $ci = & get_instance();
        $school_id = '';
        if ($ci->session->userdata('school_id')) {
            $school_id = $ci->session->userdata('school_id');
        } else {
            $school_id = $ci->input->post('school_id');
        }

        $ci->db->select('PS.*');
        $ci->db->from('payment_settings AS PS');
        $ci->db->where('PS.school_id', $school_id);
        $ci->db->where('PS.status', 1);
        $setting = $ci->db->get()->row();

        $this->mid_client_key = $setting->mid_client_key;
        $this->mid_server_key = $setting->mid_server_key;
        $this->mid_demo = $setting->mid_demo;

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = $this->mid_server_key;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = $this->mid_demo == 0 ? TRUE : FALSE;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function getSnapToken($amount, $order_id) {
        $data = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $amount,
            )
        );

        // Get Snap Payment Page URL
        try{
            $snapToken = \Midtrans\Snap::getSnapToken($data);
        } catch (Exception $ex) {
           
           // $err =  $ex->getMessage();
           return FALSE;
        }
        return $snapToken;
    }

}
