<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtdViewer">
<?php
require_once '../classes/common/config.php';
require_once '../classes/dao/EstimateDao.php';
require_once '../classes/common/session_helper.php';

$lang = getLanguage();

if (isset($_GET["lang"])){
	$lang = $_GET["lang"];
	setLanguage($lang);
}
if($lang=="kr"){
	$login_administrator = "관리자 로그인";
	$logout_administrator = "로그아웃";
	$menu_titleMenu_powerCool = "파워쿨소개";

	$menu_titleMenu_powerCool_introduce ="회사소개";
	$menu_titleMenu_powerCool_ceo = "대표이사 인사말";
	$menu_titleMenu_powerCool_group = "조직도";
	$menu_titleMenu_powerCool_location = "찾아오시는 길";

	$menu_titleMenu_products = "POWER COOL &amp; HEAT";
	$menu_titleMenu_products_explain = "특징";
	$menu_titleMenu_products_character = "모델 및 규격";
	$menu_titleMenu_products_test = "주문 정보";

	$menu_titleMenu_promotion = "홍보센터";
	$menu_titleMenu_promotion_catalogue = "카탈로그";

	$menu_titleMenu_support = "고객센터";
	$menu_titleMenu_support_testimate = "온라인 문의";
	$menu_titleMenu_support_news = " News & Notice";

}else{
	$login_administrator ="Administrator Login";
	$logout_administrator = "Logout";
	$menu_titleMenu_powerCool = "Company";

	$menu_titleMenu_powerCool_introduce ="About Us";
	$menu_titleMenu_powerCool_ceo = "CEO Message";
	$menu_titleMenu_powerCool_group = "Orginization";
	$menu_titleMenu_powerCool_location = "Location";

	$menu_titleMenu_products = "POWER COOL &amp; HEAT";
	$menu_titleMenu_products_explain = "FEATURES";
	$menu_titleMenu_products_character = "MODELS & SPEC.";
	$menu_titleMenu_products_test = "ORDERING INFO.";

	$menu_titleMenu_promotion = "PR Center";
	$menu_titleMenu_promotion_catalogue = "CATALOGUE";

	$menu_titleMenu_support = "SUPPORT";
	$menu_titleMenu_support_testimate = "Q &amp; A";
	$menu_titleMenu_support_news = " NEWS &amp; NOTICE";
}
?>

<script type="text/javascript">
(function(){

    // Match this timestamp with the release of your code
    var lastVersioning = Date.UTC(2014, 11, 20, 2, 15, 10);

    var lastCacheDateTime = localStorage.getItem('lastCacheDatetime');

    if(lastCacheDateTime){
        if(lastVersioning > lastCacheDateTime){
            var reload = true;
        }
    }

    localStorage.setItem('lastCacheDatetime', Date.now());

    if(reload){
        location.reload(true);
    }

})();

function logout()
{
	document.formLogin.submit();
}

</script>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="Keywords" content="파워쿨, Powercoolair">
	<meta name="description" content="파워쿨, 산업용 에어컨,산업용 에어콘, 산업용 냉풍기, 특수에어컨">
	<meta name="naver-site-verification" content="4885a85321865bd04b546ab7e06fd22d04791d6d"/>
    <meta property="og:type" content="Powercoolair, 파워쿨">
	<meta property="og:title" content="파워쿨, 파워쿨 국소냉방 산업용 특수에어컨 전문제작업체">
	<meta property="og:description" content="파워쿨, 산업용 에어컨,산업용 에어콘, 산업용 냉풍기, 특수에어컨">
	<meta property="og:image" content="http://powercoolair.com/myimage.jpg">
	<meta property="og:url" content="http://powercoolair.com">

	<title>파워쿨</title>
	<meta content="user-scalable=no">
	<link href="../css/base.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/modal.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script type="text/javascript" src="../js/loginModal.js"></script>
	<link rel="canonical" href="http://www.alessioatzeni.com/wp-content/tutorials/jquery/login-box-modal-dialog-window/index.html" />
</head>
<body>
	<div id="wrap">
		<div id="header">
			<div id="headerin">
				<h1 class="logo"><a href="../main/main.php"><img src="../img/logo.jpg" alt="powercool"></a></h1>
				<div class="utill">
					<div class="login">

						<?php if (!$is_login) { ?>
							<a href="#login-box" class="login-window"><?=$login_administrator?></a>
							<?php } else {?>
								<form id="formLogin" name="formLogin" action="../login-action.php" method="post">
									<input type="hidden" name="login-action" value="2">
									<div class="logout">
										<p><a href="##" onclick="javascript:logout();"><?=$logout_administrator?></a></p>
									</div>
								</form>
								<?php } ?>
							</div>
							<?php
							include "../inc/modal.php";
							?>
							<div class="lang">
								<p><a href="<?=$_SERVER["PHP_SELF"] . "?lang=kr"?>">Korean</a></p>
								<p><a href="<?=$_SERVER["PHP_SELF"] . "?lang=en"?>">English</a></p>
							</div><!--.lang-->
						</div><!--.utill-->
					</div><!--#headerin-->
					<div class="gnbWrap">
						<div class="gnb">
							<ul>
								<!--menu1
								<li>
									<a href="../introduce/introduce.php" class="m"><?=$menu_titleMenu_powerCool?></a>
									<ul class="sub">
										<li><a href="../introduce/introduce.php" class="pt10"><?=$menu_titleMenu_powerCool_introduce ?></a></li>
										<li><a href="../introduce/ceo.php"><?=$menu_titleMenu_powerCool_ceo  ?></a></li>
										<li><a href="../introduce/group.php"><?=$menu_titleMenu_powerCool_group ?></a></li>
										<li><a href="../introduce/location.php" class="pb10"><?=$menu_titleMenu_powerCool_location ?></a></li>
									</ul>
								</li>
								-->
								<li>
									<a href="../products/explain.php" class="m"><?=$menu_titleMenu_products?></a>
									<ul class="sub">
										<li><a href="../products/explain.php" class="pt10"><?=$menu_titleMenu_products_explain ?></a></li>
										<li><a href="../products/character.php"><?=$menu_titleMenu_products_character ?></a></li>
										<li><a href="../products/test.php" class="pb10"><?=$menu_titleMenu_products_test ?></a></li>
									</ul>
								</li><!--menu2-->
								<!--menu4
								<li>
									<a href="../support/downloads.php?page_name=catalog" class="m"><?=$menu_titleMenu_promotion?></a>
									<ul class="sub">
										<li><a href="../support/downloads.php" class="pt10 pb10"><?=$menu_titleMenu_promotion_catalogue?></a></li>
									</ul>
								</li>
								-->
								<li>
									<a href="../support/downloads.php" class="m"><?=$menu_titleMenu_support?></a>
									<ul class="sub">
										<li><a href="../support/downloads.php" class="pt10 pb10"><?=$menu_titleMenu_promotion_catalogue?></a></li>
										<li><a href="../support/estimate.php" class="pt10"><?=$menu_titleMenu_support_testimate?></a></li>
										<li><a href="../support/news.php" class="pb10"><?=$menu_titleMenu_support_news?></a></li>
									</ul>
								</li><!--menu5-->
							</ul>
						</div><!--.gnb-->
					</div><!--.gnbWrap-->


				</div><!--#header-->
