jQuery(document).ready(function($) { 
	
	jQuery("#hermes-gallery").flexslider({
        selector: ".hermes-slides > .hermes-gallery-slide",
	animationLoop: true,
        initDelay: 1000,
	smoothHeight: false,
	slideshow: true,
	slideshowSpeed: 5000,
	pauseOnAction: true,
        controlNav: false,
	directionNav: true,
	useCSS: true,
	touch: false,
        animationSpeed: 500
	});

});