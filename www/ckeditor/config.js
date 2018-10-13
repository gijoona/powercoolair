/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ko';
	// config.uiColor = '#AADC6E';
	config.enterMode = 2; // <br/>
	config.removePlugins = 'save,forms,pagebreak,find,pastefromword,scayt';
	config.toolBarGroups = [
			              	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			              	//{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			              	//{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
			              	{ name: 'insert' },
			              	//{ name: 'forms' },
			              	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			              	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
			              	{ name: 'links' },
			              	'/',
			              	{ name: 'styles' },
			              	{ name: 'colors' },
			              	{ name: 'tools' },
			              	{ name: 'others' },
			              	{ name: 'about' }
			              	];
	config.toolbar = [
	                  { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'NewPage', 'Preview', 'Print' ] },
	                  //{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	              	  //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	              	  { name: 'insert', items: [ 'AdResource', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar' ] },
	              	  { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	              	  { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	              	  { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	              	  '/',
	              	  { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	              	  { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	              	  { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	              	  { name: 'others', items: [ '-' ] },
	              	  { name: 'about', items: [ 'About' ] }
	              	  ];
};
CKEDITOR.editorConfig = function( config ) {
    config.filebrowserUploadUrl = '/upload/upload.php'
};
