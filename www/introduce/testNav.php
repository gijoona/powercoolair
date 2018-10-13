<html>
<head>
  <title>test</title>
	<link href="../css/test.css" rel="stylesheet">
</head>
<style>
a{color:#000;}

.mask{width:100%; height:100%; position:fixed; left:0; top:0; z-index:10; background:#000; opacity:.5; filter:alpha(opacity=50);}

#modalLayer{display:none; position:relative;}
#modalLayer .modalContent{width:440px; height:200px; padding:20px; border:1px solid #ccc; position:fixed; left:50%; top:50%; z-index:11; background:#fff;}
#modalLayer .modalContent button{position:absolute; right:0; top:0; cursor:pointer;}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
var modalLayer = $("#modalLayer");
var modalLink = $(".modalLink");
var modalCont = $(".modalContent");
var marginLeft = modalCont.outerWidth()/2;
var marginTop = modalCont.outerHeight()/2;

modalLink.click(function(){
  modalLayer.fadeIn("slow");
  modalCont.css({"margin-top" : -marginTop, "margin-left" : -marginLeft});
  $(this).blur();
  $(".modalContent > a").focus();
  return false;
});

$(".modalContent > button").click(function(){
  modalLayer.fadeOut("slow");
  modalLink.focus();
});
});
</script>
<body>
  <a href="#modalLayer" class="modalLink">간단한 모달 창 만들기</a>
  <div id="modalLayer">
    <div class="modalContent">
      <a href="#">모달창 테스트</a>
      <button type="button">닫기</button>
    </div>
  </div>
</body>
</html>
