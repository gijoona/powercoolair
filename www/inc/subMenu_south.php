<?php
	if($lang=="kr"){
		$menu_titleMenu_southText1_1 = "온라인 문의";
		$menu_titleMenu_southText1_2 = "";
		$menu_titleMenu_southText3 = "온라인상담 바로가기";



	}else{
		$menu_titleMenu_southText1_1 = "Customer";
		$menu_titleMenu_southText1_2 = "Support";
		$menu_titleMenu_southText3 = "ONLINE Q &amp; A";
	}
?>
 <?php if($lang=="kr"){?>
<div class="online">
  <p class="text1"><?=$menu_titleMenu_southText1_1?><br /></p>
  <p class="text2">powerair@superlok.com</p>
  <a href="../support/estimate.php" class="onlineBtn"><?=$menu_titleMenu_southText3?></a>
</div><!--.online-->
<div class="counseling_info">
	<p class="text1">구입문의<br /></p>
	<p class="text2">055-783-1009</p>
	<!--
  <p class="searchN">네이버</p>
  <input type="text" id="searchN" name="searchN" placeholder="파워쿨">
  <a href="https://search.naver.com/search.naver?sm=tab_hty.top&where=nexearch&oquery=%ED%8C%8C%EC%9B%8C%EC%BF%A8&ie=utf8&query=powercoolair" class="inputBtn btnN"  target="_blank">검색</a>
  <p class="searchD">다음</p>
  <input type="text" id="searchD" name="searchD" placeholder="파워쿨">
  <a href="#" class="inputBtn btnD"  target="_blank">검색</a>
	-->
</div>
<!--.searchWrap-->
<?php }else{?>
<div class="online">
  <p class="text1" style="text-align:right; line-height:20px; padding-top:10px; padding-right:10px; background-position:10px -10px;"><?=$menu_titleMenu_southText1_1?><br /><?=$menu_titleMenu_southText1_2?></p>
  <p class="text2" style="margin-top:-10px;">powerair@superlok.com</p>
  <a href="../support/estimate.php" class="onlineBtn" style="padding:5px 10px;"><?=$menu_titleMenu_southText3?></a>
</div><!--.online-->
<div class="counseling_info">
	<p class="text1">구입문의<br /></p>
	<p class="text2">055-783-1009</p>
	<!--
  <p class="searchN">네이버</p>
  <input type="text" id="searchN" name="searchN" placeholder="파워쿨">
  <a href="https://search.naver.com/search.naver?sm=tab_hty.top&where=nexearch&oquery=%ED%8C%8C%EC%9B%8C%EC%BF%A8&ie=utf8&query=powercoolair" class="inputBtn btnN"  target="_blank">검색</a>
  <p class="searchD">다음</p>
  <input type="text" id="searchD" name="searchD" placeholder="파워쿨">
  <a href="#" class="inputBtn btnD"  target="_blank">검색</a>
	-->
</div><!--.searchWrap-->
<?php }?>
