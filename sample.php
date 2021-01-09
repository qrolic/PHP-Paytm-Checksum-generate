<?php
/**
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
//require_once("generateChecksum.php");
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
/* initialize an array */
$paytmParams = array();

/* body parameters */
$paytmParams["body"] = array(

    /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
    "mid" => "dQmxtK71104614901796",

    /* Enter your order id which needs to be check status for */
    "orderId" => "success_195_329786183",
);

/**
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = getChecksumFromArray($paytmParams["body"], "dQmxtK71104614901796");

/* head parameters */
$paytmParams["head"] = array(

    /* put generated checksum value here */
    "signature"	=> $checksum
);

/* prepare JSON string for request */
$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
$url = "https://securegw-stage.paytm.in/v3/order/status";

/* for Production */
// $url = "https://securegw.paytm.in/v3/order/status";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
$response = curl_exec($ch);
echo $response;