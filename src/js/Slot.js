import Reel from "./Reel.js";
import Symbol from "./Symbol.js";
import Flag from "./Flag.js";
import GameController from "./GameController.js";

let controller = new GameController();
let numOfReels = 0;

export default class Slot {
  constructor(domElement, config = {}) {

    //initialise the container
    this.container = domElement;
    this.currentSymbols = [];
    this.nextSymbols = [];

    //get reels from DOM
    this.reels = Array.from(this.container.getElementsByClassName("reel")).map((reelContainer, idx) =>
        new Reel(reelContainer, idx, this.currentSymbols[idx])
    );

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
    this.nextSymbols = [
      [new Flag(), new Flag(), new Flag()],
      [new Flag(), new Flag(), new Flag()],
      [new Flag(), new Flag(), new Flag()],
      [new Flag(), new Flag(), new Flag()],
      [new Flag(), new Flag(), new Flag()],
    ];

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
    var temp = [];
    for(i = 0; i < numOfReels; i++)
    {
      foreach(pool in controller.pools)
      { 
        var item = pool.pop();
        temp.push(item);
      }
    }
    return temp;
  }
}
