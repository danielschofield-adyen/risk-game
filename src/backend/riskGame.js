let transaction = {}

const amountList = [500, 1000, 5000, 8000, 10000, 15000, 50000, 150000];
const currencyList = ["JPY", "SGD", "IDR", "MYR", "CNY", "TWD", "KRW", "PHP", "SEK"];
const shopperCountryList = ["JP", "SG", "HK", "ID", "MY", "CN", "TW", "YE", "SD"];
const deliveryCountryList = ["JP", "SG", "HK", "ID", "MY", "CN", "TW", "KR", "CM", "CU"];
const accountAgeList = [10, 100, 240, 8760, 43800];

const resultRulesList = ["CustomFieldCheck-AmountCheck","CustomFieldCheck-CurrencyCheck","CustomFieldCheck-ShopperCountryCodeCheck","CustomFieldCheck-DeliveryCountryCheck","CustomFieldCheck-AccountAgeLessThanAWeek"]

const initData = (data) => {
    transaction = data;
}

async function play() {

    cleanUp();
    const url = "getAuthorization.php";
    const data = {
      "amount":transaction.amount,
      "currency":transaction.currency,
      "shopperCountry":transaction.shopperCountry, 
      "deliveryCountry":transaction.deliveryCountry, 
      "accountAge":transaction.accountAge,
    };
    
    console.log("Call the /Payments API with following data => " , data);
    let res = await callServer(url, data);
  
    console.log("Result is > ", res);
    displayResult(res);
};
  
async function callServer(url, data) {
  
    const res = await fetch(url, {
        method: "POST",
      body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        }
    })
  
    data = await res.json();
    return data;
}

const cleanUp = () => {

    // Remove risk score
    document.getElementById("finalrisk").innerHTML = "";
    
    // Remove all risk rules
    for (let item of resultRulesList) {
        document.getElementById(item).innerHTML = "-";
        document.getElementById(item).style.color = "black";
    }

    // Remove status color
    document.getElementById("approvedDeclined").innerHTML = "-";
    document.getElementById("approvedDeclined").style.backgroundColor = "black";
}

const displayResult = (data) => {

    // Handle API returns error
    if (data.status === 500) {
        alert("Transaction cannot be processed");
        return
    }

    // Display risk score
    const resultscore =  parseInt(data.fraudResult.accountScore);
    document.getElementById("finalrisk").innerHTML = resultscore;

    // Display transaction status
    if (resultscore >= 100) {
        document.getElementById("approvedDeclined").innerHTML = "Transaction declined";
        document.getElementById("approvedDeclined").style.backgroundColor = "red";
    }
    else {
        document.getElementById("approvedDeclined").innerHTML = "Transaction approved";
        document.getElementById("approvedDeclined").style.backgroundColor = "#0ABF53";
    }
    
    // Display result for each risk rule
    const customRulesCheckList = data.fraudResult.results

    for (let item of resultRulesList) {
        document.getElementById(item).innerHTML = "no risk triggered";
    }

    for (let item of customRulesCheckList) {
        document.getElementById(item.name).innerHTML = "Rule triggered with score = " + item.accountScore;
        document.getElementById(item.name).style.color = "red";
    }
}