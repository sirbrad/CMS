define(['jquery', 'Utils/getEl', 'Utils/elementSibling', 'Utils/prepareElement', 'Utils/modal'], function(jQuery, getId, es, prepare, modal) {
	
	
	
	/*var container = getId('pageList'),
		checkboxes = container.getElementsByTagName('input'),
		len = checkboxes.length,
		btn = getId('btn'),
		arr = [];
		
	
	// Need to check if input is checked on load. Firefox
	// decides to keep inputs checked on reload
	jQuery(container).bind('click', function(e){
		var targ = e.target,
			superParent;
		
		len = checkboxes.length;
		
		// Annoying problem: Because we a re using a label, the click
		// event gets initiated twice. Dur. This simple check lets us
		// skip the event being shouted from the label.
		if (targ.tagName.toLowerCase() === 'input') {
			
			superParent = targ.parentNode.parentNode.parentNode;
			
			if (targ.checked) {
				superParent.className = 'prepare';
			} else {
				superParent.className = '';
			}
			
			
			// If user indicates they wish to delete 1 or more list items
			// un-disable submit button.
			while (len--) {
				if (checkboxes[len].checked) {
					btn.removeAttribute('disabled');
					break;
				} else {
					btn.setAttribute('disabled', 'disabled');
				}
			}
			
		}
		
		
		
	});
	
	jQuery(btn).bind('click', function(e){
		var lis = container.getElementsByTagName('li'),
			liLen = lis.length;
			
		// Must make sure arr is reset each click
		arr = [];
			
		while (liLen--) {
			
			if (lis[liLen].className === 'prepare') {
				arr.push(lis[liLen].children[0].children[0]);	
			}
		}
		
		modal({
			title: 'Confirm',
			message: 'Are you sure you wish to <strong>delete</strong> the following pages;',
			items: arr
		});
		
		//this.setAttribute('disabled'); // need this if we dont overlay a darken bkg
	
		e.preventDefault();	
	});*/
	
});