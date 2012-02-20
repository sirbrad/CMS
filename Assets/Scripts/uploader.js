define(['Utils/getEl', 'Utils/jquery'], function( getEl ) {
	
	function selection_handler(e) {

		var files = e.target.files || e.dataTransfer.files;
		
		for (var i = 0, f; f = files[i]; i++) {
			file_parser(f);
			uploader(f);
		}
		

	}
	
	function output(msg) {
		
		var m = getEl("img-preview");
		m.innerHTML = msg + m.innerHTML;
		
	}
	
	function file_parser(file) {
		
		
		// Check to see if it's an image
		if ( file.type.indexOf("image") == 0 ) {
			
			var r = new FileReader();
			
			r.onload = function(e) { 
				output(
					"<p><strong>" + file.name + ":</strong><br />" +
					'<img src="' + e.target.result + '" /></p>'
				);
			}
			
			r.readAsDataURL(file);
		}
			
	}
	
	function uploader (file) {
		
		var xhr = new XMLHttpRequest();
		
		if (xhr.upload) {
			
			var res = 'null';
			
			// start upload
			xhr.open("POST", '/GitHub/CMS/AJAX_uploader' , true);
			
			var contentType = "multipart/form-data";
			
    		xhr.setRequestHeader("Content-Type", contentType);
			
			xhr.send(file);
			
			console.log(xhr.responseText);
			//jQuery('#img-preview').html(res);
			
			
		}
			
	}
	
	// initialize
	function Init() {

		var file_section = getEl("fileselect");
			
		jQuery(file_section).change( function(e) {
			
			selection_handler(e);
			
		});

	}

	// call initialization file
	if (window.File && window.FileReader && window.FileList && window.Blob) {
		Init();
	}

	
});