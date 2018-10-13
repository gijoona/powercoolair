<?php
	if($lang=="kr"){
		$menu_titleMenu_products1 = "POWER <font color='blue'>COOL</font> &amp; <font color='red'>HEAT</font>";
		$menu_titleMenu_products2 = "특징";
		$menu_titleMenu_products3 = "모델 및 규격";
		$menu_titleMenu_products4 = "주문 정보";



	}else{
		$menu_titleMenu_products1 = "POWER <font color='blue'>COOL</font> &amp; <font color='red'>HEAT</font>";
		$menu_titleMenu_products2 = "Features";
		$menu_titleMenu_products3 = "Models &amp; Specifications";
		$menu_titleMenu_products4 = "Ordering Information";
	}
?>
<div class="lnb">
    <div class="subNav">
        <ul>
              <li class="wide"><a href="../products/explain.php"><?=$menu_titleMenu_products1?></a></li>
              <li class="explain"><a href="../products/explain.php"><?=$menu_titleMenu_products2?></a></li>
              <li class="character"><a href="../products/character.php"><?=$menu_titleMenu_products3?></a></li>
              <li class="test"><a href="../products/test.php"><?=$menu_titleMenu_products4?></a></li>
        </ul><!--.subNav-->
      </div>
      <?php
        include "../inc/subMenu_south.php";
      ?>
  </div><!--.lnb-->
  <script type="text/javascript">
  $(function(){
      var subPage = new Array;
      subPage[0] = "explain.php";
      subPage[1] = "character.php";
      subPage[2] = "test.php";
      var url = location.href;
      var getAr0 = url.indexOf(subPage[0]);
      var getAr1 = url.indexOf(subPage[1]);
      var getAr2 = url.indexOf(subPage[2]);
      if(getAr0 != -1){
          $(".explain").addClass("on")
      };
      if(getAr1 != -1){
          $(".character").addClass("on")
      };
      if(getAr2 != -1){
          $(".test").addClass("on")
      };
  });
  </script>
