define( function() {
	/*
	 * Required features:
	 * 		addEventListener (Google Chrome 1+, FF 1+, IE 9+, Opera 7+, Safari 1+)
	 * 		FileReader (Google Chrome 7+, FF 3.6+, IE 10+)
	 *		FormData (Google Chrome 7+, FF 4+, Safari 5+)
	 */
	var formdata, link, input, doc = document, imgPreview = doc.getElementById("img-preview");
	
	if (("addEventListener" in window) && ("FileReader" in window) && ("FormData" in window)) {
		init();
	} else {
		alert("This demo wont work for you, sorry - please upgrade your web browser");
		document.getElementById("browsers").style.display = "block";
	}

	function init() {
		
		formdata = new FormData()
		
		link = doc.getElementById("file-upload-link"),
		input = doc.getElementById("file-upload");

		// Now we know the browser supports the required features we can display the 'browse' button
		link.style.display = "inline-block";
	
		link.addEventListener("click", process, false);
		input.addEventListener("change", displaySelectedFiles, false);
	}

	function process (e) {
		// If the input element is found then trigger the click event (which opens the file select dialog window)
		if (input) {
			input.click();
		}
		
		e.preventDefault();
	}

	function displaySelectedFiles(){
		// Once a user selects some files the 'change' event is triggered (and this listener function is executed)
		// We can access selected files via 'this.files' property object.
		
		var img, reader, file, clearFiles = doc.getElementById("clear-files"), confirmUpload = doc.getElementById("upload-files");
		
		for (var i = 0, len = this.files.length; i < len; i++) {
			file = this.files[i];
			
			if (!!file.type.match(/pdf.*/)) {
				
				if (window.FileReader) {
					
					reader = new FileReader();
					
					reader.onloadend = function (e) { 
						
					};
					
					reader.readAsDataURL(file);
				} 
				
				

				if (formdata) {
					/*
						The append method simply takes a key and a value. 
						In our case, our key is images[]; 
						By adding the square-brackets to the end, we make sure each time we append another value, 
						we're actually appending it to that array, instead of overwriting the image property.
					 */
					formdata.append("files[]", file);
					// Display the files as they come in...
					createFileDisplay('',file);
					
				}
				
				
				
			} 
		}
		// Take in the finished away and save and move the files
		uploadFiles(file);
		
	} 


	var progressBar = (function(){
		var bar = doc.createElement("div"),
			progress = doc.createElement("div"),
			container = doc.getElementById("file-upload-link");

		bar.id = "bar";
		progress.className = "progress";
		progress.setAttribute("data-percentage", "0%");
		
		container.parentNode.insertBefore(bar, container);
		bar.appendChild(progress);
		

		return function (percentage) {
			progress.setAttribute("data-percentage", percentage + "%");
			progress.style.width = (percentage * 2) + 'px';
		}
	}());

	function createFileDisplay(response,file) {
		
		var fileArea = doc.getElementById("filearea"),
			fileContent = document.createElement('div')
			response = response.split(';');
					  
		fileContent.innerHTML = '<p>' +
						'<input type="hidden" name="att_name[]" value="' + response[0] + '" />' +
						'<input type="text" name="att_title[]" value="' + file.fileName + '" class="att_title" />'  +
					  '</p>';
					 
					  	  
		fileArea.appendChild(fileContent);
	}
	
	function uploadFiles(files){
		
		var xhr = new XMLHttpRequest();
		
		function progressListener (e) {
			//console.log("progressListener: ", e);
			if (e.lengthComputable) {
				var percentage = Math.round((e.loaded * 100) / e.total);
				progressBar(percentage);
				//console.log("Percentage loaded: ", percentage);
			}
		};

		function finishUpload (e) {
			progressBar(100);
			//console.log("Finished Percentage loaded: 100");
		};

		// XHR2 has an upload property with a 'progress' event
		xhr.upload.addEventListener("progress", progressListener, false);

		// XHR2 has an upload property with a 'load' event
		xhr.upload.addEventListener("load", finishUpload, false);

		
		// Begin uploading of file
		xhr.open("POST", "/GitHub/CMS/AJAX_file_uploader");

	    xhr.onreadystatechange = function(e){
	    	console.info("readyState: ", this.readyState);
			
	    	if (this.readyState == 4) {
				
	      		if ((this.status >= 200 && this.status < 300) || this.status == 304) {
					 
	        		if (this.responseText != "") {
						// Not sure what to do here now i've done everything I need to do
					}
				}
			}
		};

		xhr.send(formdata);
		
		// This seems like a massive hack.
		// By resetting the form data we don't consistently keep
		// adding the already uploaded files.
		formdata = new FormData();
		
	}// JavaScript Document
	
});