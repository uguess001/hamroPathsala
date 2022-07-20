<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smsto {

    public $api_key = "";
    public $sender_id = "SMS.to";
    public $url = "https://api.sms.to/sms/send";

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

        $this->api_key = $setting->smsto_api_key;
        $this->sender_id = $setting->smsto_sender_id;
    }

    function sendSMS($mobile, $message) {

        $post = array('message' => $message, 'to' => $mobile, 'sender_id' => $this->sender_id);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($post),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Bearer $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}