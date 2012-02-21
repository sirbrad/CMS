define(['Utils/getEl', 'Utils/jquery'], function(getId) {
	
	var image = getId('image'),
		imageLocation = jQuery(image).offset(),
		settings = {
			
			cropperWidth: 10,
			cropperHeight: 10,
			
			imageWidth: image.clientWidth,
			imageHeight: image.clientHeight,
			minWidth: 10,
			minHeight: 10,
			
			element: document.createElement('div'),
			cropArea: document.createElement('div'),
			
			overlays: { // All of the overlays (creating the effect of a darkened image
				north: document.createElement('div'),
				south: document.createElement('div'),
				east: document.createElement('div'),
				west: document.createElement('div')
			},
			handles: { // The handles for resizing
				n: document.createElement('div'),
				s: document.createElement('div'),
				e: document.createElement('div'),
				w: document.createElement('div'),
				ne: document.createElement('div'),
				nw: document.createElement('div'),
				se: document.createElement('div'),
				sw: document.createElement('div'),
			},	
		},
		cropperWrapper = document.createElement('div'),
		dragger = document.createElement('div'),
		clickArea = document.createElement('div'),
		imageElement = jQuery(image).clone();
		
		jQuery(cropperWrapper).addClass('cropper-wrap');
		jQuery(image).append(cropperWrapper);
		
		jQuery(dragger).addClass('cropper-dragger');
		
		jQuery(settings.cropArea).css( 'width', settings.minWidth+'px',
									   'height', settings.minHeight+'px',
									   'display', 'none');
									   
		jQuery(settings.cropArea).html( '<div class="ui-cropper-marquee-horizontal ui-cropper-marquee-north"><span></span></div>\
									     <div class="ui-cropper-marquee-vertical ui-cropper-marquee-east"><span></span></div>\
										 <div class="ui-cropper-marquee-horizontal ui-cropper-marquee-south"><span></span></div>\
										 <div class="ui-cropper-marquee-vertical ui-cropper-marquee-west"><span></span></div>' );
	
		for(var pos in settings.handles) {
			
			jQuery(settings.handles[pos]).addClass('ui-cropper-handle ui-cropper-handle'+pos.toUpperCase());
			
			jQuery(settings.cropArea).append(settings.handles[pos]);
			
		}
		document.body.focus();
		document.onselectstart = function () { return false; };
		settings.cropArea.ondragstart = function() { return false; };
		
		jQuery(cropperWrapper).mousedown(function(){
			console.log(21313);
		});
		
	
})