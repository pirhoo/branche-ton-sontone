$(function() {

	var that = {};

	that.initShortcuts = function() {

		// Elements in the page
		that.el = {
			$topBannerImg:$(".top-banner img"),
			$mainNav: 		$(".main-nav"),
			$body:    		$("body"),
			$interspace: 	$("#interspace"),
			$pageSlide:  	$("#pageSlide"),
			$categories: 	$("#categories"),
			$content:    	$("#content")
		};

		// Template strings
		that.tpl = {
			interspaceList: _.template( $("#tpl-interspace-list").html() )
		};

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

		that.initShortcuts();

		$(window).on("scroll", function() {
			
			var scrollTop = $(window).scrollTop(),
								top = Math.max(-170, -1* scrollTop);

			that.el.$body.toggleClass("fixed-nav", scrollTop > 170);
			that.el.$topBannerImg.css("transform", "translate(0," + top + "px)");
		});

		// PLaceholder fallback
		$('input, textarea').placeholder();		

		// Interspace event
		$(".main-nav").on("click", ".toggle-category", function() {
				
			$(".toggle-category").not(this).removeClass("active");
			$(this).toggleClass("active");

			if( ! $(this).hasClass("active") ) {
				// Close the interspace
				that.el.$interspace.addClass("hide");								
			} else {
				// Open the interspace
				that.el.$interspace.removeClass("hide");
				// Go to the top f the window
				$(window).scrollTo(Math.min(170, $(window).scrollTop() ), 400);        
				// Load its content page 1
				that.loadInterspace( $(this).data("categories") ,1);
			}
		});

		// Next page event for Interspace
		that.el.$interspace.on("click", ".previous-page,.next-page", function() {			
			// Load its content
			that.loadInterspace( $(this).data("categories") , $(this).data("page") );
		});

	})();

});
