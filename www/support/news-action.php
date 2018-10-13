<?php
require_once '../classes/common/session_helper.php';
require_once '../classes/dao/NewsDao.php';
require_once '../classes/dao/ImageDao.php';

if (isLogin() == false)
{
	header("Location: news.php");
	exit();
}

if (getUserLevel() != 1)
{
	header("Location: news.php");
	exit();
}

$user_id  = getUserId();
$action   = $_POST["board_action"];
$title    = addslashes($_POST["title"]);
$contents = $_POST["contents"];

if ($action == "register")
{
	$work_no = $_POST["work_no"];
	$newsDao = new NewsDao();
	$board_no = $newsDao->register($title, $contents, $user_id);

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

	header("Location: news.php");
	exit();
}
else if ($action == "update")
{
	$work_no = $_POST["work_no"];
	$board_no = $_POST["board_no"];
	$page_no  = $_POST["page_no"];

	$newsDao = new NewsDao();
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

	header("Location: news-view.php?page_no=$page_no&board_no=$board_no");
	exit();
}
else if ($action == "delete")
{
	$board_no = $_POST["board_no"];
	$page_no  = $_POST["page_no"];

	$newsDao = new NewsDao();
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

	header("Location: news.php?page_no=$page_no");
	exit();
}

function deleteFile($file_path)
{
	$filepath = realpath($file_path);
	unlink($file_path);
}

?>
