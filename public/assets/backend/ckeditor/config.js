/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	//config.filebrowserBrowseUrl = '/bassaka_air/public/assets/backend/ckfinder/ckfinder.html';
	config.filebrowserBrowseUrl = 'http://tbcccambodia.localhost:81/assets/backend/fileman/index.html?integration=custom&type=files&txtFieldId=txtSelectedFile';
	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,RemoveFormat,Language,BidiRtl,BidiLtr,CreateDiv,Flash,PageBreak,Maximize,ShowBlocks,About,Form,Checkbox,Radio,TextField,ImageButton,Button,Select,Textarea,HiddenField';

};