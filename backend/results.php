<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../css/style.css">
    <style>
    body {background:none transparent;}
    </style>

<title>Risk Game Results</title>

<script src="../js/riskGame.js"></script>
<script>

const initGame = (data) => {
    initData(data);
    play();
}

function receive(event) {
    let data = JSON.parse(event.data);
    console.log("Received Message : ", data);
    document.getElementById("rawdata_amount").innerHTML = data.amount;
    document.getElementById("rawdata_currency").innerHTML = data.currency;
    document.getElementById("rawdata_shopperCountry").innerHTML = data.shopperCountry;
    document.getElementById("rawdata_deliveryCountry").innerHTML = data.deliveryCountry;
    document.getElementById("rawdata_accountAge").innerHTML = data.accountAge;
    initGame(data);
}

window.addEventListener('message', receive);
</script>

</head>

<body>

<div class="resultsParent">

    <div></div>

    <div class="upperResult"><div class="approved" id="approvedDeclined">-</div><div class="finalrisk" id="finalrisk"></div></div>
    <div class="midResult"></div>
    <div class="lowerResult">
        
    <div class="oneResult"><div>Amount</div><img src="img/amount.png" width="40"></div>
        <div class="rawdata" id="rawdata_amount"></div>
        <div class="textResult norisk" id="CustomFieldCheck-AmountCheck">-</div>
    
        <div class="oneResult"><div>Currency</div><img src="img/ccy_jpy.png" class="categoryIcon"></div>
        <div class="rawdata" id="rawdata_currency"></div>
        <div class="textResult norisk" id="CustomFieldCheck-CurrencyCheck">-</div>
    
        
        <div class="oneResult"><div>Shopper Country</div><img src="img/shooperCountry.png" class="categoryIcon"></div>
    <div class="rawdata" id="rawdata_shopperCountry"></div>
    <div class="textResult norisk" id="CustomFieldCheck-ShopperCountryCodeCheck">-</div>

    <div class="oneResult"><div>Delivery Country</div><img src="img/playAgain.png" class="categoryIcon"></div>
    <div class="rawdata" id="rawdata_deliveryCountry"></div>
    <div class="textResult norisk" id="CustomFieldCheck-DeliveryCountryCheck">-</div>

    <div class="oneResult"><div>Account Age</div><img src="img/account.png" class="categoryIcon"></div>
    <div class="rawdata" id="rawdata_accountAge"></div>
    <div class="textResult norisk" id="CustomFieldCheck-AccountAgeLessThanAWeek">-</div>
    
    
    </div>
</div>

<!--
<div class="result" id='resultDiv'>
    <div class="colspan resultTitle">Risk Game Results</div>
    
    <div class="oneResult"><img src="img/amount.png" width="40"><div>Amount</div></div>
    <div class="rawdata" id="rawdata_amount"></div>
    <div class="textResult norisk" id="CustomFieldCheck-AmountCheck">-</div>
    <div class="resultscore">
        Risk score
    </div>

    <div class="oneResult"><img src="img/ccy_jpy.png" class="categoryIcon"><div>Currency</div></div>
    <div class="rawdata" id="rawdata_currency"></div>
    <div class="textResult norisk" id="CustomFieldCheck-CurrencyCheck">-</div>
    <div class="resultscore2">
        <div><img src="img/risk.png" width="80"><div></div></div>
        <div class="finalrisk" id="finalrisk"></div>
    </div>

    <div class="oneResult"><img src="img/shooperCountry.png" class="categoryIcon"><div>Shopper Country</div></div>
    <div class="rawdata" id="rawdata_shopperCountry"></div>
    <div class="textResult norisk" id="CustomFieldCheck-ShopperCountryCodeCheck">-</div>

    <div class="oneResult"><img src="img/playAgain.png" class="categoryIcon"><div>Delivery Country</div></div>
    <div class="rawdata" id="rawdata_deliveryCountry"></div>
    <div class="textResult norisk" id="CustomFieldCheck-DeliveryCountryCheck">-</div>

    <div class="oneResult"><img src="img/account.png" class="categoryIcon"><div>Account Age</div></div>
    <div class="rawdata" id="rawdata_accountAge"></div>
    <div class="textResult norisk" id="CustomFieldCheck-AccountAgeLessThanAWeek">-</div>

    <div class="approved" id="approvedDeclined">-</div>

</div>
-->

</html>