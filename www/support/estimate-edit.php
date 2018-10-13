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

if ($lang == "kr")
{
	$label_orderer = "성명";
	$label_subject = "제목";
	$label_company = "회사명";
	$label_phone = "연락처";
	$label_passwrod = "비밀번호";
	$label_password2 = "비밀번호 확인";
	$label_attached = "첨부파일";
	$label_contents = "문의내용";
	$label_submit = "글올리기";
	$label_cancel = "작성취소";
	$label_delete = "삭제";
}
else
{
	$label_orderer = "Name";
	$label_subject = "Subject";
	$label_company = "Company";
	$label_phone = "Phone";
	$label_passwrod = "Password";
	$label_password2 = "Password Confirm";
	$label_attached = "Attached File";
	$label_contents = "Contents";
	$label_submit = "Submit";
	$label_cancel = "Cancel";
	$label_delete = "Delete";
}


$page_no  = isset($_REQUEST["page_no"]) ? $_REQUEST["page_no"] : 1;
$board_no = isset($_REQUEST["board_no"]) ? $_REQUEST["board_no"] : 0;

$board_org = null;
$board_action = ($board_no == 0) ? "register" : "update";

if ($board_no > 0)
{
	$dao = new EstimateDao();
	$board_org  = $dao->getDetail($board_no);
	$board_action = "update";
}

$is_admin = getUserLevel() == 1 ? true : false;

if ($board_no > 0 && !isBoardOwner($board_no))
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
	<style type="text/css">
	#board-table { width: 100%; font-size: 13px; text-align: center; border-spacing: 0; border-collapse: collapse; margin-top: 4px; color: #555}
	#board-table .body-cell { text-align: left; }
	#board-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#board-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px; text-align: left; padding: 0px 5px }
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

	function deleteFile()
	{
		var form = document.forms["form-board"];
		form.update_file.value = 1;

		$('#div_file_name').hide();
		$('#div_file_edit').show();
	}

	function cancelEdit()
	{
		window.location.href = 'estimate.php?page_no=<?=$page_no?>';
	}

	function submit()
	{
		var form = document.forms['form-board'];


		if (form['title'].value.length == 0)
		{
			alert('제목을 입력해 주세요');
			 form['title'].focus();
			return;
		}

		if (form['contents'].value.length == 0)
		{
			alert('상담 내용을 입력해 주세요');
			form['contents'].focus();
			return;
		}

		if (form['customer'].value.length == 0)
		{
			alert('이름을 입력해 주세요');
			form['customer'].focus();
			return;
		}

		if (form['email'].value.length == 0)
		{
			alert('이메일을 입력해 주세요');
			form['email'].focus();
			return;
		}

		if (form['passwd'].value.length == 0)
		{
			alert('비밀번호를 입력해 주세요');
			form['passwd'].focus();
			return;
		}

		if (form['phone'].value.length == 0)
		{
			alert('연락처를 입력해 주세요');
			form['passwd'].focus();
			return;
		}

		if (form['passwd'].value != form['passwd2'].value)
		{
			alert('비밀번호가 일치하지 않습니다. 다시 확인해 주십시오.');
			form['passwd2'].focus();
			return;
		}

		form.submit();
	}
	</script>
</head>
<body>
	<?php
	include "../inc/header.php";
	?>
	<div id="body-wrap">
		<div class="subContainer">
			<?php
			include "../inc/subMenu_support.php";
			?>
            <div class="cus_subCont">
			<div id="content">
				<div style="width:900px; position:absolute; top:-6px; right:0; padding-right:25px;">
						<form name="form-board" method="post" action="estimate-action.php" enctype="multipart/form-data">
							<input type="hidden" name="board_action" value="<?=$board_action?>">
							<input type="hidden" name="update_file" value="0">
							<input type="hidden" name="board_no" value="<?=$board_no?>">
							<table id="board-table" style="width: 100%; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc">
								<tr>
									<th style="width: 20%"><?=$label_subject?></th>
									<td colspan="3" style="width: 80%">
										<input type="text" name="title" style="width: 540px" value="<?=$board_org['title']?>">
									</td>
								</tr>
								<tr>
									<th style="width: 20%"><?=$label_orderer?></th>
									<td style="width: 30%">
										<input type="text" name="customer" maxlength="25" value="<?=$board_org['customer']?>"></td>
										<th style="width: 20%"><?=$label_company?></th>
										<td style="width: 30%">
											<input type="text" name="comp_name" maxlength="25" value="<?=$board_org['comp_name']?>">
										</td>
									</tr>
									<tr>
										<th><?=$label_phone?></th>
										<td>
											<input type="text" name="phone" maxlength="20" value="<?=$board_org['phone']?>"></td>
											<th>E-amil</th>
											<td>
												<input type="text" name="email" maxlength="50" value="<?=$board_org['email']?>">
											</td>
										</tr>
										<tr>
											<th><?=$label_passwrod?></th>
											<td>
												<input type="password" name="passwd" maxlength="10"></td>
												<th><?=$label_password2?></th>
												<td>
													<input type="password" name="passwd2" maxlength="10"></td>
												</tr>
												<tr>
													<th><?=$label_attached?></th>
													<td colspan="3">
														<?php if ($board_org && $board_org["attached"] != null) {?>
															<div id="div_file_name"><?=$board_org["attached"]?> <a href="javascript:deleteFile()"><?=$label_delete?></a></div>
															<div id="div_file_edit" class="attachedFile" style="display: none"><input  type="file" name="attached_file"></div>
															<?php } else {?>
																<div id="div_file_name" style="display: none"><?=$board_org["attached"]?> <a href="javascript:deleteThumb()"><?=$label_delete?></a></div>
																<div id="div_file_edit"><input type="file" name="attached_file"></div>
																<?php }?>
															</td>
														</tr>
														<tr>
															<th><?=$label_contents?></th>
															<td colspan="3" style="width: 100%; text-align: left; padding: 20px 5px">
																<textarea rows="8" name="contents" style="width: 540px"><?=$board_org['contents']?></textarea>
															</td>
														</tr>
													</table>
												</form>
												<table style="width: 100%; margin-top: 10px">
													<tr>
														<td style="width: 50%"></td>
														<td style="width: 50%; text-align: right"><button type="button" class="btn btn-default btn-sm" onclick="javascript:submit()"><?=$label_submit?></button>
															<button type="button" class="btn btn-default btn-sm" onclick="javascript:cancelEdit()"><?=$label_cancel?></button>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
                            </div>
							<?php
							include "../inc/footer.php";
							?>
