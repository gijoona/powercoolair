<?php
function isLogin()
{
	if(!isset($_SESSION))
		session_start();

	if (isset($_SESSION["user_id"]))
		return true;
	else
		return false;
}

function getLanguage()
{
	if (!isset($_SESSION))
		session_start();

	if (isset($_SESSION["language"]))
		return $_SESSION["language"];
	else
		return "kr";
}
function setLanguage($language)
{
	if (!isset($_SESSION)){
		session_start();
		$_SESSION["language"] = $language;
	}else{
		$_SESSION["language"] = $language;
	}
}

function getUserLevel()
{
	if(!isset($_SESSION))
		session_start();

	$userLevel = 3;

	if (isset($_SESSION["user_level"]))
		$userLevel = (int)$_SESSION["user_level"];

	return $userLevel;
}

function getUserId()
{
	if(!isset($_SESSION))
		session_start();

	return 	$_SESSION["user_id"];
}

function getUserName()
{
	if(!isset($_SESSION))
		session_start();

	return 	$_SESSION["user_name"];
}

function setUser($userId, $userName, $userLevel)
{
	if(!isset($_SESSION))
		session_start();

	$_SESSION["user_id"]    = $userId;
	$_SESSION["user_name"]  = $userName;
	$_SESSION["user_level"] = $userLevel;
}

function setPage($doc, $page)
{
	if(!isset($_SESSION))
		session_start();

	$key = "page-" . $doc;
	$_SESSION[$key] = $page;
}

function getPage($doc)
{
	if(!isset($_SESSION))
		session_start();

	$key = "page-" . $doc;
	return $_SESSION[$key];
}

function isBoardOwner($boardNo)
{
	if(!isset($_SESSION))
		session_start();

	$key = "ownerOf" . $boardNo;
	if (isset($_SESSION[$key]))
		return 1;
	else
		return 0;
}

function setBoardOwner($boardNo)
{
	if(!isset($_SESSION))
		session_start();

	$key = "ownerOf" . $boardNo;
	$_SESSION[$key] = '1';
}

function isResOwner($resNo)
{
	if(!isset($_SESSION))
		session_start();

	$key = "ownerOf2" . $resNo;
	if (isset($_SESSION[$key]))
		return 1;
	else
		return 0;
}

function setResOwner($resNo)
{
	if(!isset($_SESSION))
		session_start();

	$key = "ownerOf2" . $resNo;
	$_SESSION[$key] = '1';
}

function setErrorCode($error_code)
{
	if(!isset($_SESSION))
		session_start();

	$_SESSION["error"] = $error_code;
}

function getErrorCode()
{
	if(!isset($_SESSION))
		session_start();

	$error_code = (int)$_SESSION["error"];
	$_SESSION["error"] = "0";
	unset($_SESSION["error"]);

	return  $error_code;
}

function getErrorMessage($errorCode)
{
	$message = "Unknown Error";

	if ($errorCode == 1)
	{
		$message = "사용자 이름이 일치하지 않습니다.";
	}
	else if ($errorCode == 2)
	{
		$message = "비밀번호가 일치하지 않습니다.";
	}
	else if ($errorCode == 3)
	{
		$message = "권한이 존재하지 않습니다.";
	}
	else if ($errorCode == 4)
	{
		$message = "잘못된 요청입니다.";
	}
	else if ($errorCode == 5)
	{
		$message = "사용자 이름 또는 비밀번호가 일치하지 않습니다.";
	}

	return $message;
}
?>
