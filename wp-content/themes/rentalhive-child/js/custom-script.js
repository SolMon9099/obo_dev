
jQuery(document).ready(function($){
	$(".hp-listing--view-page .hp-listing__attributes--secondary .hp-row .hp-col-lg-6").each(function() {
		if ( ($(this).children('.hp-listing__attribute--oboamernities').length > 0) || ($(this).children('.hp-listing__attribute--everydayliving').length > 0) ) {
			$(this).addClass('amentities');
			$(this).css({
				"flex-basis": "100%",
				"max-width": "100%"
			});
		}
	});
});
