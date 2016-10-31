@section('topscripts')

<script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.min.js"></script>
<script defer="" language="javascript" type="text/javascript" src="{{WWW_SUB_DOMAIN}}assets/backend/js/main.js"></script>
<script language="javascript" type="text/javascript">

function addFancyBox(){
  if(jQuery) {
    try{
      jQuery('a[rel^="lightbox"]').fancybox({prevEffect:'fade',nextEffect:'fade'});
    }
    catch(exc){
      //setTimeout('addFancyBox()', 500);
    }
  }
  else{
    setTimeout('addFancyBox()', 500); 
  }
}
function jqueryLoaded(){
  jQuery('li.selected').parents('li').attr('class','selected');
};

</script>
<script defer="" onload="addFancyBox()" type="text/javascript" src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{WWW_SUB_DOMAIN}}assets/backend/css/prettify.css"><style type="text/css">.fancybox-margin{margin-right:0px;}</style>

@endsection

@section('bottomscripts')
<script>
var importFiles = new Array('{{WWW_SUB_DOMAIN}}assets/backend/css/jquery.fancybox.min.css', '{{WWW_SUB_DOMAIN}}assets/backend/fileman/css/jquery-ui.css');
var cb = function() {
  for(i in importFiles) {
    var l = document.createElement('link'); 
    l.rel = 'stylesheet';
    l.href = importFiles[i];
    var h = document.getElementsByTagName('head')[0]; 
    h.parentNode.insertBefore(l, h);
  }
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
    webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) raf(cb);
else window.addEventListener('load', cb);
</script>
<script>
function openCustomRoxy2(){
  jQuery('#roxyCustomPanel2').dialog({modal:true, width:820,height:500});
}
function closeCustomRoxy2(){
  jQuery('#roxyCustomPanel2').dialog('close');
}
</script>

@endsection