$(function () {
 var roxyFileman = '/assets/backend/fileman/index.html'; 
        var config = {

    codeSnippet_theme: 'Monokai',
    language: 'fr',
    height: 800,
    // filebrowserBrowseUrl: '/assets/backend/filemanager/index.html',
    filebrowserBrowseUrl: roxyFileman,
    filebrowserImageBrowseUrl:roxyFileman+'?type=image',removeDialogTabs: 'link:upload;image:upload',
   
    toolbar : [
    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
    { name: 'paragraph', items: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] },
    { name: 'document', items: ['Source'] },
    { name: 'links', items: [ 'Link', 'Unlink' ] },
    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule' ] },
    { name: 'styles', items: [ 'Styles', 'Format', 'my_styles'] },
    // { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
    { name: 'others', items: [ '-' ] }      
    ]
};

CKEDITOR.replace( 'content', config);
	});