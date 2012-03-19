define(['swf-upload'], function(uploadify){
	
	var doc = document, link, input, filebrowser, removeBtn;
	
	input = doc.getElementById("multi-upload");
	removeBtn = doc.getElementById("removeImg");
	
	jQuery(removeBtn).hide();
	
	filebrowser = doc.getElementById('upload');
	filebrowser.style.left = '150px';
	
	uploadContainer = document.createElement('div');
	uploadContainer.className = "flashContainer";
	input.appendChild(uploadContainer);

	uploadContainer.innerHTML = '<div id="fileQueue"></div>';
	
	var config = this.admin_images[0],
		settings = {
			buttonText: 'Upload Image',
			uploader: config.uploader || 'input[type="file"]',
			fileQueue: 'fileQueue',
			width: config.width || 620,
			height: config.height,
			thumb_width: config.thumbwidth,
			thumb_height: config.thumbheight,
			script: config.script || '/GitHub/CMS/AJAX_uploadify_uploader',
			fileDesc: 'Standard image formats (*.jpeg; *.jpg; *.gif; *.bmp; *.png)',
			fileExt: '*.jpeg; *.jpg; *.gif; *.bmp; *.png',
			data: true,
			display: config.display || '',
			callback: { 
				method: config.method || 'imageUpload', 
				imageCell: config.imageCell || '#imagecell', 
				nameField: config.nameField || '"#imagename', 
				maxImages: config.maxImages 
			}
		};
	
	// We use the Deferred object within the 'Uploadify' script to tell us when Uploadify has loaded
	jQuery.when(uploadify.upload()).then(function(fn){
		fn(settings);
	});
});