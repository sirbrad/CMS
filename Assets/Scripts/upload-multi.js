define( ['require', 'jquery'], function(require, $) {
	/*
	 * Required features:
	 * 		addEventListener (Google Chrome 1+, FF 1+, IE 9+, Opera 7+, Safari 1+)
	 * 		FileReader (Google Chrome 7+, FF 3.6+, IE 10+)
	 *		FormData (Google Chrome 7+, FF 4+, Safari 5+)
	 */
	var formdata, link, input, doc = document, imgPreview = doc.getElementById("img-preview"), _path = '/GitHub/CMS', imgCount = 0, imgMax = 5;
	
	if (("addEventListener" in window) && ("FileReader" in window) && ("FormData" in window)) {
		init();
	} else {
		//alert("This demo wont work for you, sorry - please upgrade your web browser");
		//document.getElementById("browsers").style.display = "block";
		require(['uploadify-images']);
		return false;
	}

	function init(){
		formdata = new FormData()
		
		link = doc.getElementById("upload-link"),
		input = doc.getElementById("upload");

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
		
			if (!!file.type.match(/image.*/)) {
				if (window.FileReader) {
					reader = new FileReader();
					reader.onloadend = function (e) { 
						
						//createImage(e.target.result, e);
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
					formdata.append("images[]", file);
				}
				
			} 
			uploadFiles();
		}
		
		
		
	} 

	function createImage (path, img, fileobj) {
		
		var imageList = doc.getElementById("image-list"),
			imageContent = document.createElement('div');
					  
		imageContent.innerHTML = '<div id="img_'+img+'"><span class="img"><img src="'+ path+img +'"></span><input type="button" id="'+img+'" class="btn  e-btn del-image" value="Delete Image"></div>';
		
		imageList.appendChild(imageContent);
	}

	var progressBar = (function(){
		
		var bar = doc.createElement("div"),
			progress = doc.createElement("div"),
			container = doc.getElementById("upload-link");

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

	function uploadFiles(){
		
		var xhr = new XMLHttpRequest();
		
		function progressListener (e) {
			if (e.lengthComputable) {
				var percentage = Math.round((e.loaded * 100) / e.total);
				progressBar(percentage);
			}
		};

		function finishUpload (e) {
			progressBar(100);
		};

		// XHR2 has an upload property with a 'progress' event
		xhr.upload.addEventListener("progress", progressListener, false);

		// XHR2 has an upload property with a 'load' event
		xhr.upload.addEventListener("load", finishUpload, false);

		
		// Begin uploading of file
		xhr.open("POST", "/GitHub/CMS/AJAX_uploader");

	    xhr.onreadystatechange = function(e){
			
	    	console.info("readyState: ", this.readyState);
			
	    	if (this.readyState == 4) {
				
	      		if ((this.status >= 200 && this.status < 300) || this.status == 304) {
	        		if (this.responseText != "") {
						
						// Display the image and set the hidden fields
						var resp = xhr.responseText.split(';'),
							path = resp[0],
							img = resp[1]
							form = document.forms.form,
							imgfield = form.imgname;
							
						imgCount++;
						
						if ( imgCount <= imgMax ) {
							
							createImage(path, img, e);
							img = img+";";
							imgfield.value = img+imgfield.value;
							
						} else {
							alert ( "You have uploaded the maximum amount of images" );
							return false;
						}
					}
				}
			}
		};

		xhr.send(formdata);
		
	}// JavaScript Document
	
});