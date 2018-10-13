<?php
require_once 'mysqlx.php';

Class NewsDao
{
	var $lpp;

	function __construct()
	{
		$this->lpp = 10;
	}

	function getList($pageNo)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$skip = ($pageNo-1) * $this->lpp;
		$sql = "select board_no, title, n.user_id, u.user_name, DATE_FORMAT(n.reg_date, \"%Y-%m-%d\") as reg_date, " .
				" TIMESTAMPDIFF(HOUR, n.reg_date, now()) as diff_hour, n.hit_count ".
				" from news_tbl n, user_tbl u" .
				" where n.user_id=u.user_id " .
				" order by board_no desc limit $skip, $this->lpp";

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

	function getPageCount()
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$pageCount = 1;
		$sql = "select count(*) as cnt from news_tbl";

		if ($result = $mysqli->query($sql))
		{
			if ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$cnt = $row['cnt'];
				$pageCount = (int)(($cnt + $this->lpp - 1) / $this->lpp);
			}
			$result->close();
		}

		return $pageCount;
	}

	function getDataCount()
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$dataCount = 0;
		$sql = "select count(*) as cnt from news_tbl";

		if ($result = $mysqli->query($sql))
		{
			if ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$dataCount = $row['cnt'];
			}
			$result->close();
		}

		return $dataCount;
	}

	function getDetail($boardNo)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$row = NULL;
		$sql = "select n.*, u.user_name from news_tbl n, user_tbl u where n.user_id = u.user_id and board_no=$boardNo";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function register($title, $contents, $user_id)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into news_tbl (title, contents, user_id) values (?,?,?)");
		$stmt->bind_param('sss', $title, $contents, $user_id);
		$stmt->execute();

		$result = $mysqli->insert_id;
		$stmt->close();

		return $result;
	}

	function update($board_no, $title, $contents)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("update news_tbl set title=?, contents=? where board_no=?");
		$stmt->bind_param('ssi', $title, $contents, $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function delete($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from news_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function registerFile($board_no, $file_path)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into news_file_tbl (board_no, file_path) values (?,?)");
		$stmt->bind_param('is', $board_no, $file_path);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function getFiles($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$skip = ($page-1) * $this->lpp;
		$sql = "select file_no, board_no, file_path ".
				" from news_file_tbl where board_no=$board_no";

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
	
	function deleteFiles($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from news_file_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}
}
?>
