import AmountDataModel from "./AmountDataModel.js";
import FlagDataModel from "./FlagDataModel.js";
import Pool from "./Pool.js";

export default class GameController
{
    constructor()
    {
        this.pools = [];
        this.Initialise();
    }

    Initialise()
    {
        var flagModel = new FlagDataModel();
        var flagPool = new Pool(flagModel.data);

        var amountModel = new AmountDataModel();
        var amountModel = new Pool(amountModel.data);

        this.pools.push(flagPool);        
        this.pools.push(amountModel);       
        this.pools.push(flagPool);        
        this.pools.push(flagPool);        
        this.pools.push(flagPool);
    }
}