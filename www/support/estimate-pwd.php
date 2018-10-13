<?php
require_once '../classes/dao/ContactDao.php';
require_once '../classes/common/session_helper.php';

$main_menu = 6;
$sub_menu = 4;

$page_no  = isset($_REQUEST["page_no"]) ? $_REQUEST["page_no"] : 1;
$board_no = $_REQUEST["board_no"];
$act = $_REQUEST["act"];
$error_no = $_GET["error_no"];
$error_msg = null;
if ($error_no == 1)
$error_msg = "이름 또는 비밀번호가 일치하지 않습니다.";

$dao = new ContactDao();
$board_org  = $dao->getDetail($board_no);
$board_res  = $dao->getDetailRes($board_no);

$is_admin = getUserLevel() == 1 ? true : false;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>powercoolair</title>
	<link href="../css/sub_page.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
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

		<?php if ($error_no >= 1) {?>
			alert('<?=$error_msg?>');
			<?php }?>
		});

		$(window).resize( function() {
			resizeLayout();
		});

		function goBack()
		{
			window.location.href = 'estimate.php?page_no=' + <?=$page_no?>;
		}

		function submit()
		{
			var form = document.forms['form-pwd'];
			if (form['user_name'].value.length == 0)
			{
				alert('사용자 이름을 입력해 주세요');
				return;
			}

			if (form['user_name'].value.length > 30)
			{
				alert('사용자 이름은 30글자 이내여야 합니다.');
				return;
			}

			if (form['passwd'].value.length == 0)
			{
				alert('비밀번호를 입력해 주세요');
				return;
			}

			if (form['passwd'].value.length > 30)
			{
				alert('비밀번호는 30글자 이내여야 합니다.');
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
		<div class="subContainer">
			<?php
			include "../inc/subMenu_customer.php";
			?>
			<div class="cus_subCont">
				<div id="content">
					<div style="width:682px; margin: 34px 0 100px 0; padding-left: 20px">
								<div class="sheet" style="margin-top: 36px; text-align: center">
									<form name="form-pwd" method="post" action="estimate-action.php">
										<input type="hidden" name="page_no" value="<?=$page_no?>">
										<input type="hidden" name="board_no" value="<?=$board_no?>">
										<input type="hidden" name="board_action" value="check">
										<input type="hidden" name="act" value="<?=$act?>">
										<div style="margin-top: 100px">If you want to continue, Enter name and password</div>
										<table id="board-table" style="width: 300px; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc; margin:10px auto;">
											<tr>
												<th style="width: 30%">Name</th>
												<td style="text-align: left; padding: 0px 5px">
													<input type="text" name="user_name" style="border: 1px solid #ccc; width: 180px">
												</td>
											</tr>
											<tr>
												<th style="width: 30%">Password</th>
												<td style="width: 70%; text-align: left; padding: 0px 5px">
													<input type="password" name="passwd" style="border: 1px solid #ccc; width: 180px">
												</td>
											</tr>
										</table>
									</form>
									<table style="width: 300px; margin-top: 10px; margin-left: auto; margin-right: auto; margin-top: 20px">
										<tr>
											<td style="width: 100%; text-align: right"><button type="button" class="btn btn-default btn-sm" onclick="javascript:submit()">Confirm</button>
												<button type="button" class="btn btn-default btn-sm" onclick="javascript:goBack()">Back</button></td>
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
