<?php
	require_once 'classes/common/session_helper.php';
	require_once 'classes/dao/UserDao.php';

	session_start();

	$userDao = new UserDao();

	if ($_POST["login-action"] == 1 && isset($_POST["user_id"]) && isset($_POST["passwd"]))
	{
		$from = isset($_POST["from"]) ? $_POST["from"] : 1;
		$user_id = $_POST["user_id"];
		$passwd  = $_POST["passwd"];

		$row = $userDao->getUserByIdAndPwd($user_id, $passwd);

		if ($row)
		{
			$is_login = true;

			if ($row["user_level"] == 1)
				$is_admin = true;

			setUser($row["user_id"], $row["user_name"], $row["user_level"]);

			header("Location: main\main.php");
			exit();
		}
		else
		{
 			if ($from == 1)
 			{
 				header("Location: main\main.php");
 				exit();
 			}
 			else
 			{
 				header("Location: main\main.php");
 				exit();
 			}
		}
	}
	else if ($_REQUEST["login-action"] == 2)
	{
		if(!isset($_SESSION))
			session_start();

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_level"]);
		unset($_SESSION["user_name"]);
		header("Location: main/main.php");
		exit();
	}
	else
	{
		header("Location: main/main.php");
		exit();
	}
?>
