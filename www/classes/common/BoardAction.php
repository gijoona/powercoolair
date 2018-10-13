<?php
require_once 'config.php';
require_once 'session_helper.php';
require_once '../dao/BoardDao.php';
require_once '../dao/ImageDao.php';

$prefix = $context;

$list_url = null;
$view_url = null;

$type = $_POST["board_type"];

if ($type == "news" || $type == 'news_en')
{
	$list_url = $context . "/support/news.php";
	$view_url = $context . "/support/news-view.php";
}
else if ($type == "c-news" || $type == 'c-news_en')
{
	$list_url = $context . "/practice/communication/company-news.php";
	$view_url = $context . "/practice/communication/company-news-view.php";
}
else if ($type == "exhibit" || $type == 'exhibit_en')
{
	$list_url = $context . "/practice/promotion/exhibition.php";
	$view_url = $context . "/practice/promotion/exhibition-view.php";
}
else if ($type == "ad")
{
	$list_url = $context . "/practice/promotion/ad.php";
	$view_url = $context . "/practice/promotion/ad-view.php";
}
if (isLogin() == false)
{
	header("Location: " . $list_url);
	exit();
}
if (getUserLevel() != 1)
{
	header("Location: " . $list_url);
	exit();
}
$user_id  = getUserId();
$action   = $_POST["board_action"];
$title    = addslashes($_POST["title"]);
$contents = $_POST["contents"];

if ($action == "register")
{
	$work_no = $_POST["work_no"];
	$newsDao = new BoardDao();
	$board_no = $newsDao->register($title, $contents, $user_id, $type);

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

	header("Location: " . $list_url);
	exit();
}
else if ($action == "update")
{
	$work_no = $_POST["work_no"];
	$board_no = $_POST["board_no"];
	$page_no  = $_POST["page_no"];

	$newsDao = new BoardDao();
	$board = $newsDao->getDetail($board_no);

	if ($board["user_id"] == $user_id)
		$newsDao->update($board_no, $title, $contents);

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

	header("Location: $view_url?page_no=$page_no&board_no=$board_no");
	exit();
}
else if ($action == "delete")
{
	$board_no = $_POST["board_no"];
	$page_no  = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;

	$newsDao = new BoardDao();
	$board = $newsDao->getDetail($board_no);

	if ($board["user_id"] == $user_id)
	{
		// 이미지 파일을 모두 삭제한다.
		$rows = $newsDao->getFiles($board_no);
		foreach ($rows as $row)
		{
			deleteFile($row["file_path"]);
		}

		// 게시물을 삭제한다.
		$newsDao->delete($board_no);
	}

	header("Location: $list_url?page_no=$page_no");
	exit();
}

function deleteFile($file_path)
{
	$filepath = realpath($file_path);
	unlink($file_path);
}
?>
