import Symbol from "./Symbol.js";

export default class Flag extends Symbol {
  
  constructor()
  {
    super();
    this.name = this.popData();

    if (super.cache[this.name]) {
      this.img = cache[this.name].cloneNode();
    } else {
      this.img = new Image();
      this.img.src = require(`../assets/flags/${this.name}.png`);

      cache[this.name] = this.img;
    }
  }

  static get data()
  {
    return[
    "comoros",
    "america",
    "australia",
    "bangladesh",
    "canada",
    "chile",
    "china",
    "christmas",
    "colombia"
    ];
  }
}
