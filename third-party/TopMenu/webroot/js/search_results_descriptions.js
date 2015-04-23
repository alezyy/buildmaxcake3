(function(){
    var cuisineDescriptionHeight;
    $(document).ready(function () {
        
        // StickyTitles stuff
        var newStickies = new stickyTitles(jQuery(".followMeBar"));		
		newStickies.load();			
		$(window).on("scroll", function() {newStickies.scroll();});

        // Cuisine descriptoin div height managment
        cuisineDescriptionHeight = $("#cuisineDescription").height();
        console.log(cuisineDescriptionHeight);
        if (cuisineDescriptionHeight > 140) {
            $("#cuisineDescription").height(140);
            $("#cuisineDescriptionShowMore").show();
            $("#cuisineDescriptionShowLess").hide();
        }
    });

    // Cuisine descriptoin div height managment
    $('#cuisineDescriptionMoreLink').click(function() {
        $("#cuisineDescription").height(cuisineDescriptionHeight);
        $("#cuisineDescriptionShowLess").show();
        $("#cuisineDescriptionShowMore").hide();
    });
    $('#cuisineDescriptionLessLink').click(function() {
        $("#cuisineDescription").height(140);
        $("#cuisineDescriptionShowLess").hide();
        $("#cuisineDescriptionShowMore").show();
    });
 
    /**
     * Function for the header bar that follow the top of viewport when user is scrolling
     * @param {type} stickies
     * @returns {_L1.stickyTitles}
     */
    function stickyTitles(stickies) {

    this.load = function() {

			  stickies.each(function(){
				
				    var thisSticky = jQuery(this).wrap('<div class="followWrap" />');
				        thisSticky.parent().height(thisSticky.outerHeight());
				
				    jQuery.data(thisSticky[0], 'pos', thisSticky.offset().top);

			  });
		}
			
		this.scroll = function() {
		
			  stickies.each(function(i){				
				
				    var thisSticky = jQuery(this),
					      nextSticky = stickies.eq(i+1),
					      prevSticky = stickies.eq(i-1),
					      pos = jQuery.data(thisSticky[0], 'pos');
			
				    if (pos <= jQuery(window).scrollTop()) {
					
					      thisSticky.addClass("fixed");
					
					      if (nextSticky.length > 0 && thisSticky.offset().top >= jQuery.data(nextSticky[0], 'pos') - thisSticky.outerHeight()) {
						
						        thisSticky.addClass("absolute").css("top", jQuery.data(nextSticky[0], 'pos') - thisSticky.outerHeight());

					      }
					
				    } else {
					
					      thisSticky.removeClass("fixed");
					
					      if (prevSticky.length > 0 && jQuery(window).scrollTop() <= jQuery.data(thisSticky[0], 'pos')  - prevSticky.outerHeight()) {
					
						        prevSticky.removeClass("absolute").removeAttr("style");
					
					      }
					
				    }
		    });			
    }
}
})();