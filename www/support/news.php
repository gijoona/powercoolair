<?php
require_once '../classes/dao/BoardDao.php';
require_once '../classes/common/session_helper.php';

$lang = getLanguage();

if (isset($_GET["lang"]))
{
	$lang = $_GET["lang"];
	setLanguage($lang);
}

if ($lang == "kr")
{
	$label_no = "번호";
	$label_subject = "제목";
	$label_date = "날짜";
	$label_no_contents = "등록된 게시물이 존재하지 않습니다.";
	$label_hit = "조회수";
}
else
{
	$label_no = "No";
	$label_subject = "Subject";
	$label_date = "Date";
	$label_no_contents = "No contents yet.";
	$label_hit = "Hit";
}

$main_menu = 5;
$sub_menu = 1;
$page_no = $_GET["page_no"];
if (!$_GET["page_no"])
$page_no = 1;
else
$page_no = $_GET["page_no"];

// 게시판 타입
$board_type = "news";

$newsDao = new BoardDao();
$dataList = $newsDao->getList($page_no, $board_type);
$page_count = $newsDao->getPageCount($board_type);
$data_count = $newsDao->getDataCount($board_type);

$isAdmin = getUserLevel() == 1 ? true : false;
// echo (printf("$isAdmin"));
// exit();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>powercoolair</title>
	<link href="../css/sub_page.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	#board-table { width: 100%; font-size: 13px; text-align: center; border-spacing: 0; border-collapse: collapse; margin-top: 4px; color: #555}
	#board-table .body-cell { text-align: left; }
	#board-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#board-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px }
	#board-table a { color: #555; text-decoration: none }
	#board-table a:hover { text-decoration: none; color: #f5b620 }
	#pager { width: 100%; margin-top: 20px; text-align: center; }
	#pager img { width: 23px; height: 23px; vertical-align: middle; }
	#pager .page-no { margin: 0px 2px; font-size: 12px }
	#pager .active { color: #f5b620 }
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">
	function getIeVersion()
	{
		var myNav = navigator.userAgent.toLowerCase();
		return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
	}

	function resizeLayout()
	{
		width = $('#nav-main').outerWidth() + $('#nav-sub').outerWidth() + $('#content-wrap').outerWidth();

		var screenWidth = $(window).width();
		if (screenWidth < width)
		screenWidth = width;

		var margin = (screenWidth - width) / 2;
		if (margin > 0)
		$('#doc-wrap').css('width', screenWidth-margin);
	}

	$(document).ready(function() {

		resizeLayout();

		var ver = getIeVersion();

		if (ver != false && getIeVersion() < 10)
		{
			var h1 = $(window).height();
			$('#nav-main').height(h1);
			$('#nav-sub').height(h1);

			$(window).resize(function() {
				var h1 = $(window).height();
				$('#nav-main').height(h1);
				$('#nav-sub').height(h1);
			});
		}
	});

	$(window).resize( function() {

		resizeLayout();

	});

	function showContent(no)
	{
		window.location.href = 'news-view.php?page_no=<?=$page_no?>&board_no=' + no;
	}

	function goPage(pageNo)
	{
		window.location.href = 'news.php?page_no=' + pageNo;
	}

	function goPrevPageGroup()
	{
		var curPage = <?=$page_no?>;
		var pageGroup = (curPage-1) / 10;

		if (pageGroup > 0)
		{
			pageGroup--;
			curPage = 1 + pageGroup * 10;
			window.location.href = 'news.php?page_no=' + curPage;
		}
	}

	function goNextPageGroup()
	{
		var curPage = <?=$page_no?>;
		var pageCount = <?=$page_count?>;
		var pageGroup = (curPage-1) / 10;
		curPage = (pageGroup+1) * 10 + 1;

		if (curPage <= pageCount)
		window.location.href = 'news.php?page_no=' + curPage;
	}

	function goNextPage()
	{
		var curPage = <?=$page_no?>;
		var pageCount = <?=$page_count?>;

		if (curPage < pageCount)
		window.location.href = 'news.php?page_no=' + (curPage+1);
	}

	function goPrevPage()
	{
		var curPage = <?=$page_no?>;
		if (curPage > 1)
		window.location.href = 'news.php?page_no=' + (curPage-1);
	}

	function goWrite()
	{
		window.location.href = 'news-edit.php?page_no=<?=$page_no?>';
	}
	</script>
</head>
<body>
	<?php
	include "../inc/header.php";
	?>
	<div id="content">
		<div class="subContainer">
			<?php
			include "../inc/subMenu_support.php";
			?>
			<div class="cus_subCont">
				<div id="content-wrap">
				<div style="width:900px; position:absolute; top:-27px; right:0; padding-right:25px;">
						<table style="width: 100%">
							<tr>
								<td style="width: 70%"></td>
								<td style="text-align: right">전체 <span style="color: #f5b620"><?=$data_count?></span>건</td>
							</tr>
						</table>
						<table id="board-table">
							<tr style="border-top:2px solid #ccc; border-bottom:2px solid #ccc;">
								<th style="width: 10%"><?=$label_no?></th>
								<th class="header" style="width: 50%"><?=$label_subject?></th>
								<th class="header" style="width: 25%"><?=$label_date?></th>
								<th style="width: 15%"><?=$label_hit?></th>
							</tr>
							<?php if (count($dataList) == 0) {?>
								<tr>
									<td colspan="4" style="text-align: center"><?=$label_no_contents?></td>
								</tr>
								<?php } else {?>
									<?php foreach ($dataList as $row) {?>
										<tr>
											<td><?=$row["no"]?></td>
											<td class="body-cell"><a href="javascript:showContent(<?=$row["board_no"]?>)"><?=$row["title"]?></a></td>
											<td><?=$row["reg_date"]?></td>
											<td><?=$row["hit_count"]?></td>
										</tr>
										<?php } }?>
									</table>
									<div id="pager">
										<a href="javascript:goPrevPageGroup()"><img src="../images/common/prev-page-group.jpg"></a>
										<a href="javascript:goPrevPage()"><img src="../images/common/prev-page.jpg" style="margin-right: 10px"></a>
										<?php for ($i = 1; $i <= $page_count; $i++) {?>
											<?php if ($i == $page_no) {?>
												<a href="#"><span class="page-no active"><?=$i?></span></a>
												<?php } else {?>
													<a href="javascript:goPage(<?=$i?>)"><span class="page-no"><?=$i?></span></a>
													<?php } }?>
													<a href="javascript:goNextPage()"><img src="../images/common/next-page.jpg" style="margin-left: 10px"></a>
													<a href="javascript:goNextPageGroup()"><img src="../images/common/next-page-group.jpg"></a>
												</div>
												<?php if ($isAdmin) {?>
													<div id="controller" style="width: 100%; text-align: right; margin-top: -28px">
														<button type="button" class="btn btn-default btn-sm" onclick="javascript:goWrite()">글쓰기</button>
													</div>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								include "../inc/footer.php";
								?>
