const config = {
    inverted: false, // true: reels spin from top to bottom; false: reels spin from bottom to top
    
    onSpinStart: (symbols) => {
      console.log("onSpinStart", symbols);
    },
    
    onSpinEnd: (symbols) => {
      console.log("onSpinEnd", symbols);
      let transaction = {};
      transaction.amount = symbols.amount;
      transaction.currency = symbols.currency;
      transaction.shopperCountry = symbols.shopperCountry;
      transaction.deliveryCountry = symbols.deliveryCountry;
      transaction.accountAge = symbols.accountAge;;
      transaction.shopperReference = shopperReference;
      document.getElementById('gameIframe').contentWindow.postMessage(JSON.stringify(transaction));
      setTimeout(() => {
        document.getElementById("gameDiv").style.visibility = "visible"
      }, 2000)
    }
};

class Slot 
{
  constructor(domElement, config = {}) 
  {
    //create gameController
    this.controller = new GameController();

    //initialise the container
    this.container = domElement;

    //get reels from DOM
    this.reels = Array.from(this.container.getElementsByClassName("reel")).map((reelContainer, idx) =>
        new Reel(reelContainer, this.controller.pools[idx].getShuffled())
    );

    //get and set spin button
    this.spinButton = document.getElementById("spin");
    this.spinButton.addEventListener("click", () => this.spin());

    //set config
    this.config = config;
  }

  spin() 
  {
    var index = 0;
    var timeout = 100;
    this.onSpinStart(this.controller.getResults());
    this.reels.forEach(reel =>
      {
        reel.updateSymbols(this.controller.pools[index].getShuffled())
        reel.resetWinningLines();
        setTimeout(() => reel.spin(), timeout);
        setTimeout(() => reel.stop(), timeout + 1000);
        index++;
        timeout = timeout + 300;
      })

      setTimeout(() => 
      {
        this.onSpinEnd(this.controller.getResults())
        this.reels.forEach(reel =>
          {
            reel.showWinningLines();
          })

      }, 2500);

  }

  stop()
  {
    this.reels.forEach(reel => reel.stop());
  }

  onSpinStart(symbols) 
  {
    this.spinButton.disabled = true;
    this.config.onSpinStart?.(symbols);
  }

  onSpinEnd(symbols) 
  {
    this.spinButton.disabled = false;
    this.config.onSpinEnd?.(symbols);
  }
}

class Reel 
{
  constructor(reelContainer, initialSymbols) 
  {
    //init reelContainer
    this.reelContainer = reelContainer;

    //set initial symbols
    this.updateSymbols(initialSymbols);

    //render symbol imgs to DOM
    this.renderSymbols();
  }

  updateSymbols(newSymbols)
  {
    this.currentSymbols = newSymbols;
  }

  renderSymbols() 
  {
    this.symbolContainer = document.createElement("div");
    this.symbolContainer.classList.add("icons");
    this.reelContainer.appendChild(this.symbolContainer);


    this.currentSymbols.forEach(symbol =>
      {
        const newDiv = document.createElement("div");
        var img = new Image();
        img.src = `../assets/symbols/${symbol}.svg`;
        newDiv.appendChild(img);
        this.symbolContainer.appendChild(newDiv);
      })

      this.currentSymbols.forEach(symbol =>
        {
          const newDiv = document.createElement("div");
          var img = new Image();
          img.src = `../assets/symbols/${symbol}.svg`;
          newDiv.appendChild(img);
          this.symbolContainer.appendChild(newDiv);
        })
  }

  spin() 
  {
    //Add class to start css animation
    this.setChildrenAttribute("class", "ringMoving", "div");
    
    var images = this.symbolContainer.querySelectorAll("img");
    var iteration = 0;
    this.currentSymbols.forEach(symbol =>
    {
      images[iteration].src = `../assets/symbols/${symbol}.svg`;
      iteration++;
    });
  }

  stop()
  {
    this.setChildrenAttribute("class", "ringStop", "div");
  }

  showWinningLines()
  {
    var children = this.getChildren("img");
    if(children.length >= 3)
      children[2].setAttribute("class", "animateSymbol");
  }

  resetWinningLines()
  {
    var children = this.getChildren("img");
    if(children.length >= 3)
      children[2].setAttribute("class", "");
  }

  getChildren(elementType)
  {
    return this.symbolContainer.querySelectorAll(elementType);
  }

  setChildrenAttribute(attributeToSet, attribute, elementType)
  {
    var children = this.getChildren(elementType);
    children.forEach(child => child.setAttribute(attributeToSet, attribute));
  }
}

class Pool
{
    data = [];

    constructor(array)
    {
        console.log(array);
        this.set(array);
    }

    get()
    {
        return this.data;
    }

    set(array)
    {
        this.data = array;
    }

    getShuffled()
    {
        this.shuffleArray(this.data);
        return this.get();
    }

    shuffleArray(array)
    {
      for (var i = array.length - 1; i > 0; i--)
      {
          var j = Math.floor(Math.random() * (i + 1));
          var temp = array[i];
          array[i] = array[j];
          array[j] = temp;
      }
    }

    /* Not needed anymore
    pop()
    {
        while(this.data.length ) {
          var index = Math.floor( Math.random()*this.data.length );
          var item = this.data[index];
          console.log("Getting item " + item); // Log the item
          this.data.splice( index, 1 ); // Remove the item from the array
          console.log("pop: " + this.data);
          return item;
      }
    }

    push(item)
    {
        this.data.push(item);
        console.log("Setting item: "+item);
        console.log("push: " + this.data);
    }
    */
}

class ImageView
{
    constructor(name)
    {
        this.img = new Image();
        this.img.src = require(`../assets/symbols/${name}.svg`);
    }
}

class GameController
{
    constructor()
    {
        this.pools = [];
        this.initialise();
    }

    initialise()
    {
        var shopperCountry = new FlagDataModel();
        var shopperCountryPool = new Pool(shopperCountry.data);

        var deliveryCountry = new FlagDataModel();
        var deliveryCountryPool = new Pool(deliveryCountry.data);

        var amountModel = new AmountDataModel();
        var amountModelPool = new Pool(amountModel.data);

        var currencyDataModel = new CurrencyDataModel();
        var currencyDataModelPool = new Pool(currencyDataModel.data);

        var accountAgeDataModel = new AccountAgeDataModel();
        var accountAgeDataModelPool = new Pool(accountAgeDataModel.data);

        this.pools.push(shopperCountryPool);        
        this.pools.push(amountModelPool);       
        this.pools.push(deliveryCountryPool);        
        this.pools.push(currencyDataModelPool);        
        this.pools.push(accountAgeDataModelPool);
    }

    getResults()
    {
        let results = [];
        results['shopperCountry'] = this.pools[0].data[1];
        results['amount'] = this.pools[1].data[1];
        results['deliveryCountry'] = this.pools[2].data[1];
        results['currency'] = this.pools[3].data[1];
        results['accountAge'] = this.pools[4].data[1];
        return results;
    }
}

class FlagDataModel
{
    data = ["AU", "CN", "HK", "JP", "SG", "KR", "TW"];
}

class CurrencyDataModel
{
    data = ["AUD", "CNY", "EUR", "HKD", "SGD", "USD", "YEN"];
}

class AmountDataModel
{
    data = [
      "1000",
      "5000",
      "10000",
      "15000",
      "20000",
      "50000",
      "100000"
      ];
}

class AccountAgeDataModel
{
    data = [
      "1",
      "3",
      "24",
      "72",
      "168",
      "720",
      "2160"
      ];
}

const slot = new Slot(document.getElementById("slot"), config);