<?php
	include "../inc/header.php";

if($lang=="kr"){
	$menu_titleMenu_contentTitle1 = "온라인 문의";
	$menu_titleMenu_contentTitle2 = "뉴스 및 공지";
	$menu_titleMenu_contentTitle3 = "POWER <font color='blue'>COOL</font> &amp; <font color='red'>HEAT</font>";
	$menu_titleMenu_contentText2_1_1 = "POWER COOL & HOT에 대해서 궁금한 점이 있으시거나 묻고 싶은 점이 있으시면 언제든 문의하십시오.";
	$menu_titleMenu_contentText2_1_2 = "최대한 신속하고 빠른 답변으로 고객의 궁금증을 해소해 드리겠습니다.";
	$menu_titleMenu_contentText2_2_1 = "POWER COOL & HOT의 뉴스와 새로운 소식을";
	$menu_titleMenu_contentText2_2_2 = "알려드리는 곳입니다. 전시회 참가, 각종 행사나 이벤트 등 POWER COOL & HOT의 다양한 소식들을 만나보세요";
	$menu_titleMenu_contentText2_3_1 = "POWER COOL & HOT 제품에 대해서 궁금하신가요?";
	$menu_titleMenu_contentText2_3_2 = "제품의 특징 사양 그리고 POWER COOL & HOT의";
	$menu_titleMenu_contentText2_3_3 = "제품 테스트 등 제품의 대한 궁금한 사항들이 소개되어 있습니다.";
	$menu_titleMenu_conBtn1 = "온라인상담 바로가기";
	$menu_titleMenu_conBtn2 = "NEWS 바로가기";
	$menu_titleMenu_conBtn3 = "제품소개 바로가기";


}else{
	$menu_titleMenu_contentTitle1 = "Online Counseling";
	$menu_titleMenu_contentTitle2 = "News &amp; Notice";
	$menu_titleMenu_contentTitle3 = "POWER COOL &amp; HEAT";
	$menu_titleMenu_contentText2_1_1 = "Please contact us any time if you have any curiosities about POWER COOL & HOT or if you have any questions to ask. We will strive to resolve the curiosities of our customers by the rapid answers as soon as possible.";
	$menu_titleMenu_contentText2_1_2 = "";
	$menu_titleMenu_contentText2_2_1 = "We provide the news and other updates of POWER COOL & HOT here. Please come in contact with a diversity of news at POWER COOL & HOT such as the participation at exhibitions, hosting of events of different types and others.";
	$menu_titleMenu_contentText2_2_2 = "";
	$menu_titleMenu_contentText2_3_1 = "Do you have any curiosities about the products of POWER COOL & HOT? The product details to quench the curiosities are introduced here including the major characteristics and specifications of products, the test results of the products of POWER COOL & HOT and others.";
	$menu_titleMenu_contentText2_3_2 = "";
	$menu_titleMenu_contentText2_3_3 = "";
	$menu_titleMenu_conBtn1 = "Go to Online Counseling";
	$menu_titleMenu_conBtn2 = "Go to News";
	$menu_titleMenu_conBtn3 = "Go to Introduction of Products";
}

?>

    <div id="container">


       <?php if($lang=="kr"){?>
        <div class="visual"><img src="../img/visual.jpg" alt="국소 냉방 산업용 특수에어컨"></div>
        <div class="contentWrap">
        	<ul class="content">
            	<li>
              	<h3><?=$menu_titleMenu_contentTitle1?></h3>
                  <p class="text1">powercoolair@naver.com</p>
                  <p class="text2" style="margin-top:-10px;"><?=$menu_titleMenu_contentText2_1_1?><br><?=$menu_titleMenu_contentText2_1_2?></p>
                  <a href="../support/estimate.php" class="more">more</a>
                  <a href="../support/estimate.php" class="conBtn"><?=$menu_titleMenu_conBtn1?></a>
              </li>
              <li>
              	<h3>News &amp; Notice</h3>
                  <p class="text2"><?=$menu_titleMenu_contentText2_2_1?><br /><?=$menu_titleMenu_contentText2_2_2?></p>
                  <a href="../support/news.php" class="more">more</a>
                  <a href="../support/news.php" class="conBtn"><?=$menu_titleMenu_conBtn2?></a>
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
                <p class="text1">powercoolair@naver.com</p>
                <p class="text2" style="font-size:11px; text-align:justify; text-justify:inter-word; line-height:18px;"><?=$menu_titleMenu_contentText2_1_1?><br><?=$menu_titleMenu_contentText2_1_2?></p>
                <a href="../support/estimate.php" class="more">more</a>
                <a href="../support/estimate.php" class="conBtn" style="width:180px;"><?=$menu_titleMenu_conBtn1?></a>
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
