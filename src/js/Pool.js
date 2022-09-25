data = [];

export default class Pool
{
    constructor(array)
    {
        poolData = array;
    }

    pop()
    {
        while(data.length ) {
          var index = Math.floor( Math.random()*data.length );
          var item = data[index];
          console.log("Getting item"+item); // Log the item
          data.splice( index, 1 ); // Remove the item from the array
          return item;
      }
    }

    push(item)
    {
        data.push(item);
        console.log("Adding item: "+item);
    }
}