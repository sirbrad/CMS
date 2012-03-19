define(['require'], function(require){
	
	var imageCount = 0,
		config = ''
		sitePath = '/GitHub/CMS/';
		
	function preComplete(event, queueID, fileObj, response) {
		
		var resp = response.split(';'),
			path = resp[0],
			img = resp[1],
			form = document.forms.form,
			imgfield = form.imgname,
			imageList = document.getElementById("image-list");
			
		imageContent = document.createElement('div');
		
		imageContent.innerHTML = '<div id="img_'+img+'"><span class="img"><img src="'+ path+img +'"></span><a href="'+sitePath+'/cropper/'+img+'" class="btn f-btn">Crop</a><input type="button" id="'+img+'" class="btn del-image" value="Delete Image"></div>';		
		imageList.appendChild(imageContent);
			
		img = img+";";
		
		imgfield.value = img+imgfield.value;
		
	};
	
	// Because Uploadify relies on swfobject we need to make sure swfobject is loaded first (otherwise there will be reference errors)
	// So we use the Promises/Deferred api which help specifically with asynchronous loading issues like this
	function loadUploadify() {
		
		var dfd = jQuery.Deferred();
		
		require(['Utils/Uploadify/uploadify'], function(){
			
			// The 'resolve' method informs the 'Promise' that our asynchronous action is complete
			// We then pass through a function to 'resolve' which is passed onto the handler function (see $.when().then() within 'uploadify-images'/'uploadify-documents')
			dfd.resolve(function(settings) {
				
				jQuery(settings.uploader).uploadify({
					'buttonText': settings.buttonText,
					'uploader': sitePath+'/Assets/Scripts/Utils/Uploadify/uploadify.swf',
					'script': settings.script,
					'cancelImg': sitePath+'/Assets/Scripts/Utils/Uploadify/cancel.png',
					'scriptData': { 
						'width': settings.width, 
						'height': settings.height, 
						'thumbwidth': settings.thumb_width, 
						'thumbheight': settings.thumb_height, 
						'display': settings.display 
					},
					'queueID': settings.fileQueue,
					'fileDesc': settings.fileDesc,
					'fileExt': settings.fileExt,
					'auto': true,
					'multi': (settings.callback.method === 'docUploadMulti' || settings.callback.method === 'imageUploadMulti') ? true : false,
					'onComplete': preComplete
					
				});
				
				config = settings.callback;
				
			});
			
		});
		
		return dfd.promise();
		
	}
	
	return {
		
		imageCount: imageCount,
		upload: loadUploadify // because uploadify is loaded (asynchronously) at a later stage, we use a Deferred object to return the relevant function when the script is loaded
		
	};
		
});