define(['jquery'], function($){
	
	// this = [object DOMWindow]
	var global = this;

	// Apply to the selector specified via 'editor' property
	// or if none supplied fallback to any <textarea> elements in the page
	$(global.admin_editor.editor || 'textarea').each(function(){
	
		var objectID = this.id;

		global.CKEDITOR.replace(objectID, {
			height: global.admin_editor.height || '210', 
			width: global.admin_editor.width || '605',
			filebrowserImageUploadUrl: '/ckupload/?width=150&thumbwidth=150',
			filebrowserBrowseUrl: '/Assets/Scripts/Utils/filemanager/',
			forcePasteAsPlainText: true,
			resize_enabled: false,
			uiColor: '#eee',
			format_tags:'p;h1;h2',
			contentsCss:'/GitHub/CMS/Assets/Styles/ck-editor.css',
			toolbar: global.admin_editor.ui || [['Format','-','Bold','Italic','-','NumberedList','BulletedList','HorizontalRule','-','Link','Unlink', 'Source']]
		});
	
	});
	
});