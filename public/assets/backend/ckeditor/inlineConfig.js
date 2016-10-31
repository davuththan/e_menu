$(function () {
 $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });
        var roxyFileman = '/assety/fileman/dev.html';
        var config = {

    codeSnippet_theme: 'Monokai',
    language: 'fr',
    height: 800,
    // filebrowserBrowseUrl: '/assety/filemanager/index.html',
   filebrowserBrowseUrl:roxyFileman,
    filebrowserImageBrowseUrl:roxyFileman+'?type=image',
    removeDialogTabs: 'link:upload;image:upload',
    toolbar : [
    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
    { name: 'document', items: ['Source'] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
    { name: 'paragraph', items: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] },
    { name: 'links', items: [ 'Link', 'Unlink' ] },
    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule' ] },
    { name: 'styles', items: [ 'Styles', 'Format', 'my_styles'] },
    // { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
    { name: 'others', items: [ '-' ] }
    ],
        on: {
             blur: function() {
                // alert(window.location.href );
                // console.log(window.location.host);
                if(window.location.host=='acseh4.dev'){ var urldepart ='http://acseh4.dev';} else {var urldepart ='http://acseh.dragaly.com';}
                 var section = $("input[name=section]").val();
                 var details = $("textarea[name=details]").val();
                 var dataString = "section=" + section + "&details=" + escape(editor.getData());
                 $.ajax({
                     type: "POST",
                     url: urldepart+"/tasks/page",
                     data: dataString,
                     dataType: "html",
                     success: function(data) {
                          // alert(data);
                     }
                 });
             }
         }
};
// editor = CKEDITOR.inline( 'editor1', config);
// $(function(){
 editor =  CKEDITOR.inline( 'editor1',config); 
// });

});

