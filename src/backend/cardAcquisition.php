<?php
include_once("config.php");

$rawData = json_decode(file_get_contents('php://input'), true);

$url = "https://terminal-api-test.adyen.com/sync";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "content-type: application/json",
   "x-API-key: ".$config["APIKey_RiskGame_Terminals"],
);

$timestamp = date("Y-m-d\TH:i:s+09:00");
$seq = strval(rand(1, 999999999));

$data = array(
        "SaleToPOIRequest"=> array(
            "MessageHeader" => array(
                "ProtocolVersion"=>"3.0",
                "MessageClass"=>"Service",
                "MessageCategory"=>"CardAcquisition",
                "MessageType"=>"Request",
                "SaleID"=>"Joffrey_POSTEST_0001",
                "ServiceID"=>$seq,
                "POIID"=>"V400m-347148879"
            ),
            "CardAcquisitionRequest"=> array(
                "SaleData"=> array(
                    "SaleTransactionID"=>array(
                        "TransactionID"=>"001",
                        "TimeStamp"=>$timestamp
                    ),
                    "TokenRequestedType"=>"Customer"
                ),
                "CardAcquisitionTransaction"=>array(
                    "TotalAmount"=> 0
                )
            )
        )
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
