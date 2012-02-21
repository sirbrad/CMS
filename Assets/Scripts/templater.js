require.config({ 
	paths: { 
		tpl: 'Plugins/tpl'
	} 
}); 
  
/*
	Instead of using define() to wrap our code, we use require(). 
	
	The require() function is similar, in that you pass it an optional array of dependencies, 
	and a function which will be executed when those dependencies are resolved. 
	However this code is not stored as a named module, as its purpose is to be run immediately.
*/

require(['tpl!Templates/modal.tpl'], function(template, getId) {
	//document.body.innerHTML += template({ world: 'Bob!' });
	
	var container = document.getElementById('modal');
		//test  = container.children[0];
		
		console.log(container)
	
	container.innerHTML += template({ title: 'Bob!' }); 
	
});