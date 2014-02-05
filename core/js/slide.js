$(function() {

    var that = this;

    that.afterSlide = function(event) {        
        var index = that.el.pageSwiper.activeSlide;
        // Get all slides
        var $slides   = $(that.el.pageSwiper.slides),
            $slide    = $slides.eq(index),
            $next     = $slides.eq(index+1),
            $previous = index < 1  ? [] : $slides.eq(index-1);

        $slides.removeClass("js-active");
        $slide.addClass("js-active");

        // Update URL
        that.updateUrlFrom($slide);
        // Refresh the content height
        that.heightPageSlide($slide)
        // Reload objects markups
        $slide.trigger("slide:fill");
        // load social button
        Socialite.load($slide);
        // Slide to the top of the window
        if( $(window).scrollTop() > 170 ) $(window).scrollTo(170, 700);        

        // Navigation button
        that.el.$navNext.removeClass("hidden")            
        that.el.$navPrevious.removeClass("hidden")

        // Add a slide if we reach the last one or the next one is empty
        if( index == $slides.length -1 ) {                                                                         
            // load the next post
            that.loadNextPost($slide);   
        }

        // Is the previous one empty ?
        if( $previous.length === 0) {           
            // load the next post
            that.loadPreviousPost($slide);                 
        }         

    };

    that.fillSlide = function(event) {
        var $slide = $(event.currentTarget);
        // Fill out a slide without its content         
        $slide.find(".js-content").html( $slide.data("content") ); 
        // Update the height a first time        
        that.heightPageSlide($slide)
        // Update the height again after images are loaded
        $slide.imagesLoaded(function() { that.heightPageSlide( $(this) ); })
    };

    that.heightPageSlide = function($slide) {      
        // Change the slide height
        $slide.css("height", "auto")
        // Refresg the pageSlide height
        that.el.$pageSlide.css("height", $slide.outerHeight() );
    };

    that.prepareSlide = function(data, prepend) {        
        // Get the card from the received page
        var $card = $(data).find(".js-card");                    
        // Update iframes for a better display    
        $card.find("iframe").each(function(i, iframe) {
            $iframe = $(iframe);
            // Add html5 parameter
            src = $iframe.attr("src");
            src += src.indexOf("?") > -1 ? "&html5=1" : "?html5=1";                     
            // Update iframe attributes
            $iframe.attr({
                "wmode": "transparent",
                "allowfullscreen": "true",
                "src": src
            });
        }); 
        // Extract the content from the article
        var content = $card.find(".js-content").html();
        // Remove the article content
        $card.find(".js-content").empty()
        // append the new card
        var slide = that.el.pageSwiper.createSlide( $card.html() ),
           $slide = $(slide);
        // Bind the card data to its HTML slide
        $slide.data($card.data());
        // Load the content of the card as slide data
        $slide.data("content", content);
        // Bind a "fill" event to the slide once
        $slide.one("slide:fill", that.fillSlide);                            
        // Append or prepend the slide to the slider
        if(prepend) {
            slide.prepend()
            // Align to the right page
            that.el.pageSwiper.swipeTo(that.el.pageSwiper.activeSlide + 1, 0)
        } else slide.append()
        // load special presentation
        that.initColumnize();
    }

    that.loadNextPost = function($current, u) {
        // Gets the URL from the parameter or from the current post 
        var url = u || $current.find(".js-navigation .next > a").attr("href");
        // Only load existing url
        if(url !== undefined) {
            // Avoid load the next post twice
            if(that.nextLocked) return;
            // Load the next-post-loader
            that.nextLocked = true;

            $.ajax({
                url: url,
                success: function(data) {
                    that.prepareSlide(data, false)
                    // Unlock next loading
                    that.nextLocked = false;                            
                }
            });

            that.el.$navNext.removeClass("hidden")
        } else {
            that.el.$navNext.addClass("hidden");
        }
    };


    that.loadPreviousPost = function($current, u) {

        // Gets the URL from the parameter or from the current post 
        var url = u || $current.find(".js-navigation .previous > a").attr("href");
        // Only load existing url
        if(url !== undefined) {
            // Avoid load the next post twice
            if(that.previousLocked) return;
            // Load the next-post-loader
            that.previousLocked = true;

            $.ajax({
                url: url,
                success: function(data) {
                    that.prepareSlide(data, true)
                    // Unlock next loading
                    that.previousLocked = false;                            
                }
            });

            that.el.$navPrevious.removeClass("hidden")
        } else {
            // No next card ! Add the page "en-vrac"
            if( $current.find(".js-navigation").length ) {
                that.el.$navPrevious.removeClass("hidden")                
                that.loadPreviousPost($current, "/en-vrac" );
            } else {                
                that.el.$navPrevious.addClass("hidden");
            }
        }        
    };


    that.updateUrlFrom = function($slide) {
        
        var title = $slide.data("title"),
              url = $slide.data("permalink");

        // if the url change and the History API is available
        if(url != decodeURIComponent(window.location.href) ) {      
            // Change the current by the new one
            History.pushState(null, title, url);
            // Update the google analytics tracker
            that.updateGa();
        }
    }   

    /**
     * Update Google Analytics
     */
    that.updateGa = function(url) {
        return window._gaq && window._gaq.push(['_trackPageview', window.location.href.split(window.location.hostname)[1] ]);
    };


    /**
     * Slides with the keyboard
     * @param  {Object} event Event received 
     */
    that.keyboardSlide = function(event) {

        // Disabled shortcuts when we focus on an input
        if(that.disableShortcuts) return;

        switch(event.keyCode) {
            
            case 37: // left
                that.el.pageSwiper.swipePrev();
                break;

            case 39: // right
                that.el.pageSwiper.swipeNext();
                break;

            case 38: // up
                event.preventDefault();
                var scrollTop = $(window).scrollTop() - $(window).height()/2;
                // Avoid negative scroll tentative
                if(scrollTop < 0) scrollTop = 0;
                // Prevent scroll queing
                jQuery.scrollTo.window().queue([]).stop();
                $(window).scrollTo(scrollTop, 700);
                break;

            case 40: // down            
                event.preventDefault();
                var scrollTop = $(window).scrollTop() + $(window).height()/2;               
                // Prevent scroll queing
                jQuery.scrollTo.window().queue([]).stop();
                $(window).scrollTo(scrollTop, 700);
                break;
        }
    }; 


    that.slideClick = function(e) {        
        setTimeout(function() {
            that.el.pageSwiper.swipeTo( e.clickedSlideIndex, 400);
        }, 10)   
    }

    that.initShortcuts = function() {

        // Elements in the page
        that.el = {            
            $pageSlide:     $("#pageSlide"),
            $content:       $("#content"),
            $navPrevious:   $(".slider-nav .previous"),
            $navNext:       $(".slider-nav .next")
        };

    };


    that.initSlide = function() {               

        var options = {                
            wrapperClass: "js-wrapper",   
            slideClass: "js-card",
            mode:'horizontal',
            onSlideChangeEnd: that.afterSlide,
            onSlideClick: that.slideClick
        };

        that.el.pageSwiper = that.el.$pageSlide.swiper(options);   
        that.el.$pageSlide.addClass("js-ready");

        that.el.$navNext.on("click", that.el.pageSwiper.swipeNext)
        that.el.$navPrevious.on("click", that.el.pageSwiper.swipePrev)

        that.afterSlide();
    };  

    that.initColumnize = function() {
        $(".js-columnize.js-col3:not(.js-rendered)").columnize({columns:3}).addClass("js-rendered");
        $(".js-columnize.js-col2:not(.js-rendered)").columnize({columns:2}).addClass("js-rendered");
    };

    that.loadInterspace = function(categories, page) {

        var params = {
            json:"topic.get",
            categories:categories,
            page:page,
            count: Math.floor( that.el.$interspace.innerWidth() / 160 ) - 1
        };

        // Loading mode for Interspace
        that.el.$interspace.loading(true, "black");

        $.get("/", params, function(data) {
            
            // Update the next page link
            that.el.$interspace.find(".previous-page").data("categories", categories).data("page", page-1);
            that.el.$interspace.find(".next-page").data("categories", categories).data("page", page+1);

            // Parse the template with the data
            that.el.$interspace.find(".wrapper").html( that.tpl.interspaceList(data) );

            // Change the size of the wrapper center it with margin:auto;
            that.el.$interspace.find(".wrapper").css("width", data.posts.length * 160);

            // Add a class for the first and the last page
            that.el.$interspace.toggleClass("first", page === 1);
            that.el.$interspace.toggleClass("last",  page === data.pages);

            // Remove loading mode for Interspace
            that.el.$interspace.loading(false);

        });

    };


    (that.init = function() {

        // iOs detection
        if( navigator.userAgent.match(/(iphone|ipod|ipad|android)/i) != null ) $("html").addClass("touch");
        else $("html").addClass("no-touch");

        // Naviguation with the keyboard
        $(document).keydown(that.keyboardSlide);
        // To temporary disabled shortcuts
        $(window).delegate("input[type=text],input[type=password],textarea", "focus blur mousedown click", function(e) {
            switch(e.type) {
                case "mousedown": 
                    e.stopPropagation();
                    break;

                case "focusin":
                    that.disableShortcuts = true;
                    break;

                case "focusout":
                    that.disableShortcuts = false;
                    break;
            }
        });

        that.initShortcuts();
        that.initColumnize();
        if(Modernizr.history && that.el.$pageSlide.length) that.initSlide();

          // Bind to StateChange Event
        $(window).bind('statechange',function(a){
                
                var $slides = that.el.$pageSlide.find(".js-card"),
                      State = History.getState(); 

                // Update the title of the page
                document.title = window.title = State.title;

                if( State.url != $slides.filter(".js-active").data("permalink") ) {

                    // find the slide with the right url
                    var $slide = $slides.filter("[data-permalink='"+ State.url +"']");

                    //Or go to the page (reload)
                    document.location.href = State.url;
                }

        });

    })();

});
