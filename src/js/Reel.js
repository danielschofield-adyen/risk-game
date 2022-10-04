import ImageView from "./ImageView";
import GameController from "./GameController";

export default class Reel 
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
        var img = new Image();
        img.src = require(`../assets/symbols/${symbol}.png`);
        this.symbolContainer.appendChild(img);
      })
  }

  spin() 
  {
    //Add class to start css animation
    var children = this.symbolContainer.querySelectorAll("img");
    children.forEach(child => child.setAttribute("class", "ringMoving"));
    
    var iteration = 0;
    this.currentSymbols.forEach(symbol =>
    {
      children[iteration].src = require(`../assets/symbols/${symbol}.png`);
      iteration++;
    });
  }

  stop()
  {
    var children = this.symbolContainer.querySelectorAll("img");
    children.forEach(child => child.setAttribute("class", "ringEnd"));
  }
}
