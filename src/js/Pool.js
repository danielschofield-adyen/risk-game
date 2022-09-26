import FlagDataModel from "./FlagDataModel";

export default class Pool
{
    data = [];

    constructor(array)
    {
        console.log(array);
        this.data = array;
    }

    pop()
    {
        while(this.data.length ) {
          var index = Math.floor( Math.random()*this.data.length );
          var item = this.data[index];
          console.log("Getting item " + item); // Log the item
          //this.data.splice( index, 1 ); // Remove the item from the array
          return item;
      }
    }

    push(item)
    {
        this.data.push(item);
        console.log("Adding item: "+item);
    }
}