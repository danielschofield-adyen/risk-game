<!DOCTYPE html>
<html lang="en">
<head>
    <title>Risk Game</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="apple-mobile-web-app-capable" content="yes">

</head>
<script src="js/riskGame.js"></script>

<script>
let shopperReference = "";

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
  let tap = document.getElementById('tap');
  let shopperName = document.getElementById('shopperName');
  let welcome = document.getElementById('welcome');
  let gameMain = document.getElementById('gameMain');

  // Hide title
  document.getElementById('start').style.visibility = 'hidden';
  // Shot tap your card
  document.getElementById('tap').style.visibility = "visible";
  // Call card acquisition
  let terminalID = document.getElementById('terminalID').value;
  shopperReference = await cardAcquisiton(terminalID);

  // Hide tap your card
  //document.getElementById('tap').style.visibility = "hidden";
  // Show welcome message


  if(tap) tap.style.visibility = "hidden";
  if(shopperName) shopperName.innerHTML  = "ようこそ、" + shopperReference + "さん";
  if(gameMain) {
    gameMain.style.visibility = "visible";
    welcome.style.visibility = "visible";
  }
  /*document.getElementById('shopperName').innerHTML = "Welcome " + shopperReference;
  document.getElementById('gameMain').style.visibility = "visible";*/
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

const pullHandle = () =>
{
  console.log("Pulling handle");
  let handle = document.getElementById('handle');
  console.log("Handle: "+handle);

 //if(handle) handle = "assets/risk game apac handle2.svg";
}

</script>

<body onload="initTerminalId()">

<!--
<div class="lock-container">
  <div class="lock">
    <div class="keyhole"></div>
  </div>
</div>
-->


<div class="main">

<div class="start" id="start"><div onclick="startDev()"><!--TOUCH TO START THE GAME-->タップしてスタート</div>
<div class="terminalID"><input id="terminalID" value="V400m-347148879"/><button class="terminalIDButton" onclick="assignTerminalId()">assign</button></div></div>
<div class="tap" id="tap"><!--TAP YOUR CARD ON THE TERMINAL-->ターミナルにカードをタップしてください</div>



<div id="parentContainer">
  <div class="gameMain" id="gameMain">
  <div id="welcome" class="welcome">
    <div id="shopperName"></div>
      <button class="logoutButton" onClick="exit()"><!--Logout-->ログアウト</button>
    </div>
    <div id="slot">
      <div id="headingsContent">
        <div class="heading"><!--Amount-->購入額</div>
        <div class="heading"><!--Currency-->通貨</div>
        <div class="heading"><!--Shopper location-->ショッパーの場所</div>
        <div class="heading"><!--Delivery location-->配送場所</div>
        <div class="heading"><!--Account age-->利用年数</div>
      </div>
      <div id="reels">
        <div class="reel"></div>
        <div class="reel"></div>
        <div class="reel"></div>
        <div class="reel"></div>
        <div class="reel"></div>
      </div>

      <!-- TODO: animate lights at the bottom of the screen as well
      <div id="bottomLights">
        <div class="light animateSymbol"></div>
        <div class="light animateSymbol"></div>
        <div class="light animateSymbol"></div>
        <div class="light animateSymbol"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
        <div class="light"></div>
      </div>-->
    </div>

    <button id="handle"></button>
    <!--<button type="submit" style="border: 0; background: transparent" value="pullHandle()">
      <img id="handle" src="assets/risk game apac handle1.svg"  />
    </button>-->
  </div>
</div>

<script src="../js/all.js"></script>

<div class="gameDiv" id="gameDiv">
    <div class="popup">
        <iframe title="Game iframe" class="gameIframe" id="gameIframe" src="backend/results.php" allowtransparency="true"></iframe>
  </div>
</div>


</div>

</body>

</html>
