define(function(){
	
	
	var container = document.getElementsByTagName('form');
	
	
	jQuery(container).bind('click', function(e){
		var targ = e.target,
		superParent;
		
		// Check the user has interacted with our input
		if (targ.tagName.toLowerCase() === 'input') {
			
		
			superParent = targ.parentNode.parentNode.parentNode;
			
			if (targ.checked) {
				superParent.className = 'prepare';
			} else {
				superParent.className = '';
			}
		}
		
	});
	
});