<script type="text/javascript">
$(function(){
  var subPage = new Array;
  subPage[0] = "estimate.php";
  subPage[1] = "estimate-action.php";
  subPage[2] = "estimate-pwd.php";
  subPage[3] = "estimate-res-edit.php";
  subPage[4] = "estimate-view.php";
  subPage[5] = "estimate-edit.php";
  subPage[6] = "news.php";
  subPage[7] = "news-action.php";
  subPage[8] = "news-edit.php";
  subPage[9] = "news-view.php";
  subPage[10] = "downloads-edit.php";
  subPage[11] = "downloads.php";

  var url = location.href;
  jQuery.each(subPage, function(index, item) {
    var subUrl = url.indexOf(subPage[index]);
    if(index<=5&&subUrl != -1){
      $(".estimate").addClass("on")
    }else if(index>5&&index<=9&&subUrl!=-1){
      $(".news").addClass("on")
    }else if(subUrl!=-1){
      $(".catalog").addClass("on")
    };
  });
});
</script>

<?php
	if($lang=="kr"){
    $menu_titleMenu_support_main = "고객센터";
    $menu_titleMenu_support1 = "카달로그";
		$menu_titleMenu_support2 = "온라인 문의";
    $menu_titleMenu_support3 = "뉴스 및 공지";

	}else{
    $menu_titleMenu_support_main = "SUPPORT";
    $menu_titleMenu_support1 = "CATALOGUE";
		$menu_titleMenu_support2 = "Q &amp; A";
    $menu_titleMenu_support3 = "NEWS &amp; NOTICE";
	}
?>

<div class="lnb">
  <div class="subNav">
    <ul>
      <li class="wide"><a href="../support/downloads.php"><?=$menu_titleMenu_support_main?></a></li>
      <li class="catalog"><a href="../support/downloads.php"><?=$menu_titleMenu_support1?></a></li>
      <li class="estimate"><a href="../support/estimate.php"><?=$menu_titleMenu_support2?></a></li>
      <li class="news"><a href="../support/news.php"><?=$menu_titleMenu_support3?></a></li>
    </ul><!--.subNav-->
  </div>
  <?php
  include "../inc/subMenu_south.php";
  ?>
</div><!--.lnb-->
