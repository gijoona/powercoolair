<?php
require_once '../classes/common/config.php';
require_once '../classes/common/session_helper.php';
require_once '../classes/dao/PageDao.php';

$page_name = $_GET["page_name"];
$main_menu = 7;

$lang = getLanguage();

if (isset($_GET["lang"]))
{
  $lang = $_GET["lang"];
  setLanguage($lang);
}

if ($page_name == "catalog" || $page_name == "catalog_en")
$sub_menu = 1;
else if ($page_name == "tech-data" || $page_name == "tech-data_en")
$sub_menu = 2;

date_default_timezone_set("Asia/Seoul");
$work_no  = date("U");

$dao = new PageDao();
$row = $dao->getDetail($page_name);
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>powercoolair</title>
  <link href="../css/sub_page.css" rel="stylesheet" type="text/css" />
  <link href="../css/business.css" rel="stylesheet" type="text/css" />
  <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
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

    var uploadFile = document.getElementById('user_file');
    uploadFile.addEventListener('change', handleFileChange, false);
  });

  $(window).resize( function() {

    resizeLayout();

  });

  function showEditor()
  {
    $('#content-container').hide();
    $('#editor-container').show();
  }

  function hideEditor()
  {
    $('#content-container').show();
    $('#editor-container').hide();
  }

  function submitPage()
  {
    var form = document.forms['form-page'];
    var contents = CKEDITOR.instances.editor1.getData();
    form.contents.value = contents;

    if (form.contents.value == '')
    {
      alert('내용을 입력해 주십시오.');
      return;
    }

    form.submit();
  }

  function uploadFile(file)
  {
    var docNo = <?=$work_no?>;
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
        alert(status);
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
    <div class="cus_subCont">
      <!-- <div id="content">
        <div id="content-frame">
          <div id="content-wrap">
            <div id="content-container" style="width:682px; margin: 24px 0 100px 0; padding-left: 20px"> -->
              <?= stripslashes($row["contents"])?>
              <?php if (isLogin() == true && getUserLevel() == 1) {?>
                <div style="text-align: right; margin-top: 20px">
                  <button type="button" class="btn btn-default btn-sm" onclick="javascript:showEditor()">편집</button>
                </div>
                <?php }?>
              </div>
              <div id="editor-container" style="width:672px; margin: 24px 0 100px 0; padding-left: 30px; display: none">
                <form name="form-page" method="post" action="../classes/common/PageAction.php">
                  <input type="hidden" name="work_no" value="<?=$work_no?>">
                  <input type="hidden" name="contents">
                  <input type="hidden" name="page_name" value="<?=$page_name?>">
                  <input type="hidden" name="board_action" value="update">
                  <input type="hidden" name="return_url" value="/practice/pages/downloads.php?page_name=<?=$page_name?>">
                  <textarea name="editor1" id="editor1" cols="80" rows="10"><?= stripslashes($row["contents"])?></textarea>
                  <script type="text/javascript">
                  CKEDITOR.replace('editor1', {
                    width: '100%',
                    height: '400px',
                    contentsCss: ['../css/sub_page.css'],
                    extraPlugins: 'adresource',
                    allowedContent: true,
                    removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,PasteFromWord,PasteText,Language,Iframe,SelectAll,SpellChecker',
                  });
                  </script>
                </form>
                <div style="text-align: right; margin-top: 20px">
                  <button type="button" class="btn btn-default btn-sm" onclick="javascript:hideEditor()">취소</button>
                  <button type="button" class="btn btn-default btn-sm" onclick="javascript:submitPage()">저장</button>
                </div>
              </div>
              <div id="divHidden" style="display:none">
                <form name="fileForm" method="post">
                  <input id="user_file" type="file" name="user_file" />
                </form>
              <!-- </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
    <?php
    include "../inc/footer.php";
    ?>
