<?php
require_once '../classes/dao/BoardDao.php';
require_once '../classes/common/session_helper.php';
$main_menu = 5;
$sub_menu = 1;
$board_no = $_GET["board_no"];
$page_no = $_GET["page_no"];
if (!$_GET["page_no"])
$page_no = 1;
else
$page_no = $_GET["page_no"];

$board_type = "news";
$user_id = getUserId();
$is_admin = getUserLevel() == 1 ? true : false;
$can_edit = false;

$newsDao = new BoardDao();
$row = $newsDao->getDetail($board_no);

if ($is_admin && $user_id == $row["user_id"])
$can_edit = true;

$prev_article = $newsDao->getPrevArticle($board_no, $board_type);
$next_article = $newsDao->getNextArticle($board_no, $board_type);
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>powercoolair</title>
	<link href="../css/sub_page.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	#board-table { width: 100%; font-size: 13px; text-align: left; border-spacing: 0; border-collapse: collapse; margin-top: 15px; color: #555}
	#board-table .body-cell { text-align: left; }
	#board-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#board-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px; padding: 0px 5px }

	#order-table { width: 100%; font-size: 12px; text-align: left; border-spacing: 0; border-collapse: collapse; margin-top: 15px; color: #555;}
	#order-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#order-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px; padding: 0px 5px }
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

	function goList()
	{
		window.location.href = 'news.php?page_no=' + <?=$page_no?>
	}

	function editNews()
	{
		window.location.href = 'news-edit.php?page_no=' + <?=$page_no?> + '&board_no=' + <?=$board_no?>;
	}

	function deleteNews()
	{
		var form = document.forms["form-news"];
		form.board_no.value = <?=$board_no?>;
		form.submit();
	}
	</script>
</head>
<body>
	<?php
	include "../inc/header.php";
	?>
	<div class="subContainer">
		<?php
		include "../inc/subMenu_support.php";
		?>
		<div class="cus_subCont">
			<div id="content">
            <div style="width:900px; position:absolute; top:-5px; right:0;">
				<div id="content-frame">
					
					<form name="form-news" method="post" action="../classes/common/BoardAction.php">
						<input type="hidden" name="board_action" value="delete">
						<input type="hidden" name="board_type" value="news">
						<input type="hidden" name="board_no">
					</form>
						<table id="board-table" style="width: 100%; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc">
							<tr>
								<th style="width: 20%">제목</th>
								<td colspan="3" style="text-align: left; padding: 0px 5px"><?=$row["title"]?></td>
							</tr>
							<tr>
								<th style="width: 20%">작성자</th>
								<td style="width: 30%"><?=$row["user_name"]?></td>
								<th style="width: 20%">날짜</th>
								<td style="width: 30%"><?=$row["reg_date"]?></td>
							</tr>
							<tr>
								<td colspan="4" style="text-align: left; padding: 20px 5px">
									<?=stripslashes($row["contents"])?>
								</td>
							</tr>
						</table>
						<table style="width: 100%; margin-top: 10px">
							<tr>
								<td style="width: 50%"><button type="button" class="btn btn-default btn-sm" onclick="javascript:goList()">목록</button></td>
								<td style="width: 50%; text-align: right">
									<?php if ($can_edit) {?>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:editNews()">수정</button>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:deleteNews()">삭제</button>
										<?php }?>
									</td>
								</tr>
							</table>
							<?php if ($prev_article != null || $next_article != null) {?>
								<table id="order-table">
									<tr>
										<th style="background-color: #eee; height: 30px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">이전글</th>
										<?php if ($prev_article != null) {?>
											<td style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc"><a href="news-view.php?page_no=<?=$page_no?>&board_no=<?=$prev_article['board_no']?>"><?=$prev_article["title"]?></a></td>
											<?php } else {?>
												<td style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">이전글이 존재하지 않습니다.</td>
												<?php }?>
											</tr>
											<tr>
												<th style="background-color: #eee; height: 30px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">다음글</th>
												<?php if ($next_article != null) {?>
													<td style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc"><a href="news-view.php?page_no=<?=$page_no?>&board_no=<?=$next_article['board_no']?>"><?=$next_article["title"]?></a></td>
													<?php } else {?>
														<td style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">다음글이 존재하지 않습니다.</td>
														<?php }?>
													</tr>
												</table>
												<?php }?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					include "../inc/footer.php";
					?>
