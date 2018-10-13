<?php
	include "../inc/header.php";
?>
    <div class="subContainer">
        	<nav class="lnb">
            	<div class="subNav">
                	<ul>
                        <li><a href="../catalog/catalog.php">홍보센터</a></li>
                        <li class="on"><a href="../catalog/catalog.php">카탈로그 다운로드</a></li>
                	</ul><!--.subNav-->
                </div>
                <div class="online">
            		<p class="text1">온라인 문의</p>
                	<p class="text2">powercoolair@naver.com</p>
                	<a href="../support/estimate.php" class="onlineBtn">온라인상담 바로가기</a>
            	</div><!--.online-->
            	<div class="searchWrap">
            		<p class="searchN">네이버</p>
                	<input type="text" id="searchN" name="searchN" placeholder="파워쿨"><a href="#" class="inputBtn btnN">검색</a>
                	<p class="searchD">다음</p>
                	<input type="text" id="searchD" name="searchD" placeholder="파워쿨"><a href="#" class="inputBtn btnD">검색</a>
           		 </div><!--.searchWrap-->
            </nav><!--.lnb-->
            <div class="cata_subCont">
            	<h3 class="cImg1"><img src="../img/catalog_01.jpg" alt="카탈로그"></h3>
                <div class="cImgWrap">
                	<p class="cImg2"><img src="../img/catalog_02.jpg"></p>
                    <p class="cImg3"><img src="../img/catalog_03.jpg"></p>
                </div>
                <p class="cBtn"><a href="#">카탈로그 VIEW</a></p>
                <p class="cBtn"><a href="#">카탈로그 다운로드</a></p>
            </div><!--.cata_subCont-->
    </div><!--.subContainer-->
<?php
	include "../inc/footer.php";
?>
