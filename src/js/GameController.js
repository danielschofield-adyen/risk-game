import FlagDataModel from "./FlagDataModel.js";
import Pool from "./Pool.js";

let flagPool;
let pools = [];

export default class GameController
{
    constructor()
    {
        this.Initialise();
    }

    Initialise()
    {
        flagModel = new FlagDataModel();
        flagPool = new Pool(flagModel.data);

        pools.push(flagPool);
    }
}