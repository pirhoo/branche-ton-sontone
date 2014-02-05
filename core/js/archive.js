(function(window, undefined) {

	$(window).load(function() {
		var that = this;
		$('#archive').isotope({
		  // options
		  itemSelector : '.js-card',
		  layoutMode : 'masonry',	
		});
	});



})(window);