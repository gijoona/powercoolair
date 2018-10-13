<?php
require_once '../classes/common/config.php';
require_once '../classes/common/session_helper.php';
require_once '../classes/dao/EstimateDao.php';

$main_menu = 6;
$sub_menu = 1;

$lang = getLanguage();

if (isset($_GET["lang"]))
{
	$lang = $_GET["lang"];
	setLanguage($lang);
}

$page_no  = isset($_REQUEST["page_no"]) ? $_REQUEST["page_no"] : 1;
$board_no = $_REQUEST["board_no"];

$dao = new EstimateDao();
$board_org  = $dao->getDetail($board_no);
$resList    = $dao->getResList($board_no);

$is_admin = getUserLevel() == 1 ? true : false;
$is_owner = isBoardOwner($board_no);

if (!$is_admin && (!$is_owner && !$is_public))
{
	header("Location: contact-us.php?page_no=$page_no");
	exit(0);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>powercoolair</title>
<link href="../css/sub_page.css" rel="stylesheet" type="text/css" />
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
	window.location.href = 'estimate.php?page_no=<?=$page_no?>';
}

function deleteBoard()
{
	var form = document.forms['form-board'];
	form['board_action'].value = 'delete';
	form.submit();
}

function editBoard()
{
	window.location.href = 'estimate-edit.php?board_no=<?=$board_no?>&page_no=<?=$page_no?>';
}

function deleteBoard2()
{
	window.location.href = 'estimate-pwd.php?act=delete&board_no=<?=$board_no?>&page_no=<?=$page_no?>';
}

function editBoard2()
{
	window.location.href = 'estimate-pwd.php?act=edit&board_no=<?=$board_no?>&page_no=<?=$page_no?>';
}

function goReply()
{
	window.location.href = 'estimate-res-edit.php?board_no=<?=$board_no?>&page_no=<?=$page_no?>';
}

function editReply(resNo)
{
	window.location.href = 'estimate-res-edit.php?board_no=<?=$board_no?>&page_no=<?=$page_no?>&res_no=' + resNo;
}

function deleteReply(resNo)
{
	var form = document.forms['form-board'];
	form['res_no'].value = resNo;
	form['board_action'].value = 'delete-res';
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
						<div style="width:900px; margin-top:-5px; padding-right:25px;">
						<form name="form-board" method="post" action="estimate-action.php">
							<input type="hidden" name="board_action" value="delete">
							<input type="hidden" name="page_no" value="<?=$page_no?>">
							<input type="hidden" name="board_no" value="<?=$board_no?>">
							<input type="hidden" name="res_no">
						</form>
							<table id="board-table" style="width: 100%; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc">
								<tr>
									<th style="width: 20%">제목</th>
									<td colspan="3"><?=$board_org["title"]?></td>
								</tr>
								<tr>
									<th style="width: 20%">주문자</th>
									<td style="width: 30%"><?=$board_org["customer"]?></td>
									<th style="width: 20%">회사명</th>
									<td style="width: 30%"><?=$board_org["comp_name"]?></td>
									</td>
								</tr>
								<tr>
									<th style="width: 20%">연락처</th>
									<td style="width: 30%"><?=$board_org["phone"]?></td>
									<th style="width: 20%">E-amil</th>
									<td style="width: 30%"><?=$board_org["email"]?></td>
									</td>
								</tr>
								<tr>
									<th>첨부파일</th>
									<td colspan="3"><a href="../uploads/<?=$board_org['attached']?>"><?=$board_org["attached"]?></a></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align: left; padding: 20px 5px">
									<?=str_replace("\n", "<br/>", $board_org["contents"])?>
									</td>
								</tr>
							</table>
							<?php if (isset($resList) && count($resList) > 0) {?>
							<div style="margin: 50px 0px 10px 0px; font-size: 13px"><span class="glyphicon glyphicon-th-list"></span> 답변 리스트</div>
							<?php foreach ($resList as $res) {?>
							<table id="board-table" style="width: 100%; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc">
								<tr>
									<th style="width: 20%">작성자</th>
									<td style="width: 30%"><?=$res["user_name"]?></td>
									<th style="width: 20%">날짜</th>
									<td style="width: 30%"><?=$res["reg_date"]?></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align: left; padding: 20px 5px">
									<?=stripslashes($res["contents"])?>
									</td>
								</tr>
								<?php if ($is_admin) {?>
								<tr>
									<td colspan="4" style="text-align: right; padding: 20px 5px">
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:editReply(<?=$res['board_no']?>)">답변 수정</button>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:deleteReply(<?=$res['board_no']?>)">답변 삭제</button>
									</td>
								</tr>
								<?php }?>
							</table>
							<?php } }?>
							<table style="width: 100%; margin-top: 10px">
								<tr>
									<td style="width: 50%"><button type="button" class="btn btn-default btn-sm" onclick="javascript:goList()">목록</button></td>
									<td style="width: 50%; text-align: right">
									<?php if ($is_admin) {?>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:goReply()">답변 쓰기</button>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:deleteBoard()">원문 삭제</button>
									<?php } else if ($is_owner) {?>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:editBoard()">원문 수정</button>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:deleteBoard()">원문 삭제</button>
									<?php } else if ($is_public) {?>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:editBoard2()">원문 수정</button>
										<button type="button" class="btn btn-default btn-sm" onclick="javascript:deleteBoard2()">원문 삭제</button>
									<?php }?>
									</td>
								</tr>
							</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include "../inc/footer.php";
?>
