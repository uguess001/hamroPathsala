<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Billplz {

    public $bill_api_key;
    public $bill_demo;

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

        $this->bill_api_key = $setting->bill_api_key;
        $this->bill_demo = $setting->bill_demo;
                
    }

    public function payment($data) {

        $ch = curl_init();
        
        if($this->bill_demo){
            $api_url = 'https://www.billplz.com/api/v3/bills/';
        }else{
            $api_url = 'https://www.billplz.com/api/v3/bills/';            
        }
        
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $payload = Array(
            'collection_id' => 'inbmmepb',
            'description' => 'Maecenas',
            'email' => $data['email'],
            'name' => $data['name'],
            'amount' => $data['amount'],
            'reference_1_label' => 'Bank Code',
            'reference_1' => 'BP-FKR01',
            'callback_url' => $data['callback_url'],
            'redirect_url' => $data['redirect_url']           
        );  
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_USERPWD, $this->bill_api_key . ':' . '');

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        
        curl_close($ch);  
        return $response;
        
          
        //curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        
    }
}