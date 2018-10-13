<?php
require_once 'mysqlx.php';

class UserDao
{
	function getUserByIdAndPwd($user_id, $passwd)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			echo "fail to connect";
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$row = NULL;
		$sql = "select * from user_tbl where user_id='$user_id' and passwd=PASSWORD('$passwd')";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}
		$result->close();

		return $row;
	}
}
?>
