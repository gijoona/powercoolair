<div class="lnb">
    <div class="subNav">
        <ul>
              <li><a href="../technique/technique.php">기술 현황</a></li>
              <li class="technique"><a href="../technique/technique.php">기술 현황</a></li>
        </ul><!--.subNav-->
      </div>
      <?
          include "../inc/subMenu_south.php";
      ?>
  </div><!--.lnb-->
  <script type="text/javascript">
  $(function(){
      var subPage = new Array;
      subPage[0] = "technique.php";

      var url = location.href;
      var getAr0 = url.indexOf(subPage[0]);

      if(getAr0 != -1){
          $(".technique").addClass("on")
      };

  });
  </script>
