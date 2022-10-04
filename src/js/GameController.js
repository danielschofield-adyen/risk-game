import AmountDataModel from "./AmountDataModel.js";
import FlagDataModel from "./FlagDataModel.js";
import CurrencyDataModel from "./CurrencyDataModel.js";
import AccountAgeDataModel from "./AccountAgeDataModel.js";
import Pool from "./Pool.js";

export default class GameController
{
    constructor()
    {
        this.pools = [];
        this.initialise();
    }

    initialise()
    {
        var shopperCountry = new FlagDataModel();
        var shopperCountryPool = new Pool(shopperCountry.data);

        var deliveryCountry = new FlagDataModel();
        var deliveryCountryPool = new Pool(deliveryCountry.data);

        var amountModel = new AmountDataModel();
        var amountModelPool = new Pool(amountModel.data);

        var currencyDataModel = new CurrencyDataModel();
        var currencyDataModelPool = new Pool(currencyDataModel.data);

        var accountAgeDataModel = new AccountAgeDataModel();
        var accountAgeDataModelPool = new Pool(accountAgeDataModel.data);

        this.pools.push(shopperCountryPool);        
        this.pools.push(amountModelPool);       
        this.pools.push(deliveryCountryPool);        
        this.pools.push(currencyDataModelPool);        
        this.pools.push(accountAgeDataModelPool);
    }

    getResults()
    {
        let results = [];
        results['shopperCountry'] = this.pools[0].data[1];
        results['currency'] = this.pools[1].data[1];
        results['amount'] = this.pools[2].data[1];
        results['deliveryCountry'] = this.pools[3].data[1];
        results['accountAge'] = this.pools[4].data[1];
        return results;
    }
}