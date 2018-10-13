<?php
require_once '../classes/common/config.php';
require_once '../classes/common/session_helper.php';
require_once '../classes/dao/BoardDao.php';

$is_login = isLogin();
// if (!$is_login)
// {
// 	header("Location: news.php");
// 	exit();
// }

$main_menu = 5;
$sub_menu = 1;
$board_no = isset($_GET["board_no"]) ? $_GET["board_no"] : 0;
$page_no  = isset($_GET["page_no"]) ? $_GET["page_no"] : 1;

date_default_timezone_set("Asia/Seoul");
$work_no  = date("U");

$row = null;
if ($board_no > 0)
{
	$newsDao = new BoardDao();
	$row = $newsDao->getDetail($board_no);
	$board_action = "update";
}
else
{
	$board_action = "register";
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
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="../ckeditor/ckeditor.js"></script>
	<style type="text/css">
	#board-table { width: 100%; font-size: 12px; text-align: left; border-spacing: 0; border-collapse: collapse; margin-top: 15px; color: #555}
	#board-table .body-cell { text-align: left; }
	#board-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#board-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px; padding: 0px 5px }

	#order-table { width: 100%; font-size: 12px; text-align: left; border-spacing: 0; border-collapse: collapse; margin-top: 15px; color: #555}
	#order-table th { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: #eee; height: 36px; text-align: center }
	#order-table td { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; height: 36px; padding: 0px 5px }

	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">

	var docNo = <?=$work_no?>;

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

		CKEDITOR.on('instanceReady', function(evt) {

			var editor = evt.editor;
			editor.document.getHead().appendHtml('<meta charset="utf-8">');

			$('#cke_editor1').css('width', '100%');
			//$('#cke_editor1').css('height', '500px');
		});

		var uploadFile = document.getElementById('user_file');
		uploadFile.addEventListener('change', handleFileChange, false);
	});

	$(window).resize( function() {

		resizeLayout();

	});

	function cancelEdit()
	{
		<?php if ($board_no > 0) {?>
			window.location.href = 'news-view.php?page_no=' + <?=$page_no?> + '&board_no=' + <?=$board_no?>;
			<?php } else {?>
				window.location.href = 'news.php?page_no=' + <?=$page_no?>;
				<?php }?>
			}

			function submit()
			{
				var form = document.forms['form-board'];
				var contents = CKEDITOR.instances.editor1.getData();
				form.contents.value = contents;

				if (form.title.value.length == 0)
				{
					alert('제목을 입력해 주십시오.');
					return;
				}

				if (form.title.value.length > 50)
				{
					alert('제목은 50글자 이내여야 합니다.');
					return;
				}

				if (form.contents.value == '')
				{
					alert('내용을 입력해 주십시오.');
					return;
				}
				form.submit();
			}

			function uploadFile(file)
			{
				var formData = new FormData();
				formData.append('attached_file', file);
				formData.append('work_no', docNo);

				var url = '<?=$file_upload_url?>';

				$.ajax({
					url: url,
					data: formData,
					processData: false,
					contentType: false,
					type: 'POST',
					success: function(xmlDoc) {
						var element = $(xmlDoc).find('result')[0];
						var result = element.attributes[0].nodeValue;

						if (result == '0')
						{
							var fileUrl = $(xmlDoc).find('fileUrl')[0].textContent;
							//var fileId  = $(xmlDoc).find('fileId')[0].textContent;
							var fileId = '1';

							var html = '<img id="upload_image_' + fileId + '" src="' + fileUrl + '">';
							CKEDITOR.instances.editor1.insertHtml(html);
						}
						else
						{
							alert('failed');
						}
					},
					error: function(req, status, error) {
						alert('error: ' + error);
					}
				});
			}

			function showResourceFinder()
			{
				var uploadFile = document.getElementById('user_file');
				uploadFile.click();
			}

			function handleFileChange(e)
			{
				var files = e.target.files;

				for (var i = 0; i < files.length; i++)
				{
					var file = files[i];
					uploadFile(file);
				}
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
				<div class="cus_subCont" style="padding-right:25px; margin-top:-5px;">
						<form name="form-board" method="post" action="../classes/common/BoardAction.php">
							<input type="hidden" name="work_no" value="<?=$work_no?>">
							<input type="hidden" name="board_no" value="<?=$board_no?>">
							<input type="hidden" name="page_no" value="<?=$page_no?>">
							<input type="hidden" name="board_action" value="<?=$board_action?>">
							<input type="hidden" name="board_type" value="news">
							<input type="hidden" name="contents">
							<table id="board-table" style="width: 100%; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc">
								<tr>
									<th style="width: 20%">제목</th>
									<td style="text-align: left; padding: 0px 5px"><input type="text" name="title" value="<?=$row['title']?>" style="width: 400px"></td>
								</tr>
								<tr>
									<td colspan="2" style="text-align: left; padding: 0; margin-top: 5px">
										<div id="divEditor" style="background-color: white; width:100%;">
											<textarea cols="80" id="editor1" name="editor1" rows="20">
												<?=stripslashes($row['contents'])?>
											</textarea>
											<script>

											CKEDITOR.replace( 'editor1', {
												fullPage: true,
												allowedContent: true,
												extraPlugins: 'wysiwygarea,adresource',
												language: 'ko',
												width: '100%',
												height: '400px',

												toolbar: [
													{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'NewPage', 'Preview', 'Print' ] },
													{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
													{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
													{ name: 'insert', items: [ 'AdResource', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar' ] },
													'/',
													{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
													{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
													{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
													'/',
													{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
													{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
													{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
													{ name: 'others', items: [ '-' ] },
													{ name: 'about', items: [ 'About' ] }
												],

												// Toolbar groups configuration.
												toolbarGroups: [
													{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
													{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
													{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
													{ name: 'insert' },
													//{ name: 'forms' },
													'/',
													{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
													{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
													{ name: 'links' },
													'/',
													{ name: 'styles' },
													{ name: 'colors' },
													{ name: 'tools' },
													{ name: 'others' },
													{ name: 'about' }
												]
											});
											</script>
										</div>
										<!-- end of divEditor -->
									</td>
								</tr>
							</table>
						</form>
						<table style="width: 100%; margin-top: 10px">
							<tr>
								<td style="width: 50%"></td>
								<td style="width: 50%; text-align: right"><button type="button" class="btn btn-default btn-sm" onclick="javascript:submit()">글올리기</button>
									<button type="button" class="btn btn-default btn-sm" onclick="javascript:cancelEdit()">작성취소</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div id="divHidden" style="display:none">
					<form name="fileForm" method="post">
						<input id="user_file" type="file" name="user_file" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
include "../inc/footer.php";
?>
