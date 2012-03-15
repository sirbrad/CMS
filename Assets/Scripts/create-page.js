define(['Utils/getEl', 'Utils/elementSibling', 'Utils/jquery'], function($, getId, es) {
	
	jQuery('#image').change(function(){
		if (jQuery('#image').is(':checked')) {
			jQuery('#noimg').show();
		} else {
			jQuery('#noimg').hide();
		}
	});
	
	
});