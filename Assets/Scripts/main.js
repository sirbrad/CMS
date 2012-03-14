require.config({ 
	paths: {
		jquery: 'Utils/jquery',
		tpl: 'Plugins/tpl'
	}
});

require(['manageElements']);

var admin_editor = { editor: ".wysiwyg" };

require(['require', 'Utils/getEl'], function(require, getId){
	
// Check for 'ckeditor' component
	if (getId('wysiwyg')) {
		
		
		
		// CKEDITOR_BASEPATH is a global variable
		this.CKEDITOR_BASEPATH = '/GitHub/CMS/Assets/Scripts/Utils/ckeditor/';
		
		require(['Utils/ckeditor/ckeditor'], function(){
			require(['Utils/ckeditor/ckeditor-module']);
		});
	}
	
	if (getId('upload')) {
		require(['upload']);
	}
	
	if (getId('file-upload')) {
		require(['upload-files']);
	}
	
});