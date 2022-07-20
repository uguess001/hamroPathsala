<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Instamojo {

    public $mojo_api_key;
    public $mojo_auth_token;
    public $mojo_key_salt;
    public $mojo_demo;

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

        $this->mojo_api_key = $setting->mojo_api_key;
        $this->mojo_auth_token = $setting->mojo_auth_token;
        $this->mojo_key_salt = $setting->mojo_key_salt;
        $this->mojo_demo = $setting->mojo_demo;
                
    }

    public function payment($data) {

        $ch = curl_init();
        
        if($this->mojo_demo){
            $api_url = 'https://test.instamojo.com/api/1.1/payment-requests/';
        }else{
            $api_url = 'https://instamojo.com/api/1.1/payment-requests/';            
        }
          
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-Key:$this->mojo_api_key",
            "X-Auth-Token:$this->mojo_auth_token"));
        $payload = Array(
            'purpose' => $data['purpose'],
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            'buyer_name' => $data['buyer_name'],
            'redirect_url' => $data['redirect_url'],
            'send_email' => false,
            'webhook' => $data['webhook'],
            'send_sms' => false,
            'email' => $data['email'],
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);      
       
        return $response;
    }
}