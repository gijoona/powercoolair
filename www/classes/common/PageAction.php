<?php
require_once 'config.php';
require_once 'session_helper.php';
require_once '../dao/PageDao.php';
require_once '../dao/ImageDao.php';

$prefix = $context;

$list_url = null;
$view_url = null;

$page_name = $_POST["page_name"];
$return_url = $_POST["return_url"];

if (isLogin() == false)
{
	header("Location: " . $return_url);
	exit();
}

if (getUserLevel() != 1)
{
	header("Location: " . $return_url);
	exit();
}

$action = $_POST["board_action"];

if ($action == "update")
{
	$work_no   = $_POST["work_no"];
	$contents  = $_POST["contents"];

	$dao = new PageDao();
	$old_page = $dao->getDetail($page_name);

	if ($old_page != null)
		$dao->update($page_name, $contents);
	else
		$dao->register($page_name, $contents);

	$imageDao = new ImageDao();
	$rows = $imageDao->getTempFiles($work_no);

	$imageDao = new ImageDao();
	$rows = $imageDao->getTempFiles($work_no);

	foreach ($rows as $row)
	{
		$file_path = $row["file_path"];
		$pos = strpos($contents, $file_path);
		if ($pos === false)
		{
			deleteFile($file_path);
		}
		else
		{
			$newsDao->registerFile($board_no, $file_path);
		}
	}

	// 등록된 작업 파일 목록을 삭제한다.
	$imageDao->deleteTempFiles($work_no);

	header("Location:  ../$return_url");
	exit();
}
else if ($action == "delete")
{
	$dao = new PageDao();
	$dao->delete($page_name);

	header("Location:  /$return_url");
	exit();
}

function deleteFile($file_path)
{
	$filepath = realpath($file_path);
	unlink($file_path);
}
?>
