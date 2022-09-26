export default class ImageView
{
    constructor(name)
    {
        this.img = new Image();
        this.img.src = require(`../assets/symbols/${name}.png`);
    }
}