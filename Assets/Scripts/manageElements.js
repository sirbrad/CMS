define(['jquery', 'Utils/getEl', 'Utils/elementSibling', 'Utils/modal'], function(jQuery, getId, es, modal) {
	
	
	var container = document.getElementsByTagName('form'),
		superParent,
		btn; 
	
	
	jQuery(container).bind('click', function(e){
		var targ = e.target,
			input = this.getElementsByTagName('input'),
			len = input.length,
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
		if (targ.tagName.toLowerCase() === 'input' && targ.type === 'checkbox') {
			
			superParent = targ.parentNode.parentNode.parentNode;
			
			superParent.className = targ.checked ? 'prepare' : '';
			
			
		}
		
		if (targ.getAttribute('data-modal')) {
			
			modal({
				title: 'Confirm',
				message: 'Are you sure you wish to <strong>delete</strong> the following pages;'
			}, this);
			
			
			e.preventDefault();
		}
	});
	
});