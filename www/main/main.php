<?php
	include "../inc/header.php";

if($lang=="kr"){
	$menu_titleMenu_contentTitle1 = "온라인 문의";
	$menu_titleMenu_contentTitle2 = "NEWS &amp; NOTICE";
	$menu_titleMenu_contentTitle3 = "POWER <font color='blue'>COOL</font> &amp; <font color='red'>HEAT</font>";
	$menu_titleMenu_contentText2_1_1 = "POWER COOL&amp;HEAT에 대해 문의사항이 있으실 경우 언제든 이메일 혹은 게시판으로 문의해주십시오.";
	$menu_titleMenu_contentText2_1_2 = ""; //"최대한 신속하고 빠른 답변으로 고객의 궁금증을 해소해 드리겠습니다.";
	$menu_titleMenu_contentText2_2_1 = "POWER COOL&amp;HEAT에 대해 각종 전시회 참가, 뉴스, 이벤트 등 새로운 소식을 알려드립니다.";
	$menu_titleMenu_contentText2_2_2 = ""; //"알려드리는 곳입니다. 전시회 참가, 각종 행사나 이벤트 등 POWER COOL & HOT의 다양한 소식들을 만나보세요";
	$menu_titleMenu_contentText2_3_1 = "POWER COOL&amp;HEAT 제품에 대해 궁금하신가요? ";
	$menu_titleMenu_contentText2_3_2 = "제품의 특징, 모델, 규격 등 다양한 정보가 소개되어 있습니다.";
	$menu_titleMenu_contentText2_3_3 = ""; //"제품 테스트 등 제품의 대한 궁금한 사항들이 소개되어 있습니다.";
	$menu_titleMenu_conBtn1 = "온라인 문의 바로가기";
	$menu_titleMenu_conBtn2 = "NEWS &amp; NOTICE 바로가기";
	$menu_titleMenu_conBtn3 = "제품소개 바로가기";


}else{
	$menu_titleMenu_contentTitle1 = "CUSTOMER SUPPORT";
	$menu_titleMenu_contentTitle2 = "NEWS &amp; NOTICE";
	$menu_titleMenu_contentTitle3 = "POWER <font color='blue'>COOL</font> &amp; <font color='red'>HEAT</font>";
	$menu_titleMenu_contentText2_1_1 = "If you have any inquiries about POWER COOL&amp;HEAT, please contact us via e-mail or online Q&A board any time. We are happy to listen to you and oblige.";
	$menu_titleMenu_contentText2_1_2 = "";
	$menu_titleMenu_contentText2_2_1 = "Updates on POWER COOL&amp;HEAT, such as exhibition, news, and events.";
	$menu_titleMenu_contentText2_2_2 = "";
	$menu_titleMenu_contentText2_3_1 = "Learn about POWER COOL&amp;HEAT. ";
	$menu_titleMenu_contentText2_3_2 = "Here, we introduce POWER COOL&amp;HEAT including the features, models, and specifications.";
	$menu_titleMenu_contentText2_3_3 = "";
	$menu_titleMenu_conBtn1 = "ONLINE Q &amp; A";
	$menu_titleMenu_conBtn2 = "NEWS &amp; NOTICE";
	$menu_titleMenu_conBtn3 = "ABOUT POWERCOOL&amp;HEAT";
}

?>

    <div id="container">


       <?php if($lang=="kr"){?>
        <div class="visual"><img src="../img/visual.jpg" alt="국소 냉방 산업용 특수에어컨"></div>
        <div class="contentWrap">
        	<ul class="content">
            	<li>
              	<h3><?=$menu_titleMenu_contentTitle1?></h3>
                  <p class="text1">powerair@superlok.com</p>
                  <p class="text2" style="margin-top:-10px;"><?=$menu_titleMenu_contentText2_1_1?><br><?=$menu_titleMenu_contentText2_1_2?></p>
                  <a href="../support/estimate.php" class="more">more</a>
                  <a href="../support/estimate.php" class="conBtn"><?=$menu_titleMenu_conBtn1?></a>
              </li>
              <li>
              	<h3><?=$menu_titleMenu_contentTitle2?></h3>
                  <p class="text2"><?=$menu_titleMenu_contentText2_2_1?><br /><?=$menu_titleMenu_contentText2_2_2?></p>
                  <a href="../support/news.php" class="more">more</a>
                  <a href="../support/news.php" class="conBtn" style="width:180px;"><?=$menu_titleMenu_conBtn2?></a>
              </li>
              <li class="borderR">
              	<h3><?=$menu_titleMenu_contentTitle3?></h3>
                  <p class="text2"><?=$menu_titleMenu_contentText2_3_1?><br /><?=$menu_titleMenu_contentText2_3_2?><br /><?=$menu_titleMenu_contentText2_3_3?></p>
                  <a href="../products/explain.php" class="more">more</a>
                  <a href="../products/explain.php" class="conBtn"><?=$menu_titleMenu_conBtn3?></a>
              </li>
							<!--
              <div class="btnMenu">
									<p class="bm1"><a href="../introduce/introduce.php">회사소개123</a></p>
                  <p class="bm2"><a href="../products/explain.php">제품정보</a></p>
                  <p class="bm3"><a href="../support/estimate.php">온라인 문의</a></p>
                  <p class="bm4"><a href="../support/downloads.php?page_name=catalog">다운로드</a></p>
      				</div>
							-->
							<!--.btnMenu-->
            </ul>
        </div><!--.contentWrap-->
        <?php }else{?>
		<div class="visual"><img src="../img/visual_eng.jpg" alt="국소 냉방 산업용 특수에어컨"></div>
          <div class="contentWrap" style="height:250px;">
        	<ul class="content">
          	<li style="height:160px;">
            	<h3><?=$menu_titleMenu_contentTitle1?></h3>
                <p class="text1">powerair@superlok.com</p>
                <p class="text2" style="font-size:11px; text-align:justify; text-justify:inter-word; line-height:18px;"><?=$menu_titleMenu_contentText2_1_1?><br><?=$menu_titleMenu_contentText2_1_2?></p>
                <a href="../support/estimate.php" class="more">more</a>
                <a href="../support/estimate.php" class="conBtn"><?=$menu_titleMenu_conBtn1?></a>
            </li>
            <li style="height:160px;">
							<h3><?=$menu_titleMenu_contentTitle2?></h3>
                <p class="text2" style="font-size:11px; text-align:justify; text-justify:inter-word; line-height:18px;"><?=$menu_titleMenu_contentText2_2_1?><br /><?=$menu_titleMenu_contentText2_2_2?></p>
                <a href="../support/news.php" class="more">more</a>
                <a href="../support/news.php" class="conBtn" style="width:180px;"><?=$menu_titleMenu_conBtn2?></a>
            </li>
            <li class="borderR"  style="height:160px;">
            	<h3><?=$menu_titleMenu_contentTitle3?></h3>
                <p class="text2" style="font-size:11px; text-align:justify; text-justify:inter-word; line-height:18px;"><?=$menu_titleMenu_contentText2_3_1?><br /><?=$menu_titleMenu_contentText2_3_2?><br /><?=$menu_titleMenu_contentText2_3_3?></p>
                <a href="../products/explain.php" class="more">more</a>
                <a href="../products/explain.php" class="conBtn" style="width:180px;"><?=$menu_titleMenu_conBtn3?></a>
            </li>
						<!--
            <div class="btnMenu">
                <p class="bm1"><a href="../introduce/introduce.php" style="background-image:url(../img/btn_menu_eng.png);">회사소개</a></p>
                <p class="bm2"><a href="../products/explain.php" style="background-image:url(../img/btn_menu_eng.png); background-position:0 -99px;">제품정보</a></p>
                <p class="bm3"><a href="../support/estimate.php" style="background-image:url(../img/btn_menu_eng.png); background-position:0 -200px;">온라인 문의</a></p>
                <p class="bm4"><a href="../support/downloads.php?page_name=catalog" style="background-image:url(../img/btn_menu_eng.png); background-position:0 -299px;">다운로드</a></p>
        		</div>
						-->
						<!--.btnMenu-->
          </ul>
        </div><!--.contentWrap-->
        <?php }?>
    </div><!--#container-->
<?php
	include "../inc/footer.php";
?>
