const cache = {};
var dataPool = [];
var dataLocation = `../assets/flags/`;
var extension = `.png`;

export default class Symbol {
  constructor() {
    this.name = Symbol.popData();

    if (cache[this.name]) {
      this.img = cache[this.name].cloneNode();
    } else {
      this.img = new Image();
      this.img.src = require(`../assets/flags/${this.name}.png`);

      cache[this.name] = this.img;
    }
  }

  static preload() {
    //Symbol.symbols.forEach((symbol) => new Symbol(symbol));

    Symbol.populatedataPool();
    //Symbol.data.forEach((flag) => new Symbol());
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

  static get symbols() {
    return [
      "at_at",
      "c3po",
      "darth_vader",
      "death_star",
      "falcon",
      "r2d2",
      "stormtrooper",
      "tie_ln",
      "yoda",
    ];
  }

  static populateDataPool()
  {
    this.dataPool = this.data;
    console.log(dataPool);
  }

  static popData()
  {
    //if the flag pool is empty, populate!
    if(this.dataPool.length === 0)
      this.populateDataPool();

      while( this.dataPool.length ) {
        var index = Math.floor( Math.random()*this.dataPool.length );
        var item = this.dataPool[index];
        console.log(item); // Log the item
        this.dataPool.splice( index, 1 ); // Remove the item from the array
        return item;
    }
  }
}
