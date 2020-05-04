<?php session_start();
require_once('functions/redirect.php');

if (isset($_GET['txref'])) {
    $ref = $_GET['txref'];
    $amount = "1000"; //Correct Amount from Server
    $currency = "NGN"; //Correct Currency from Server

    $query = array(
        "SECKEY" => "FLWSECK_TEST-d0baa5a554e7bc5820450516dfbb2e24-X",
        "txref" => $ref
    );

    $data_string = json_encode($query);

    $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify ');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $resp = json_decode($response, true);
    // print_r($resp);
    // die();

    $paymentStatus = $resp['data']['status'];
    $chargeResponsecode = $resp['data']['chargecode'];
    $chargeAmount = $resp['data']['amount'];
    $chargeCurrency = $resp['data']['currency'];
    $name =    $resp['data']['custname'];
    $email = $resp['data']['custemail'];
    $txid = $resp['data']['txid'];


    $paymentObject = [
        'transactionid' => $txid,
        'status' => $paymentStatus,
        "email" => $email,
        'patientname' => $name,
        "amount" => $chargeAmount,
        "currency" => $chargeCurrency,
    ];

    // file_put_contents("db/payments/" . $email . ".json", json_encode($paymentObject));

    if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
        //Give Value and return to Success page
        // print_r($chargeResponsecode);
        // print_r($paymentObject);
        // die();
        file_put_contents("db/payments/" . $email . $txid . ".json", json_encode($paymentObject));
        redirect_to("billpaymentsuccessful.php");
    } else {
        //Dont Give Value and return to Failure page
        file_put_contents("db/payments/" . $email . $txid . ".json", json_encode($paymentObject));
        redirect_to("billpaymentfailed.php");
    }
}
