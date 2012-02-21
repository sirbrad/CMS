define(function(){
	
	var frag = document.createDocumentFragment(),
		modalwindow = document.createElement('div'),
		title = document.createElement('p'),
		module = document.createElement('div'),
		list = document.createElement('ol'),
		editOpts = '<ol class="hoz btns"><li><a href="#" class="btn f-btn">Cancel</a></li><li><a href class="btn e-btn err-btn">Confirm</a></li></ol>',
		len;
	
	
	// Create attributes
	modalwindow.className = 'modal';
	title.className = 'heading gradbar';
	module.className = 'module cf';
	list.className = 'list';
	
	
	modalwindow.appendChild(title);
	modalwindow.appendChild(module);
	
	
	function show() {
		document.body.appendChild(modalwindow);	
	}
	
	
	return function showModal(opts) {
		
		
		
		console.log(opts)
		
		title.innerHTML = opts.title;
		module.innerHTML = '<p>' + opts.message + '</p>' +  editOpts;
		
		show();
		
		
		
		
		
		
		
		
		
		
		//len = opts.items.length;
		
		/*while (len--) {
			list.innerHTML = '<li>' + opts.items[len].innerHTML + '</li>';
		}
		
		console.log(list)*/
		
		/*for (var i = 0; i < opts.items.length; i++) {
			listItems = '<li>' + opts.items[i].innerHTML + '</li>';
			jQuery(list).append(listItems);
		}
		
		
		title.innerHTML = opts.title;
		module.innerHTML = '<p>' + opts.message + '</p>' + list.innerHTML +  editOpts;
		
		console.log(list)
		
		document.body.appendChild(modalwindow); */
		
		
	};
	
	
	
	
});