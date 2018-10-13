<?php
require_once '../classes/common/config.php';
require_once '../classes/common/session_helper.php';
require_once '../classes/dao/EstimateDao.php';
require_once '../classes/dao/ImageDao.php';

$user_level = getUserLevel();
$user_id  = getUserId();
$action   = $_POST["board_action"];
if ($action == "register")
{
	$title     = $_POST["title"];
	$customer  = $_POST["customer"];
	$comp_name = $_POST["comp_name"];
	$phone     = $_POST["phone"];
	$email     = $_POST["email"];
	$passwd    = $_POST["passwd"];
	$contents  = $_POST["contents"];

	if (isset($_FILES["attached_file"]))
		$file_path = saveFile();

	$dao = new EstimateDao();
	$board_no = $dao->register($title, $comp_name, $customer, $passwd, $phone, $email, $file_path, $contents);

	header("Location: estimate.php");
	exit();
}
else if ($action == "update")
{
	$board_no  = $_POST["board_no"];
	$title     = $_POST["title"];
	$customer  = $_POST["customer"];
	$comp_name = $_POST["comp_name"];
	$phone     = $_POST["phone"];
	$email     = $_POST["email"];
	$passwd    = $_POST["passwd"];
	$contents  = $_POST["contents"];
	$update_file = $_POST["update_file"];

	$dao = new EstimateDao();
	$board_org = $dao->getDetail($board_no);
	$file_path = $board_org["attached"];

	if ($update_file == 1)
	{
		deleteAttachedFile($board_org["attached"]);
		$file_path = saveFile();
	}
	else if (isset($_FILES["attached_file"]) && $_FILES["attached_file"]["name"] != null)
	{
		$file_path = saveFile();
	}

	$dao->update($board_no, $title, $comp_name, $customer, $passwd, $phone, $email, $file_path, $contents);

	header("Location: estimate.php");
	exit();
}
else if ($action == "delete")
{
	$board_no = $_POST["board_no"];
	$page_no  = $_POST["page_no"];

	$dao = new EstimateDao();
	$data = $dao->getDetail($board_no);

	if (getUserLevel() == 1)
	{
		// 첨부파일을 삭제한다.
		if (isset($data["attached"]) && $data["attached"] != null)
			deleteAttachedFile($data["attached"]);

		// 이미지 파일을 모두 삭제한다.
		$rows = $dao->getFilesByBoardNo($board_no);
		foreach ($rows as $row)
		{
			deleteFile($row["file_path"]);
		}

		// 게시물을 삭제한다.
		$dao->delete($board_no);

		header("Location: estimate.php");
		exit();
	}
	else
	{
		header("Location: estimate-pwd.php?act=delete&board_no=$board_no&page_no=$page_no");
		exit();
	}
}

else if ($action == "register-res")
{
	if ($user_level != 1)
	{
		header("Location: estimate.php?page_no=$page_no");
		exit(0);
	}

	$work_no   = $_POST["work_no"];
	$board_no  = $_POST["board_no"];
	$contents  = $_POST["contents"];
	$page_no   = $_POST["page_no"];

	$dao = new EstimateDao();
	$res_no = $dao->registerRes($board_no, $contents, $user_id);

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
			$dao->registerFile($res_no, $file_path);
		}
	}

	// 등록된 작업 파일 목록을 삭제한다.
	$imageDao->deleteTempFiles($work_no);

	header("Location: estimate-view.php?board_no=$board_no&page_no=$page_no");
	exit();
}
else if ($action == "update-res")
{
	if ($user_level != 1)
	{
		header("Location: estimate.php?page_no=$page_no");
		exit(0);
	}

	$work_no   = $_POST["work_no"];
	$board_no  = $_POST["board_no"];
	$contents  = $_POST["contents"];
	$res_no    = $_POST["res_no"];
	$page_no   = $_POST["page_no"];

	$dao = new EstimateDao();
	$dao->updateRes($res_no, $board_no, $contents, $user_id);

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
			$dao->registerFile($res_no, $file_path);
		}
	}

	// 등록된 작업 파일 목록을 삭제한다.
	$imageDao->deleteTempFiles($work_no);

	header("Location: estimate-view.php?board_no=$board_no&page_no=$page_no");
	exit();
}
else if ($action == "delete-res")
{
	if ($user_level != 1)
	{
		header("Location: estimate.php?page_no=$page_no");
		exit(0);
	}

	$res_no  = $_POST["res_no"];
	$page_no = $_POST["page_no"];
	$board_no= $_POST["board_no"];

	$dao = new EstimateDao();
	$res_no = $dao->deleteRes($res_no);

	header("Location: estimate-view.php?board_no=$board_no&page_no=$page_no");
	exit();
}
else if ($action == "check")
{
	$user_name = $_POST["user_name"];
	$passwd = $_POST["passwd"];
	$board_no = $_POST["board_no"];
	$page_no  = $_POST["page_no"];
	$act      = $_POST["act"];

	$dao = new EstimateDao();
	if ($dao->checkUser($board_no, $user_name, $passwd))
	{
		if ($act == "view")
		{
			setBoardOwner($board_no);
			header("Location: estimate-view.php?board_no=$board_no&page_no=$page_no");
		}
		else if ($act == "delete")
		{
			$data = $dao->getDetail($board_no);

			// 첨부파일을 삭제한다.
			if (isset($data["attached"]) && $data["attached"] != null)
				deleteAttachedFile($data["attached"]);

			// 이미지 파일을 모두 삭제한다.
			$rows = $dao->getFilesByBoardNo($board_no);
			foreach ($rows as $row)
			{
				deleteFile($row["file_path"]);
			}

			$dao->delete($board_no);

			header("Location: estimate.php?page_no=$page_no");
		}
		else if ($act == "edit")
		{
			setBoardOwner($board_no);
			header("Location: estimate-edit.php?board_no=$board_no&page_no=$page_no");
		}

		exit(0);
	}
	else
	{
		setErrorCode(5);

		//echo 'aa';
		header("Location: estimate-pwd.php?act=$act&error_no=1&board_no=$board_no&page_no=$page_no");
		exit(0);
	}
}

function getFilePath($file_path)
{
	if (is_file($file_path) == false)
		return $file_path;

	$pos = strrpos($file_path, "/");
	$dir = substr($file_path, 0, $pos);
	$file_name = substr($file_path, $pos+1);

	$pos = strrpos($file_name, ".");
	$file_ext = substr($file_name, $pos+1);
	$file_name = substr($file_name, 0, $pos);

	$idx = 2;
	while (1)
	{
		$new_path = $dir . "/" . $file_name . "[" . $idx . "]." . $file_ext;
		if (is_file($new_path) == false)
			return $new_path;

		$idx++;
	}
}

function saveFile()
{
	$upload_dir = realpath("../uploads");

	$file = $_FILES["attached_file"];

	// 저장할 파일 경로를 생성한다.
	$upload_path = $upload_dir . "/" . basename($file["name"]);
	$upload_path = getFilePath($upload_path);

	// 업로드된 파일을 이동시킨다.
	if (move_uploaded_file($file["tmp_name"], $upload_path))
	{
		$pos = strrpos($upload_path, "/");
		$file_name = substr($upload_path, $pos+1);

		return $file_name;
	}

	return null;
}

function deleteAttachedFile($file_path)
{
	$filepath = realpath("../uploads/" . $file_path);
	unlink($filepath);
}

function deleteFile($file_path)
{
	$filepath = realpath($file_path);
	unlink($file_path);
}
?>
