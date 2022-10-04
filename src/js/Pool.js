import FlagDataModel from "./FlagDataModel";

export default class Pool
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