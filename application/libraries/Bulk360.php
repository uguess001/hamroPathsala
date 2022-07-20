<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bulk360 {

    public $username = "";
    public $password = "";
    public $from_no = "AEONSales";
    public $url = "https://sms.360.my/gw/bulk360/v1.4";

    function __construct() {

        $ci = & get_instance();
        $school_id = '';
        if ($ci->session->userdata('school_id')) {
            $school_id = $ci->session->userdata('school_id');
        } else {
            $school_id = $ci->input->post('school_id');
        }

        $ci->db->select('S.*');
        $ci->db->from('sms_settings AS S');
        $ci->db->where('S.school_id', $school_id);
        $setting = $ci->db->get()->row();

        $this->username = $setting->bulk360_username;
        $this->password = $setting->bulk360_password;
        $this->from_no = $setting->bulk360_from_no;
    }

    function sendSMS($mobile, $message) {

        $opts = array(
            "ssl"   => array(
                "verify_peer"       =>  false,
                "verify_peer_name"  =>  false,
            ),
            'http'  => array(
                'method'            =>  "GET",
                'header'            =>  "Accept-language: en\r\n" .
                                        "Cookie: foo=bar\r\n"
            )
        );

        $this->username = urlencode($this->username);
        $this->password = urlencode($this->password);
        
        $this->url = $this->url . "?user=$this->username&pass=$this->password&type=0&from=$this->from_no&to=".$mobile."&text=".rawurlencode($message);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        if ($response == FALSE) {
            echo 'Curl failed for sending sms. '.curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }
}