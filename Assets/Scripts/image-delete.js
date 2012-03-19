define(['Utils/getEl', 'jquery'], function(getEl) {
	
	jQuery("div#image-list").delegate(".del-image","click",function(e){
		
		var target = e.target,
			form = document.forms.form,
			image = jQuery(target).attr('id'),
			imgfield = form.imgname.value,
			pageID = jQuery('#hidden_id').val(),
			tableRef = jQuery('#table_ref').val();
			
		// Replace the selected image field to blank in the hidden field
		imgfield = imgfield.replace( image+";", "" );
		
		// For some reason I have to set it again for it to pick it up?
		form.imgname.value = imgfield;
		
		jQuery.post( '/GitHub/CMS/AJAX_delete', { image: image, id: pageID, table: tableRef, newvalue: form.imgname.value }, function(data) {
			
			var img = getEl('img_'+data);
			// Removing the element with jquery does'nt work
			// So had to fall back to just setting the HTML to empty 
			img.innerHTML = '';
			
		});
	
		
	});
	
});