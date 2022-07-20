<?php

error_reporting(1);
ini_set('display_errors', 1);
ini_set("soap.wsdl_cache_enabled", "0");
libxml_disable_entity_loader(false);

$url = "https://ecom1.dutchbanglabank.com/ecomws/dbblecomtxn?wsdl";
$url2 = "https://demo.l1nda.nl/api/webservice/?wsdl";


$_SESSION['invoice_id'] = $invoice_id;

$params = array(
    "userid" => $userid,
    "pwd" => $password,
    "submername" => $submername,
    "submerid" => $submerid,
    "terminalid" => $terminalid,
    "amount" => ($amount * 100),
    "cardtype" => $card_type,
    "txnrefnum" => ($invoice_id . time()),
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


    $result = $client->__soapCall("getsubmertransid", array($params));

    //print_r($result);
    //die();

    $return = $result->return;
    $trx = explode(":", $return);
    if ($trx[0] == 'TRANSACTION_ID') {

        $dbbl_txn_id = ($trx[1]);

        $_SESSION['dbbl_txn_id'] = $dbbl_txn_id;
        setcookie('dbbl_txn_id', $dbbl_txn_id, time() + 300, "/");
        setcookie('invoice_id', $invoice_id, time() + 300, "/");

        $redirectURL2 = "https://ecom1.dutchbanglabank.com/ecomm2/ClientHandler?card_type=" . $card_type . "&trans_id=" . urlencode($dbbl_txn_id);
        $redirectURL = "https://ecom.dutchbanglabank.com/ecomm2/ClientHandler?card_type=" . $card_type . "&trans_id=" . $dbbl_txn_id;
        header("Location: $redirectURL2");
    } else {

        echo $trx[1];
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
