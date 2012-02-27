define(['jquery', 'Utils/getEl', 'Utils/elementSibling', 'Utils/modal'], function(jQuery, getId, es, modal) {
	
	
	var container = [],
		superParent,
		btn,
		len; 
		
		
	// Need to loop through and distinguish whether our container is within
	// a form or a div. Reason being we noticed that in some errors it wasn't
	// sufficient to have the user submit multiple forms to update what would be
	// 1 page.
	
	var forms = document.getElementsByTagName('form'),
		divs = document.getElementsByTagName('div');
		
	(function searchElements(elem) {
		
		len = elem.length;
		
		
		while (len--) {
			
			if (elem[len].getAttribute('data-module')) {
		
				container.push(elem[len]);
				
			} else {
				
				if (elem[len].tagName.toLowerCase() === 'form') {
					searchElements(divs);
				} 
			}
		}
		
		// Had to reset len??
		len = 0;
		
		
	}(forms));
	
	
	// Highlight current element
	function highlight(elem) {
		
		superParent = elem.parentNode.parentNode.parentNode;
		superParent.className = elem.checked ? 'prepare' : '';
		
	}
	
	(function(){
		
		for (var i = 0; i < container.length; i++) {
			
			var inp = container[i].getElementsByTagName('input'),
				inputLen = inp.length;
			
			while (inputLen--) {
				
				if (inp[inputLen].type === 'checkbox') {
					highlight(inp[inputLen]);
				}
			}
			
		}
		
	}());
	
	
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
			
			if (btn) {
			
				if (input[len].checked) {
					
					btn.removeAttribute('disabled');
					break;
				} else {
					btn.setAttribute('disabled', 'disabled');
				}
			}
			
			
		}
		
		
		// Check the user has interacted with our input
		if (targ.tagName.toLowerCase() === 'input' && targ.type === 'checkbox') {
			highlight(targ);
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