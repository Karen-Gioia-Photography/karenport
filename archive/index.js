var Reel = function( container, image_paths, gallery_paths, options ){
    
    this.unit = document.createElement("div");
    this.unit.id = "unit";
    
    this.window = document.createElement("div");
    this.window.className = "window";
    
    this.images = document.createElement("div");
    this.images.className = "images";
        
        
    var createNavArrowClickHandler = function(ctx, amount){
        return function(){ ctx.slideNav(amount); };
    };    
    var createPhotoArrowClickHandler = function(ctx, actionForward){
        if( actionForward ){
            return function(){ ctx.forward(); };
        } else {
            return function(){ ctx.backward(); };
        }
    };
    

        
    this.nav = document.createElement("div");
    this.nav.className = "nav";
    var navWidth = (image_paths.length*(this.thumbnailWidth+this.ditchWidth))-this.ditchWidth;
    this.nav.style.minWidth = navWidth + "px";
    this.maxNav = navWidth - 740;
    
    if( options.thumbnails && navWidth > 740 ){
        // left side
        this.leftbox = document.createElement("div");
        this.leftbox.className = "arrowbox left";
        var photoArrowLeft = document.createElement("div");
        photoArrowLeft.className = "photoArrow left";
        photoArrowLeft.onclick = createPhotoArrowClickHandler(this, false);
        this.leftbox.appendChild(photoArrowLeft);
        var navArrowLeft = document.createElement("div");
        navArrowLeft.className = "navArrow left";
        navArrowLeft.innerHTML = "&#9664;";
        navArrowLeft.onclick = createNavArrowClickHandler(this, 200);
        this.leftbox.appendChild(navArrowLeft);
        
        // right side
        this.rightbox = document.createElement("div");
        this.rightbox.className = "arrowbox right";
        var photoArrowRight = document.createElement("div");
        photoArrowRight.className = "photoArrow right";
        photoArrowRight.onclick = createPhotoArrowClickHandler(this, true);
        this.rightbox.appendChild(photoArrowRight);
        var navArrowRight = document.createElement("div");
        navArrowRight.className = "navArrow right";
        navArrowRight.innerHTML = "&#9654;";
        navArrowRight.onclick = createNavArrowClickHandler(this, -200);
        this.rightbox.appendChild(navArrowRight);
        
        // align or something
        this.nav.style.left = "0px";
        this.nav.style.position = "absolute";
    } else {
        this.nav.style.position = "initial";
    }
    var navbar = document.createElement("div");
    navbar.className = "navbar";
    navbar.appendChild(this.nav);
    this.window.appendChild(navbar);
    
    var createNavArrowClickHandler = function(ctx, idx){
        return function(){ ctx.advance(idx); };
    };
    var numImages = 0;
    this.navNodes = [];
    for( var ix in image_paths ){
        var imgSlideimg = document.createElement("img");
        imgSlideimg.src = image_paths[ix];
        var imgSlideEl;
        if( options.linkingImages ){ 
          imgSlideEl = document.createElement("a");
          imgSlideEl.href = gallery_paths[ix];
        } else{
          imgSlideEl = document.createElement("span");    
        }
        imgSlideEl.className = "slide";
        imgSlideEl.appendChild(imgSlideimg);
        this.images.appendChild(imgSlideEl);
        
        ix = parseInt(ix); // not sure wtf is going on, but getting a non-number number in chrome
        var navNode = document.createElement("span");
        if( options.thumbnails ){
            navNode.className = "navThumb";
            navNode.innerHTML = "<img src='"+image_paths[ix]+"'/>";
        } else {
            navNode.className = "navNode";
            navNode.innerHTML = "&#9679;";
        }
        navNode.onclick = createNavArrowClickHandler( this, ix );
        navNode.style.opacity = (ix===0 ? "1" : "0.4");
        this.nav.appendChild(navNode);
        this.navNodes.push(navNode);
 
        if( ix < image_paths.length-1 ){
            var ditch = document.createElement("span");
            ditch.className = "navDitch";
            this.nav.appendChild(ditch);
        }
      
        numImages++;
    }
  
  

    this.images.style.minWidth = 800*numImages+"px";
    this.images.style.left = "0px";
    this.window.appendChild(this.images);
  
    if( this.leftbox ){ 
      this.unit.appendChild(this.leftbox);
    }
    this.unit.appendChild(this.window);
    if( this.rightbox ){ 
      this.unit.appendChild(this.rightbox);
    }
  
    container.appendChild(this.unit);
    
    this.currentSlide = 0;
    this.currentNav = 0;
    this.totalSlides = numImages;
    this.autoplay = options.autoplay;
    this.thumbnails = options.thumbnails;
    this.resumeAutoplay();
};

Reel.prototype.defaultOptions = { autoplay: 0, thumbnails: true, arrows: true };

Reel.prototype.thumbnailWidth = 40;
Reel.prototype.ditchWidth = 14;


Reel.prototype.forward = function(){
    var nextSlide = this.currentSlide+1;
    if( nextSlide < this.totalSlides ){
        this.advance(nextSlide);
    } else {
        this.advance(0);
    }
};

Reel.prototype.backward = function(){
    var previousSlide = this.currentSlide-1;
    if( previousSlide < 0 ){
        this.advance(this.totalSlides-1);
    } else {
        this.advance(previousSlide);
    }
};

Reel.prototype.advance = function(slide){
    console.log(slide);
    this.navNodes[this.currentSlide].style.opacity = 0.5;
    this.navNodes[slide].style.opacity = 1;
    
    var nodeOffset = slide*(this.thumbnailWidth+this.ditchWidth) + parseInt(this.currentNav);
    if( nodeOffset < 0 || nodeOffset > 700 ){
        this.slideNav(-(nodeOffset-200));
    }
  
    this.currentSlide = slide;
    var self = this;
    window.clearInterval(this.advancementInterval);
    this.advancementInterval = window.setInterval( function(){ self.advanceFrame(); }, 7);
};


Reel.prototype.incrementChunk = 30;

Reel.prototype.advanceFrame = function(){
    var imagesTarget = -this.currentSlide*800;
    var imagesCurrent = parseInt(this.images.style.left);
    var imagesSignedDifference = imagesTarget - imagesCurrent;
    var imagesDifference = Math.abs(imagesSignedDifference);
    
    var incrementer = this.incrementChunk*(imagesDifference/800) + 5;
    if( incrementer > imagesDifference ){
        this.images.style.left = imagesTarget + "px";
        window.clearInterval( this.advancementInterval );
        this.resumeAutoplay();
    } else if( imagesSignedDifference > 0 ){
        this.images.style.left = imagesCurrent + incrementer + "px";
    } else {
        this.images.style.left = imagesCurrent - incrementer + "px";
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

    if( slideCurrent < -this.maxNav ){
        this.nav.style.left = -this.maxNav+"px";
        this.currentNav = -this.maxNav;
        window.clearInterval( this.navInterval );
    } else if( slideCurrent > 0 ){
        this.nav.style.left = "0px";
        this.currentNav = 0;
        window.clearInterval( this.navInterval );
    } else {
        var incrementer = 0;
        incrementer = this.incrementChunk*(slideDifference/200) + 5;
        if( incrementer > slideDifference ){
            this.nav.style.left = this.currentNav + "px";
            window.clearInterval( this.navInterval );
        } else if( slideSignedDifference > 0 ){
            this.nav.style.left = slideCurrent + incrementer + "px";
        } else {
            this.nav.style.left = slideCurrent - incrementer + "px";
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