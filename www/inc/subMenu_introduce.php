<script type="text/javascript">
$(function(){
    var subPage = new Array;
    subPage[0] = "introduce.php";
    subPage[1] = "ceo.php";
    subPage[2] = "group.php";
    subPage[3] = "location.php";
    var url = location.href;
    var getAr0 = url.indexOf(subPage[0]);
    var getAr1 = url.indexOf(subPage[1]);
    var getAr2 = url.indexOf(subPage[2]);
    var getAr3 = url.indexOf(subPage[3]);
    if(getAr0 != -1){
        $(".introduce").addClass("on")
    };
    if(getAr1 != -1){
        $(".ceo").addClass("on")
    };
    if(getAr2 != -1){
        $(".group").addClass("on")
    };
    if(getAr3 != -1){
        $(".location").addClass("on")
    };
});
</script>
<?php
	if($lang=="kr"){
		$menu_titleMenu_introduce1 = "파워쿨 소개";
		$menu_titleMenu_introduce2 = "회사 소개";
		$menu_titleMenu_introduce3 = "대표이사 인사말";
		$menu_titleMenu_introduce4 = "조직도";
		$menu_titleMenu_introduce5 = "찾아오시는 길";
		


	}else{
		$menu_titleMenu_introduce1 = "Company";
		$menu_titleMenu_introduce2 = "About Us";
		$menu_titleMenu_introduce3 = "CEO Message";
		$menu_titleMenu_introduce4 = "Orginization";
		$menu_titleMenu_introduce5 = "Location";
	}
?>
<div class="lnb">
    <div class="subNav">
        <ul>
              <li><a href="../introduce/introduce.php"><?=$menu_titleMenu_introduce1?></a></li>
              <li class="introduce"><a href="../introduce/introduce.php"><?=$menu_titleMenu_introduce2?></a></li>
              <li class="ceo"><a href="../introduce/ceo.php"><?=$menu_titleMenu_introduce3?></a></li>
              <li class="group"><a href="../introduce/group.php"><?=$menu_titleMenu_introduce4?></a></li>
              <li class="location"><a href="../introduce/location.php"><?=$menu_titleMenu_introduce5?></a></li>
        </ul><!--.subNav-->
      </div>
      <?php
				include "../inc/subMenu_south.php";
			?>
  </div><!--.lnb-->
