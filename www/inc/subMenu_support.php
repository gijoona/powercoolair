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

  var url = location.href;
  jQuery.each(subPage, function(index, item) {
    var subUrl = url.indexOf(subPage[index]);
    if(index<=5&&subUrl != -1){
      $(".estimate").addClass("on")
    }else if(subUrl!=-1){
      $(".news").addClass("on")
    };
  });
});
</script>

<?php
	if($lang=="kr"){
    $menu_titleMenu_support_main = "고객센터";
		$menu_titleMenu_support1 = "온라인 문의";

	}else{
    $menu_titleMenu_support_main = "Service";
		$menu_titleMenu_support1 = "Online Counseling";
	}
?>

<div class="lnb">
  <div class="subNav">
    <ul>
      <li><a href="../support/estimate.php"><?=$menu_titleMenu_support_main?></a></li>
      <li class="estimate"><a href="../support/estimate.php"><?=$menu_titleMenu_support1?></a></li>
      <li class="news"><a href="../support/news.php">NEWS &amp; NOTICE</a></li>
    </ul><!--.subNav-->
  </div>
  <?php
  include "../inc/subMenu_south.php";
  ?>
</div><!--.lnb-->
