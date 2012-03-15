define(['Utils/getEl'], function( getEl ) {
	
	jQuery('.del-image').click(function(e) {
		
		var target = e.target,
			image = jQuery(target).attr('id'),
			imgfield = jQuery('#imgname').val(),
			pageID = jQuery('#hidden_id').val(),
			tableRef = jQuery('#table_ref').val();
			
		imgfield = imgfield.replace( image, "");
		
		
		
		jQuery.post( '/GitHub/CMS/AJAX_delete', { image: image, id: pageID, table: tableRef, newvalue: imgfield }, function(data) {
			
			var img = getEl('img_'+data);
			// Removing the element with jquery does'nt work
			// So had to fall back to just setting the HTML to empty 
			img.innerHTML = '';
			
		});
	
		
	});
	
});