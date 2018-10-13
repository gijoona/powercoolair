<?php
require_once 'mysqlx.php';

Class PageDao
{
	function __construct()
	{
	}

	function getDetail($page_name)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$row = NULL;
		$sql = "select * from page_tbl where page_name='$page_name'";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function register($page_name, $contents)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into page_tbl (page_name, contents) values (?,?)");
		$stmt->bind_param('ss', $page_name, $contents);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function update($page_name, $contents)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("update page_tbl set contents=? where page_name=?");
		$stmt->bind_param('ss', $contents, $page_name);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function delete($page_name)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from page_tbl where page_name=?");
		$stmt->bind_param('s', $page_name);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function registerFile($page_name, $file_path)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into page_file_tbl (page_name, file_path) values (?,?)");
		$stmt->bind_param('ss', $page_name, $file_path);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function getFiles($page_name)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$skip = ($page-1) * $this->lpp;
		$sql = "select file_no, page_name, file_path ".
				" from page_file_tbl where page_name=$page_name";

		$rows = array();
		if ($result = $mysqli->query($sql))
		{
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($rows, $row);
			}
			$result->close();
		}

		return $rows;
	}

	function deleteFiles($page_name)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from page_file_tbl where page_name=?");
		$stmt->bind_param('s', $page_name);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}
}
?>
