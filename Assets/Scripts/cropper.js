define(['Utils/getEl', 'Utils/jquery'], function( getEl ) {
	
	
	jQuery('#img-overlay').mousedown(function() {
		
		var pos = event.clientX;
		
		jQuery('#img-region').css( 'border','1px solid red',
								   'position', 'absolute',
								   'height', pos+'px' );
		
		
		
	});
	
	
	

	
})