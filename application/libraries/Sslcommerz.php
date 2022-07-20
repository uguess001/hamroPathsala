<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sslcommerz {

    protected $ssl_submit_url;
    protected $ssl_validation_url;
    protected $ssl_data;
    protected $ssl_store_id;
    protected $ssl_password;
    protected $ssl_demo;
    public $error = '';

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

        $this->ssl_store_id = $setting->ssl_store_id;
        $this->ssl_password = $setting->ssl_password;
        $this->ssl_demo = $setting->ssl_demo;

        if ($this->ssl_demo == 1) {

            $this->ssl_submit_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
            $this->ssl_validation_url = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php";
        } else {

            $this->ssl_submit_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
            $this->ssl_validation_url = "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php";
        }
    }

    public function sendRequest($post_data) {

        $post_data['store_id'] = $this->ssl_store_id;
        $post_data['store_passwd'] = $this->ssl_password;

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->ssl_submit_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !( curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            echo "<script>window.location.href = '" . base_url('accounting/invoice/index') . "';</script>";
            exit;
        }

        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            echo "<div style='text-align:center;margin:20% 20% 20%;border:1px solid gray;'><h2>Please wait, payment page will be loaded shortly ... ...</h2></div>";
            echo "<script>window.location.href = '" . $sslcz['GatewayPageURL'] . "';</script>";
            //echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing error!";
            echo "<script>window.location.href = '" . base_url('accounting/invoice/index') . "';</script>";
        }
    }

    protected function validateTxn($amount, $currency, $post_data) {

        if ($amount > 0) {

            $post_data['store_id'] = $this->store_id;
            $post_data['store_pass'] = $this->store_pass;

            $val_id = urlencode($post_data['val_id']);
            $store_id = urlencode($this->store_id);
            $store_passwd = urlencode($this->store_pass);

            $requested_url = ($this->ssl_validation_url . "?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $requested_url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

            $result = curl_exec($handle);

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if ($code == 200 && !( curl_errno($handle))) {

                # TO CONVERT AS ARRAY
                # $result = json_decode($result, true);
                # $status = $result['status'];
                # TO CONVERT AS OBJECT
                $result = json_decode($result);
                $this->ssl_data = $result;

                # TRANSACTION INFO
                $status = $result->status;
                $tran_date = $result->tran_date;
                $tran_id = $result->tran_id;
                $val_id = $result->val_id;
                $amount = $result->amount;
                $store_amount = $result->store_amount;
                $bank_tran_id = $result->bank_tran_id;
                $card_type = $result->card_type;
                $currency_type = $result->currency_type;
                $currency_amount = $result->currency_amount;

                # ISSUER INFO
                $card_no = $result->card_no;
                $card_issuer = $result->card_issuer;
                $card_brand = $result->card_brand;
                $card_issuer_country = $result->card_issuer_country;
                $card_issuer_country_code = $result->card_issuer_country_code;

                # API AUTHENTICATION
                $APIConnect = $result->APIConnect;
                $validated_on = $result->validated_on;
                $gw_version = $result->gw_version;

                if ($status == "VALID" || $status == "VALIDATED") {

                    return true;
                } else {
                    echo "Invalid validation of id :" . $val_id;
                    return false;
                }
            } else {

                echo "Failed to connect with SSLCOMMERZ";
                return false;
            }
        } else {
            echo 'Invalid Data';
            return false;
        }
    }

}

?>
