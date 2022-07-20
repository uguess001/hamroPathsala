<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/stripe/vendor/autoload.php';

class Stripepay {

    public $stripe_secret;
    public $stripe_demo;

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

        $this->stripe_secret = $setting->stripe_secret;
        $this->stripe_demo = $setting->stripe_demo;

        \Stripe\Stripe::setApiKey($this->stripe_secret);
    }

    public function payment($data) {

        $checkout_session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                    'price_data' => [
                        'currency' => 'USD',
                        'unit_amount' => number_format(($data['amount'] * 100), 0, '.', ''),
                        'product_data' => [
                            'name' => $data['description'],
                            'images' => [$data['image_url']],
                        ],
                    ],
                    'quantity' => 1,
                        ]],
                    'mode' => 'payment',
                    'success_url' => $data['success_url'],
                    'cancel_url' => $data['cancel_url'],
        ]);
        return $checkout_session;
    }

    public function verify($session_id) {
        $session_data = \Stripe\Checkout\Session::retrieve($session_id);
        return $session_data;
    }
}