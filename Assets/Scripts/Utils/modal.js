define(['require', 'jquery', 'Utils/getDocHeight', 'Utils/getAppliedStyle'], function(require, jQuery, docHeight, appliedStyle){
	
	var frag = document.createDocumentFragment(),
		overlay = document.createElement('div');
		elem = document.createElement('div'),
		bod = document.body;
	
	overlay.className = 'overlay';
	// Set height
	overlay.style.height = docHeight() + 'px';
	
	elem.className = 'modal';
	elem.id = 'modal';
	elem.setAttribute('data-animation', 'fadein');
	
	function show() {
		
		
		frag.appendChild(overlay);
		frag.appendChild(elem);
		
		// Append frag to our body
		bod.appendChild(frag);
	}
	
	function hide() {
		
		elem.setAttribute('data-animation', 'fadeout');
		bod.removeChild(overlay);
		
		
		// Need to remove element from document.
		//appliedStyle(elem, 'opacity');
	}
	
	jQuery(overlay).bind('click', function(e){
		
		
		hide();
	});
		
	
	return function(opts) {
		
		require(['tpl!Templates/modal.tpl'], function(template){
				var modalOptions = template({ 
					title: opts.title,
					message:opts.message 
				})
				
				elem.innerHTML = modalOptions;
				
				// Display our modal
				show();
		});
		
		
	};
	
	
	
	
});