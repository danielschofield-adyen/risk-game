import ImageView from "./ImageView";

export default class Reel {
  constructor(reelContainer, idx, initialSymbols) {
    this.reelContainer = reelContainer;
    this.idx = idx;

    this.symbolContainer = document.createElement("div");
    this.symbolContainer.classList.add("icons");
    this.reelContainer.appendChild(this.symbolContainer);

    this.animation = this.symbolContainer.animate(
      [
        { transform: "none", filter: "blur(0)" },
        { filter: "blur(2px)", offset: 0.5 },
        {
          transform: `translateY(-${
            ((Math.floor(this.factor) * 10) /
              (3 + Math.floor(this.factor) * 10)) *
            100
          }%)`,
          filter: "blur(0)",
        },
      ],
      {
        duration: this.factor * 1000,
        easing: "ease-in-out",
      }
    );
    this.animation.cancel();

    initialSymbols.forEach((symbol) =>
      this.symbolContainer.appendChild(new ImageView(symbol).img)
    );
  }

  get factor() {
    return 1 + Math.pow(this.idx / 2, 2);
  }

  renderSymbols(nextSymbols) {
    const fragment = document.createDocumentFragment();


    nextSymbols.forEach((symbol) => 
    {
      var icon = new ImageView(symbol); 
      fragment.appendChild(icon.img)
    });
/*
    for (let i = 3; i < 3 + Math.floor(this.factor) * 10; i++) {
      var index = i >= 10 * Math.floor(this.factor) - 2;
      var comparison = i - Math.floor(this.factor) * 10;
      console.log("index :"+index+" comparison: "+comparison);
      if(index)
      {
        const icon = new ImageView(nextSymbols[comparison])
        fragment.appendChild(icon.img);
      }
      /*
      const icon = new ImageView(
          i >= 10 * Math.floor(this.factor) - 2
          ? nextSymbols[i - Math.floor(this.factor) * 10]
          : undefined
      );
      fragment.appendChild(icon.img);

    }
      */
    this.symbolContainer.appendChild(fragment);
  }

  spin() {
    const animationPromise = new Promise(
      (resolve) => (this.animation.onfinish = resolve)
    );
    const timeoutPromise = new Promise((resolve) =>
      setTimeout(resolve, this.factor * 1000)
    );

    this.animation.play();

    return Promise.race([animationPromise, timeoutPromise]).then(() => {
      if (this.animation.playState !== "finished") this.animation.finish();

      const max = this.symbolContainer.children.length - 3;

      for (let i = 0; i < max; i++) {
        this.symbolContainer.firstChild.remove();
      }
    });
  }
}
