<!DOCTYPE html>
<html lang="en">

<head>

<style>
* {
    font-family: arial;
    margin: 0px;
    box-sizing: border-box;
}

.result {
  display:grid;
  grid-template-columns: 300px auto 300px;
  background-color: #F3F6F9;
  border-radius: 10px;
  font-size: 20px;
  width: 100vw;
  height: 100vh;
}

.resultscore {
  grid-row-start: 2;
  grid-row-end: 3;
  grid-column-start:3;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
}

.resultscore2 {
  grid-row-start: 3;
  grid-row-end: 7;
  grid-column-start:3;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
}

.icon {
  padding-left: 100px;
  align-self: center;
  justify-self: center;
}

.textResult {
  padding-left: 50px;
}

.norisk {
  align-self: center;
  color: #0ABF53;
  font-size: 30px;
}

.finalrisk {
  align-self: center;
  color: #000000;
  font-size: 80px;
}

.oneResult {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-left: 50px;
  font-size: 18px;
}

.approved {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  background-color: #000000;
  color: white;
  grid-column-start: 1;
  grid-column-end: 4;
  justify-self: center;
  font-size: 50px;
}
   
.colspan {
  grid-column-start: 1;
  grid-column-end: 4;
  justify-self: center;
  width: 100%;
}
   
.submitButton {
  background-color: #0ABF53;
  font-size: 18px;
  border: 0px;
  border-radius: 8px;
  padding: 10px 15px 10px 15px;
  margin-top: 10px;
  cursor: pointer;
  box-shadow: 1px 1px 2px black;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 160px;
}

.categoryIcon {
  padding-bottom: 5px;
  width: 40px;
}

.resultTitle {
    background-color: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 20px;
    padding-bottom: 20px;   
    margin-bottom: 10px;
    font-size: 50px;
}

</style>

<title>Risk Game Results</title>

<script src="riskGame.js"></script>
<script>

const initGame = (data) => {
    initData(data);
    play();
}

function receive(event) {
    let data = JSON.parse(event.data);
    console.log("Received Message : ", data);
    initGame(data);
}

window.addEventListener('message', receive);
</script>

</head>

<body>

<div class="result" id='resultDiv'>
    <div class="colspan resultTitle">Risk Game Results</div>
    
    <div class="oneResult"><img src="img/amount.png" width="40"><div>Amount</div></div>
    <div class="textResult norisk" id="CustomFieldCheck-AmountCheck">-</div>
    <div class="resultscore">
        Risk score
    </div>

    <div class="oneResult"><img src="img/ccy_jpy.png" class="categoryIcon"><div>Currency</div></div>
    <div class="textResult norisk" id="CustomFieldCheck-CurrencyCheck">-</div>
    <div class="resultscore2">
        <div><img src="img/risk.png" width="80"><div></div></div>
        <div class="finalrisk" id="finalrisk"></div>
    </div>

    <div class="oneResult"><img src="img/shooperCountry.png" class="categoryIcon"><div>Shopper Country</div></div>
    <div class="textResult norisk" id="CustomFieldCheck-ShopperCountryCodeCheck">-</div>

    <div class="oneResult"><img src="img/playAgain.png" class="categoryIcon"><div>Delivery Country</div></div>
    <div class="textResult norisk" id="CustomFieldCheck-DeliveryCountryCheck">-</div>

    <div class="oneResult"><img src="img/account.png" class="categoryIcon"><div>Account Age</div></div>
    <div class="textResult norisk" id="CustomFieldCheck-AccountAgeLessThanAWeek">-</div>

    <div class="approved" id="approvedDeclined">-</div>

</div>

</html>
