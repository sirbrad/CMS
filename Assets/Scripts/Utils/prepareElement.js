define(function(){
	
	
	var container = document.getElementsByTagName('form');
	
	jQuery(container).bind('click', function(e){
		var targ = e.target,
			input = this.getElementsByTagName('input'),
			len = input.length,
			superParent,
			btn,
			checkOptions;
		
		// Work out and store our submit btn
		while (len--) {
			if (input[len].type === 'submit') {
				btn = input[len];
			}
			
			if (input[len].checked) {
				btn.removeAttribute('disabled');
				break;
			} else {
				btn.setAttribute('disabled', 'disabled');
			}
		}
		
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