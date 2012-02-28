define(['jquery', 'Utils/getEl', 'Utils/elementSibling'], function(jQuery, getId, es) {
	
	var container = document.forms[0];
	
	
	
	function swap(elem) {
		
		var parent = elem.parentNode,
			superParent = parent.parentNode,
			nextElem = (es.nextElementSibling(parent)) ? nextElem = es.nextElementSibling(parent) : nextElem = es.prevElementSibling(parent),
			height;
			
		superParent.style.minHeight = parent.clientHeight + 'px';
		
		
		console.log(superParent)
		
		// We need to just jQuery to calculate the
		// height of a hidden element.
		height = jQuery(nextElem).height() + 'px';
		/*nextElem.style.height = '0px';
		nextElem.style.display = 'block';*/
		
	
		
			
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