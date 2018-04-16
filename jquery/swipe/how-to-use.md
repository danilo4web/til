
#How to use jquery swipe
jQuery("#indoor-box").swipe( {
	swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
		if (direction == 'right') { 
			plusIndoor(-1); 
		}
		if (direction == 'left') { 
			plusIndoor(1); 
		}
	},
	threshold: 100,
	allowPageScroll: 'vertical'		
});

# Set some options later

jQuery("#test").swipe( {fingers: 2} );