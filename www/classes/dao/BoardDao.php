<?php
require_once 'mysqlx.php';

Class BoardDao
{
	var $lpp;

	function __construct()
	{
		$this->lpp = 10;
	}

	function getList($pageNo, $boardType)
	{
		$dataCount = $this->getDataCount($boardType);
		if ($pageNo > 1)
			$dataCount = $dataCount - (($pageNo-1) * $this->lpp);

		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$skip = ($pageNo-1) * $this->lpp;
		$sql = "select board_no, title, n.user_id, u.user_name, DATE_FORMAT(n.reg_date, \"%Y-%m-%d\") as reg_date, " .
				" TIMESTAMPDIFF(HOUR, n.reg_date, now()) as diff_hour, n.hit_count ".
				" from board_tbl n, user_tbl u" .
				" where n.user_id=u.user_id and board_type='$boardType'" .
				" order by board_no desc limit $skip, $this->lpp";
				// $sql = "SELECT board_no, title, user_name, DATE_FORMAT(reg_date, \"%Y-%m-%d\") as reg_date, " .
				// 		" TIMESTAMPDIFF(HOUR, reg_date, now()) as diff_hour, hit_count ".
				// 		" from board_tbl" .
				// 		" where board_type='$boardType'" .
				// 		" order by board_no desc ";

		$rows = array();
		if ($result = $mysqli->query($sql))
		{
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$row["no"] = $dataCount--;
				array_push($rows, $row);
			}
			$result->close();
		}
		// $result = $mysqli->query($sql);
		// $row = $result->fetch_array(MYSQLI_ASSOC);
		// printf("Connect failed: %s\n", $row);
		// exit();
		return $rows;

	}

	function getListOfMain($lang)
	{
		$mysqli = new mysqlx();

		$boardType1 = $lang == 'en' ? 'exhibit_en' : 'exhibit';
		$boardType2 = $lang == 'en' ? 'news_en' : 'news';

		$sql = "select board_no, title, board_type, DATE_FORMAT(reg_date, \"%Y-%m-%d\") as reg_date, " .
				" TIMESTAMPDIFF(HOUR, reg_date, now()) as diff_hour, hit_count ".
				" from board_tbl" .
				" where board_type='$boardType1' or board_type='$boardType2'" .
				" order by board_no desc limit 0, 5";

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

	function getPageCount($boardType)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$pageCount = 1;
		$sql = "select count(*) as cnt from board_tbl where board_type='$boardType'";

		if ($result = $mysqli->query($sql))
		{
			if ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$cnt = $row['cnt'];
				$pageCount = (int)(($cnt + $this->lpp - 1) / $this->lpp);
			}
			$result->close();
		}

		return $pageCount == 0 ? 1 : $pageCount;
	}

	function getDataCount($boardType)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$dataCount = 0;
		$sql = "select count(*) as cnt from board_tbl where board_type='$boardType'";

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

		$sql = "update board_tbl set hit_count = hit_count+1 where board_no=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $boardNo);
		$stmt->execute();
		$stmt->close();

		$row = NULL;
		$sql = "select n.*, u.user_name from board_tbl n, user_tbl u where n.user_id = u.user_id and board_no=$boardNo";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function getNextArticle($board_no, $board_type)
	{
		$mysqli = new mysqlx();
		$row = NULL;

		$sql = "select board_no, title from board_tbl" .
			   " where board_no = (select min(board_no) from board_tbl where board_no > $board_no and board_type='$board_type')";
//echo $sql;
		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function getPrevArticle($board_no, $board_type)
	{
		$mysqli = new mysqlx();
		$row = NULL;

		$sql = "select board_no, title from board_tbl" .
				" where board_no = (select max(board_no) from board_tbl where board_no < $board_no and board_type='$board_type')";
		//echo $sql;
		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function register($title, $contents, $user_id, $board_type)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into board_tbl (title, contents, user_id, board_type) values (?,?,?,?)");
		$stmt->bind_param('ssss', $title, $contents, $user_id, $board_type);
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

		$stmt = $mysqli->prepare("update board_tbl set title=?, contents=? where board_no=?");
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

		$stmt = $mysqli->prepare("delete from board_tbl where board_no=?");
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

		$stmt = $mysqli->prepare("insert into board_file_tbl (board_no, file_path) values (?,?)");
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
				" from board_file_tbl where board_no=$board_no";

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

		$stmt = $mysqli->prepare("delete from board_file_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}
}
?>
