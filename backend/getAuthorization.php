<?php

$rawData = json_decode(file_get_contents('php://input'), true);

$url = "https://checkout-test.adyen.com/v69/payments";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "content-type: application/json",
   "x-API-key: ".$_ENV["APIKey_AdyenAPACEvent_SG_RiskGame"],
);

switch($rawData['shopperCountry']) {
   case "YE":
      $shopperIP = "109.200.160.0";
      break;
   case "SD":
      $shopperIP = "102.120.0.0";
      break;
   default:
      $shopperIP = "1.179.112.0";
}

switch($rawData['threeeds']) {
   case "3ds1":
      $paymentMethod = array("type"=>"scheme","number"=>"4212345678901237", "expiryMonth"=>"03", "expiryYear"=>"2030", "cvc"=>"737");
      break;
   case "3ds2":
      $paymentMethod = array("type"=>"scheme","number"=>"5201281505129736", "expiryMonth"=>"03", "expiryYear"=>"2030", "cvc"=>"737");
      break;
   default:
      $paymentMethod = array("type"=>"scheme","number"=>"4111111111111111", "expiryMonth"=>"03", "expiryYear"=>"2030", "cvc"=>"737");
}

$accountAgeInDays = $rawData['accountAge'];
$accountAgeInHours = intval($accountAgeInDays) * 24;
$accountCreationDate = date("Y-m-d\TH:i:s+09:00", strtotime("-".$accountAgeInHours." hours"));

$data = array(
   "reference"=>"RiskGameTest",
   "merchantAccount"=>"AdyenAPACEvent_SG_RiskGame_TEST", 
   "shopperReference"=> $rawData['shopperReference'],
   "amount"=>array("value"=>$rawData['amount'],"currency"=>$rawData['currency']),
   "paymentMethod"=>$paymentMethod,
   "deliveryAddress"=>array("city"=>"xxx","country"=>$rawData['deliveryCountry'], "houseNumberOrName"=>"xxx","postalCode"=>"xxx","street"=>"xxx","stateOrProvince"=>"xxx"),
   "shopperIP"=>$shopperIP,
   "accountInfo"=>array("accountCreationDate"=>$accountCreationDate),
   "returnUrl"=>"http://localhost:8000/",
   "additionalData"=>array("allow3DS2"=>true),
   "channel"=>"web"
);
$postdata = json_encode($data);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

$resp = curl_exec($curl);
curl_close($curl);

header("Content-Type: application/json");

print($resp);

?>
