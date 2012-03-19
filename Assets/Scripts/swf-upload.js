define(['require'], function(require){
	
	var imageCount = 0,
		config = ''
		sitePath = '/GitHub/CMS/';
		
	function preComplete(event, queueID, fileObj, response) {
		
		var response_split = response.split(";");
		
		//Switch determine what method to take.
		switch(config.method) {
			
			case 'imageUpload':
				$(config.imageCell).html(response_split[0]);
				$(config.nameField).val(response_split[1]);
				$("#crop").hide();
			break;
			
			case 'imageUploadMulti':
				if(!!config.callback.maxImages && imageCount == config.callback.maxImages) { 
					alert("You have already attached the maximum number of images to this page"); 
				} else {
					imageCount++;
					$(config.callback.imageCell).append('<div class="imgthumb">' +
					response_split[0] +
					'<input type="hidden" name="imagename[' + imageCount + ']" id="image' + imageCount + '" value="' + response_split[1] + '" />' +
					'<input type="button" value="Delete Image" class="delete_image" />' +
					'</div>');
				};
			break;
		};
		
		
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