<script type="text/javascript">
$(function(){
    var subPage = new Array;
    subPage[0] = "downloads.php";

    var url = location.href;
    var getAr0 = url.indexOf(subPage[0]);

    if(getAr0 != -1){
        $(".catalog").addClass("on")
    };

});
</script>

<?php
	if($lang=="kr"){
    $menu_titleMenu_catalog_main = "홍보센터";
		$menu_titleMenu_catalog1 = "카탈로그 다운로드";

	}else{
    $menu_titleMenu_catalog_main = "PR Center";
		$menu_titleMenu_catalog1 = "Catalogue Download";
	}
?>

<div class="lnb">
    <div class="subNav">
        <ul>
              <li><a href="../support/downloads.php"><?=$menu_titleMenu_catalog_main?></a></li>
              <li class="catalog"><a href="../support/downloads.php"><?=$menu_titleMenu_catalog1?></a></li>
        </ul><!--.subNav-->
      </div>
        <?php
            include "../inc/subMenu_south.php";
        ?>
  </div><!--.lnb-->
