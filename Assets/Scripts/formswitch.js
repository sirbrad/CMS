define(['jquery', 'Utils/getEl', 'Utils/elementSibling'], function(jQuery, getId, es) {
	
	var container = document.forms[0];
	
	// Set the containing form's padding top
	// to be the height of the first div
	
	//container.style.paddingTop = container.children[0].clientHeight +'px';
	
	
	
	function swap(elem) {
		
		var parent = elem.parentNode,
			superParent = parent.parentNode,
			nextElem = (es.nextElementSibling(parent)) ? nextElem = es.nextElementSibling(parent) : nextElem = es.prevElementSibling(parent),
			height;
			
		//superParent.style.maxHeight = parent.clientHeight + 'px';
		
		
		
		// We need to just jQuery to calculate the
		// height of a hidden element.
		height = jQuery(nextElem).height() + 'px';
		
		
		
		
		
		
		
		
		
		
		
		/*parent.className = 'moveoff';
		jQuery(superParent).animate({minHeight: height}, 300)
		
		nextElem.
		nextElem.className = 'movein';*/
		
	
		
			
		/*jQuery(parent).animate({
			height: 0,
			opacity:0
		}, 300, function() {
			this.className = 'hide-elem';
			this.style.height = 'auto';	
		});
		jQuery(nextElem).animate({
			height: height,
			opacity:1	
		}, 300, function() {
			this.className = '';	
		});
		*/	
			
		
	};
	
	
	
	
	// Events
	jQuery(container).bind('click', function(e){
		
		var targ = e.target;
		
		if (targ.getAttribute('data-login')) {
			
			swap(targ);
			
			e.preventDefault();
		}
		
		
	});
	
	
	
	
});