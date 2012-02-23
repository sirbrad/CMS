define(['require', 'jquery', 'Utils/getDocHeight', 'Utils/getAppliedStyle', 'Utils/getEl'], function(require, jQuery, docHeight, appliedStyle, getId){
	
	var frag = document.createDocumentFragment(),
		overlay = document.createElement('div');
		elem = document.createElement('div'),
		bod = document.body,
		cancel = getId('cancel');
	
	overlay.className = 'overlay';
	// Set height
	overlay.style.height = docHeight() + 'px';
	
	elem.className = 'modal';
	elem.id = 'modal';
	elem.setAttribute('data-animation', 'fadein');
	
	function showWindow() {
		
		overlay.appendChild(elem);
		frag.appendChild(overlay);
		
		// Append frag to our body
		bod.appendChild(frag);
		
		cancel = getId('cancel');
	}
	
	function closeWindow() {
		
		overlay.setAttribute('data-animation', 'fadeout');
		
		// Poll until our element has 0 opacity
		var timer = setInterval(function(){
			
			// As soon as our element has zero opacity we remove
			// it from the document and then clear interval
			if (appliedStyle(overlay, 'opacity') <= 0) {
				
				document.body.removeChild(overlay);
				
				// Reset attribute
				overlay.setAttribute('data-animation', 'null');
				
				clearInterval(timer);
			}
			
		}, 10);
		
		//console.log(appliedStyle(overlay, 'opacity'))
	}
	
	
	// Events to close window
	jQuery(overlay).bind('click', function(e){
		var targ = e.target;
		
		if (targ.href.split('#')[1] === 'confirm') {
			
			console.log(document.form)
			
		}
		
		e.preventDefault();
		
	});
	
	return function(opts) {
		
		require(['tpl!Templates/modal.tpl'], function(template){
			var modalOptions = template({ 
				title: opts.title,
				message:opts.message 
			})
			
			elem.innerHTML = modalOptions;
			
			// Display our modal
			showWindow();
		});
		
		
	};
	
	
	
	
});