define(['Utils/getEl'], function( getEl ) {
	
	console.log(12312312);
	jQuery('.del-image').click(function(e) {
		
		var target = e.target,
			image = jQuery(target).attr('id'),
			imgfield = jQuery('#imgname').val(),
			pageID = jQuery('#hidden_id').val(),
			tableRef = jQuery('#table_ref').val();
			
		console.log(imgfield);	
		
		imgfield = imgfield.replace( image+';', "");
		
		jQuery.post( '/GitHub/CMS/AJAX_delete', { image: image, id: pageID, table: tableRef, newvalue: imgfield }, function(data) {
			console.log(data);
		});
	
		
	});
	
});