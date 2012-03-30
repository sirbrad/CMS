require.config({ 
	paths: {
		jquery: 'Utils/jquery'
	}
});

require(['require', 'Utils/getEl'], function(require, getId){
	
	// this = [object DOMWindow]
		
	if (getId('login')) {
		require(['login', 'placeholder']);
	}
	/*
	if (!getId('login')) {
		require(['dropdown']);
	}*/
	
	if (getId('deleteBtn')) {
		require(['confirm-delete']);
	}
	
	if (getId('adding_credits')) {
		require(['handle-credits']);
	}
	
	if (getId('adding_links')) {
		require(['handle-links']);
	}
	
	// Check for 'ckeditor' component
	if (!!this.admin_editor) {
		// CKEDITOR_BASEPATH is a global variable
		this.CKEDITOR_BASEPATH = '/Assets/Scripts/Utils/ckeditor/';
		
		require(['Utils/ckeditor/ckeditor'], function(){
			require(['Utils/ckeditor/ckeditor-module']);
		});
	}
	
	// Check for 'datepicker' component
	var form = getId('form'),
		datepicker = form && form.getElementsByTagName('input'),
		dpLength = datepicker && datepicker.length;
	while(dpLength--) {
		if (datepicker[dpLength].className === 'datepicker') {
			require(['datepicker']);
			break;
		}
	}
	
	// Check for 'uploadify' component (image variation)
	if (!!this.admin_images) {
		require(['uploadify-images']);
		if ( !!this.admin_images[1] ) {
			require(['uploadify-thumbimage']);
		}
	}
	
	// Check for 'uploadify' component (document variation)
	if (!!this.admin_documents) {
		require(['uploadify-documents']);
	}
	
	if (!!this.admin_filter) {
		require(['filter-listing']);
	}
	
	// Check for 'sortable' component
	var form = getId('form'),
		sortables = form && form.getElementsByTagName('ul'),
		sLength = sortables && sortables.length;
	while(sLength--) {
		if (sortables[sLength].className === 'sortable') {
			require(['sortable']);
			break;
		}
	}
	
});
