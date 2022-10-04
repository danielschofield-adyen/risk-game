import Reel from "./Reel.js";
import GameController from "./GameController.js";
import ImageView from "./ImageView.js";
import { getSupportInfo } from "prettier";

export default class Slot 
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
    this.reels.forEach(reel =>
      {
        reel.updateSymbols(this.controller.pools[index].getShuffled())
        setTimeout(() => reel.spin(), timeout);
        setTimeout(() => reel.stop(), timeout + 2000);
        index++;
        timeout = timeout + 300;
      })

      setTimeout(() => this.onSpinEnd(this.controller.getResults()), 2000);   
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
