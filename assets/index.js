var Reel = function( container, images, options ){
    
    this.window = document.createElement("div");
    this.window.className = "window";
    
    this.images = document.createElement("div");
    this.images.className = "images";
        
        
    var createArrowClickHandler = function(ctx, amount){
        return function(){ ctx.slideNav(amount); };
    };    
        
    this.nav = document.createElement("div");
    this.nav.className = "nav";
    var navWidth = images.length*56;
    this.nav.style.minWidth = navWidth + "px";
    this.maxNav = navWidth - 640;
    if( options.thumbnails && navWidth > 640 ){
        var navLeft = document.createElement("div");
        navLeft.className = "navArrow left";
        navLeft.innerHTML = "&#9664;";
        navLeft.onclick = createArrowClickHandler(this, 200);
        this.window.appendChild(navLeft);
        var navRight = document.createElement("div");
        navRight.className = "navArrow right";
        navRight.innerHTML = "&#9654;";
        navRight.onclick = createArrowClickHandler(this, -200);
        this.window.appendChild(navRight);
        this.nav.style.left = "0px";
        this.nav.style.position = "absolute";
    } else {
        this.nav.style.position = "initial";
    }
    var navbar = document.createElement("div");
    navbar.className = "navbar";
    navbar.appendChild(this.nav);
    this.window.appendChild(navbar);
    
    var createNavClickHandler = function(ctx, idx){
        return function(){ ctx.advance(idx); };
    };
    var numImages = 0;
    this.navNodes = [];
    for( var ix in images ){
        var imgSlideimg = document.createElement("img");
        imgSlideimg.src = images[ix];
        var imgSlideEl = document.createElement("div");
        imgSlideEl.className = "slide";
        imgSlideEl.appendChild(imgSlideimg);
        this.images.appendChild(imgSlideEl);
        
        ix = parseInt(ix); // not sure wtf is going on, but getting a non-number number in chrome
        var navNode = document.createElement("span");
        if( options.thumbnails ){
            navNode.className = "navThumb";
            navNode.innerHTML = "<img src='"+images[ix]+"'/>";
        } else {
            navNode.className = "navNode";
            navNode.innerHTML = "&#9679;";
        }
        navNode.onclick = createNavClickHandler( this, ix );
        navNode.style.opacity = (ix===0 ? "1" : "0.5");
        this.nav.appendChild(navNode);
        this.navNodes.push(navNode);
        
        numImages++;
    }
    
    
    
    this.images.style.minWidth = 700*numImages+"px";
    this.images.style.left = "0px";
    this.window.appendChild(this.images);
    
    container.appendChild(this.window);
    
    this.currentSlide = 0;
    this.currentNav = 0;
    this.totalSlides = numImages;
    this.autoplay = options.autoplay;
    this.resumeAutoplay();
};

Reel.prototype.defaultOptions = { autoplay: 0, thumbnails: true, arrows: true };

Reel.prototype.forward = function(){
    var nextSlide = this.currentSlide+1;
    if( nextSlide < this.totalSlides ){
        this.advance(nextSlide);
    } else {
        this.advance(0);
    }
};

Reel.prototype.advance = function(slide){
    console.log(slide);
    this.navNodes[this.currentSlide].style.opacity = 0.5;
    this.navNodes[slide].style.opacity = 1;
    
    this.currentSlide = slide;
    var self = this;
    window.clearInterval(this.advancementInterval);
    this.advancementInterval = window.setInterval( function(){ self.advanceFrame(); }, 7);
};


Reel.prototype.incrementChunk = 20;

Reel.prototype.advanceFrame = function(){
    var imagesTarget = -this.currentSlide*700;
    var imagesCurrent = parseInt(this.images.style.left);
    var imagesSignedDifference = imagesTarget - imagesCurrent;
    var imagesDifference = Math.abs(imagesSignedDifference);
    
    if( imagesDifference < 2 ){
        this.images.style.left = imagesTarget + "px";
        window.clearInterval( this.advancementInterval );
        this.resumeAutoplay();
    } else {
        var incrementer = 0;
        if( imagesDifference > 350 ){ // springy
            incrementer = this.incrementChunk*(imagesDifference/700);
        } else { // slower than springy
            incrementer = this.incrementChunk*(imagesDifference/300);
        }
        
        if( imagesSignedDifference > 0 ){
            this.images.style.left = imagesCurrent + incrementer + 3 + "px";
        } else {
            this.images.style.left = imagesCurrent - incrementer - 3 + "px";
        }
    }
};


Reel.prototype.slideNav = function(amt){
    this.currentNav = this.currentNav + amt;
    window.clearInterval(this.navInterval);
    var self = this;
    this.navInterval = window.setInterval( function(){ self.slideNavFrame(); }, 7);
};

Reel.prototype.slideNavFrame = function(){
    var slideCurrent = parseInt(this.nav.style.left);
    var slideSignedDifference = this.currentNav - slideCurrent;
    var slideDifference = Math.abs(slideSignedDifference);

    if( slideDifference < 2 ){
        this.images.style.left = this.currentNav + "px";
        window.clearInterval( this.navInterval );
    } else if( slideCurrent < -this.maxNav ){
        this.nav.style.left = -this.maxNav+"px";
        this.currentNav = -this.maxNav;
        window.clearInterval( this.navInterval );
    } else if( slideCurrent > 0 ){
        this.nav.style.left = "0px";
        this.currentNav = 0;
        window.clearInterval( this.navInterval );
    } else {
        var incrementer = 0;
        if( slideDifference > 200 ){
            incrementer = this.incrementChunk*(slideDifference/200);
        } else { // slower than linear
            incrementer = this.incrementChunk*(slideDifference/100);
        }
        
        if( slideSignedDifference > 0 ){
            this.nav.style.left = slideCurrent + incrementer + 3 + "px";
        } else {
            this.nav.style.left = slideCurrent - incrementer - 3 + "px";
        }
    }
};



Reel.prototype.resumeAutoplay = function(){
    if( this.autoplay > 0 ){
        var self = this;
        this.advancementInterval = setInterval( function(){ self.forward(); }, this.autoplay );
    }
};











function domLoaded(callback) {
    /* Internet Explorer */
    /*@cc_on
    @if (@_win32 || @_win64)
        document.write('<script id="ieScriptLoad" defer src="//:"><\/script>');
        document.getElementById('ieScriptLoad').onreadystatechange = function() {
            if (this.readyState == 'complete') {
                callback();
            }
        };
    @end @*/
    /* Mozilla, Chrome, Opera */
    if (document.addEventListener) {
        document.addEventListener('DOMContentLoaded', callback, false);
    }
    /* Safari, iCab, Konqueror */
    if (/KHTML|WebKit|iCab/i.test(navigator.userAgent)) {
        var DOMLoadTimer = setInterval(function () {
            if (/loaded|complete/i.test(document.readyState)) {
                callback();
                clearInterval(DOMLoadTimer);
            }
        }, 10);
    }
    /* Other web browsers */
    window.onload = callback;
};

function togglePortfolio(){
    var portfolio = document.getElementById("portfolio");
    if( portfolio.className === "" ){
        portfolio.className = "ninja";
    } else {
        portfolio.className = "";
    }
}