define(['Utils/getEl', 'Utils/jquery'], function( getEl ) {
	
	
	function get_form () {
		var form = document.forms.form;
		return form;
	}
	
	// Handles the users selection
	function selection_handler(e) {
		
		// Get the file selection
		var files = e.target.files || e.dataTransfer.files;
		
		jQuery('#ajax-loader').fadeIn();
		
		// Loop through because there could possibly be a number of selection
		for (var i = 0, f; f = files[i]; i++) {
			file_parser(f);
		}
		
		//Hide the ajax loader once done.
		jQuery('#ajax-loader').fadeOut();
		

	}
	
	// Displays the image to the user
	function display_image(msg) {
		
		var img = getEl("img-preview");
		
		// This is aload of bollucks - I was trying to make an effect
		// but it just jumps straight to displaying
		jQuery(img).hide();
		
		jQuery(img).fadeIn( 'fast', function() {
		
			jQuery(img).html(msg);	
			
		});
				
		
	}
	
	// Parses the file to the page
	function file_parser(file) {
		
		// Check to see if it's an image
		if ( file.type.indexOf("image") == 0 ) {
			
			
			
			if ( file.type == 'image/jpg' || file.type == 'image/png' || file.type == 'image/jpeg' || file.type == 'image/gif' ) {
				
				// Read the image
				var r = new FileReader();
				
				
				
				// On load we display the user the image
				r.onload = function(e) { 
					
					// Call to display image function
					display_image(
					
						'<img src="' + e.target.result + '" />'
					);
					
					// Set the hidden imagename field to the image name.
					// This allows us to save the name - unfortunately will have to make a seperate call
					// to the Server-side upload file.
					form = get_form();
					form.imagename.value = file.name;
					
				}
				// Reads the file - without this the image doesn't display
				r.readAsDataURL(file);
				
			} 
			
		} else {
			display_image( '<p>Incorrect file type</p>' );
			return false;	
		}
			
	}
	
	// Deletes the image from the page
	function tackle_image () {
		
		jQuery('#del-image').click(function(e) { 
			
			var agree = confirm( "Are you sure you want to delete this image?" );
			if(agree){
				form = get_form();
				form.imagename.value = '';
				jQuery('#img-preview').html('');
			} else {
				return false;	
			}
			e.preventDefault();	
		});
		
		return this;	
	}
	
	
	// Initialization function
	function initialize() {
		
		var file_section = getEl("fileselect");
		
		// Upon selection, we display handle the 'uploading'
		jQuery(file_section).change( function(e) {
			
			selection_handler(e);
			
		});
		
		// Handles the 'deletion' if prompted
		tackle_image();

	}
	

	// Initialise the uploader
	if (window.File && window.FileReader) {
		initialize();
	}

	
});