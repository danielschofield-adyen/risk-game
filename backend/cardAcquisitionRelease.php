<?php

$rawData = json_decode(file_get_contents('php://input'), true);

$url = "https://terminal-api-test.adyen.com/sync";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "content-type: application/json",
   "x-API-key: ".$_ENV["APIKey_RiskGame_Terminals"],
);

$seq = strval(rand(1, 999999999));

$data = array(
        "SaleToPOIRequest"=>array(
           "MessageHeader"=>array(
              "ProtocolVersion"=>"3.0",
              "MessageClass"=>"Service",
              "MessageCategory"=>"EnableService",
              "MessageType"=>"Request",
              "ServiceID"=>$seq,
              "SaleID"=>"POSSystemID12354",
              "POIID"=>$rawData['terminalID']
           ),
           "EnableServiceRequest"=>array(
              "TransactionAction"=>"AbortTransaction",
              "DisplayOutput"=>array(
                 "Device"=>"CustomerDisplay",
                 "InfoQualify"=>"Display",
                 "OutputContent"=>array(
                    "PredefinedContent"=>array(
                       "ReferenceID"=>"AcceptedAnimated"
                    ),
                    "OutputFormat"=>"Text",
                    "OutputText"=>array(
                        array(
                          "Text"=> "Hello"
                        ),
                        array(
                          "Text"=>"Welcome to the risk game"
                        )
                    )
                 )
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
