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
      "shopperReference":transaction.shopperReference
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
  
    try {
        data = await res.json();
        return data;
    }
    catch(err) {
        return null;
    }
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
    if (data.status === 401) {
        alert("Not authorized");
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
        document.getElementById(item.name).innerHTML = "Rule triggered [ +" + item.accountScore + " ]";
        document.getElementById(item.name).style.color = "red";
    }
}

async function cardAcquisiton(terminalID) {

    let url = "../backend/cardAcquisition.php";
    let data = {
      "terminalID":terminalID
    };
    
    console.log("Call the TAPI for CardAcqusition with following data => " , data);
    let res = await callServer(url, data);
  
    if (!res) {
        return "Guest";
    }

    console.log("Result is > ", res);
    console.log("Result is > ", res.SaleToPOIResponse.CardAcquisitionResponse.Response.AdditionalResponse);
    let valuesList = res.SaleToPOIResponse.CardAcquisitionResponse.Response.AdditionalResponse.split("&");
    let propertiesObj = {}
    for (let itm of valuesList) {
        let values = itm.split("="); 
        let prop = values[0]; 
        let val = values[1]; 
        propertiesObj[prop] = val;
    }
    let shopperReference = propertiesObj.shopperReference;
    console.log("shopperReference is > ", shopperReference);
    
    if (!shopperReference) {
        shopperReference = "Guest";
    }

    url = "../backend/cardAcquisitionRelease.php";
    data = {
      "shopperReference":shopperReference,
      "terminalID":terminalID
    };
    
    console.log("Call the TAPI for CardAcqusitionRelease with following data => " , data);
    res = await callServer(url, data);

    console.log("Result of release > ", res)

    return shopperReference;
}
