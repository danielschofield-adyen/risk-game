export default class Symbol {

  constructor()
  {
    this.cache = {};
    this.dataPool;
    this.data;
  }

  get data()
  {
    return[];
  }

  preload() {
    populateDataPool();
  }

  populateDataPool()
  {
    dataPool = this.data;
    console.log(dataPool);
  }

  popData()
  {
    //if the flag pool is empty, populate!
    if(dataPool.length === 0)
      this.populateDataPool();

      while(dataPool.length ) {
        var index = Math.floor( Math.random()*dataPool.length );
        var item = dataPool[index];
        console.log(item); // Log the item
        dataPool.splice( index, 1 ); // Remove the item from the array
        return item;
    }
  }
}
