import Reel from "./Reel.js";
import GameController from "./GameController.js";
import ImageView from "./ImageView.js";
import { getSupportInfo } from "prettier";

export default class Slot {
  constructor(domElement, config = {}) {

    this.controller = new GameController();
    //initialise the container
    this.container = domElement;

    this.currentSymbols = this.getSymbols();
    this.nextSymbols = this.getSymbols();

    //get reels from DOM
    this.reels = Array.from(this.container.getElementsByClassName("reel")).map((reelContainer, idx) =>
        new Reel(reelContainer, idx, this.currentSymbols[idx],this.controller)
    );

    this.numOfReels = this.reels.length;

    this.spinButton = document.getElementById("spin");
    this.spinButton.addEventListener("click", () => this.spin());

    this.autoPlayCheckbox = document.getElementById("autoplay");

    if (config.inverted) {
      this.container.classList.add("inverted");
    }

    this.config = config;
  }

  spin() {
    this.currentSymbols = this.nextSymbols;
    this.nextSymbols = this.getSymbols();

    this.onSpinStart(this.nextSymbols);

    return Promise.all(
      this.reels.map((reel) => {
        reel.renderSymbols(this.nextSymbols[reel.idx]);
        return reel.spin();
      })
    ).then(() => this.onSpinEnd(this.nextSymbols));
  }

  onSpinStart(symbols) {
    this.spinButton.disabled = true;

    this.config.onSpinStart?.(symbols);
  }

  onSpinEnd(symbols) {
    this.spinButton.disabled = false;

    this.config.onSpinEnd?.(symbols);

    if (this.autoPlayCheckbox.checked) {
      return window.setTimeout(() => this.spin(), 200);
    }
  }

  getSymbols()
  {
    var doubleArray = [];
    var index = 0;
    this.controller.pools.forEach(pool =>
    { 
      var temp = [];
      for(let i = 0; i < 3; i++)
      {
        var item = pool.pop();
        temp.push(item);
      }
      doubleArray[index] = temp;
      console.log(doubleArray);
      index++;
    });

    return doubleArray;
  }
}
