<!DOCTYPE html>
<html lang="en">
<head>
    <title>Risk Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<script src="js/riskGame.js"></script>
<script>
let shopperReference = "";

const closeGameResults = () => {
    document.getElementById("gameDiv").style.visibility = "hidden";
}

const playGameDeclined = () => {
    document.getElementById("gameDiv").style.visibility = "visible";
    let transaction = {};
    transaction.amount = 15000;
    transaction.currency = "SEK";
    transaction.shopperCountry = "SD";
    transaction.deliveryCountry = "CU";
    transaction.accountAge = 10;
    transaction.shopperReference = shopperReference;
    document.getElementById('gameIframe').contentWindow.postMessage(JSON.stringify(transaction));
}

const playGameAuthorized = () => {
    document.getElementById("gameDiv").style.visibility = "visible";
    let transaction = {};
    transaction.amount = 1000;
    transaction.currency = "JPY";
    transaction.shopperCountry = "JP";
    transaction.deliveryCountry = "JP";
    transaction.accountAge = 10;
    transaction.shopperReference = shopperReference;
    document.getElementById('gameIframe').contentWindow.postMessage(JSON.stringify(transaction));
}

const startDev = async() =>
{
  // Hide title
  document.getElementById('start').style.visibility = 'hidden';
  // Shot tap your card
  document.getElementById('tap').style.visibility = "visible";
  // Call card acquisition
  let terminalID = document.getElementById('terminalID').value;
  shopperReference = await cardAcquisiton(terminalID);
  // Hide tap your card
  document.getElementById('tap').style.visibility = "hidden";
  // Show welcome message
  document.getElementById('shopperName').innerHTML = "Welcome " + shopperReference;
  document.getElementById('gameMain').style.visibility = "visible";
}

const start = async () => {

    // Hide title
    document.getElementById('start').style.visibility = 'hidden';
    // Shot tap your card
    document.getElementById('tap').style.visibility = "visible";
    // Call card acquisition
    let terminalID = document.getElementById('terminalID').value;
    shopperReference = await cardAcquisiton(terminalID);
    // Hide tap your card
    document.getElementById('tap').style.visibility = "hidden";
    // Show welcome message
    document.getElementById('shopperName').innerHTML = "Welcome " + shopperReference;
    document.getElementById('gameMain').style.visibility = "visible";
}

const exit = () => {
    location.reload();
}

const assignTerminalId = () => {
    document.cookie = "terminalId="+document.getElementById('terminalID').value;
}

const initTerminalId = () => {
    if (document.cookie) {
        let terminalID = document.cookie.split("=")[1];
        document.getElementById('terminalID').value = terminalID;
    }
}
</script>

<body onload="initTerminalId()">


<div class="main">

<div class="start" id="start"><div onclick="startDev()">TOUCH TO START THE GAME</div>
<div class="terminalID"><input id="terminalID" value="V400m-347148879"/><button class="terminalIDButton" onclick="assignTerminalId()">assign</button></div></div>

<div class="tap" id="tap">TAP YOUR CARD ON THE TERMINAL</div>

<div class="gameMain" id="gameMain">

    <div class="welcome" id="welcome">
        <div id="shopperName"></div>
        <button onClick="exit()">Logout</button>
    </div>
    <div>
        <div id="slot">
            <div id="headingsContent">
            <div id="headings">
              <tr>
                <td>
                  <text>Shopper country</text>
                </td>
                <td>
                  <text>Amount</text>
                </td>
                <td>
                  <text>Delivery country</text>
                </td>
                <td>
                  <text>Currency</text>
                </td>
                <td>
                  <text>Account age</text>
                </td>
              </tr>
            </div>
            </div>
            <div id="spinGame">
                <div id="reels">
                <div class="reel"></div>
                <div class="reel"></div>
                <div class="reel"></div>
                <div class="reel"></div>
                <div class="reel"></div>
                </div>
            </div>
            <div id="controls">
              <button type="button" id="spin">SPIN</button>
            </div>
          </div>
          <script crossorigin="anonymous" src="https://polyfill.io/v3/polyfill.min.js?features=default%2CWebAnimations"></script>
          <script src="../js/all.js"></script>
    </div>
    
</div>

<div class="gameDiv" id="gameDiv">
    <div class="closeDiv"><button onclick="closeGameResults()" class="closeButton">X</button></div>
    <div class="popup">
        <iframe title="Game iframe" class="gameIframe" id="gameIframe" src="backend/results.php"></iframe>
    </div>
</div>

</div>

</body>

</html>
