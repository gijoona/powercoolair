<?php
require_once 'mysqlx.php';

class EstimateDao
{
	var $lpp;

	function __construct()
	{
		$this->lpp = 10;
	}

	function getList($page_no)
	{
		$dataCount = $this->getDataCount();
		if ($page_no > 1)
			$dataCount = $dataCount - (($page_no-1) * $this->lpp);

		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$skip = ($page_no-1) * $this->lpp;
		$sql = "select board_no, title, customer, DATE_FORMAT(e.reg_date, \"%Y-%m-%d\") as reg_date," .
				" TIMESTAMPDIFF(HOUR, e.reg_date, now()) as diff_hour,".
				" (select count(*) from estimate_res_tbl r where r.org_board_no=e.board_no) as res_cnt" .
				" from estimate_tbl e" .
				" order by board_no desc limit $skip, $this->lpp";

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
		$sql = "select count(*) as cnt from estimate_tbl";

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

	function getDataCount()
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$dataCount = 0;
		$sql = "select count(*) as cnt from estimate_tbl";

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
		$sql = "select * from estimate_tbl where board_no=$boardNo";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function checkUser($board_no, $user_name, $passwd)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$row = NULL;
		$sql = "select count(*) cnt from estimate_tbl where board_no=$board_no and customer='$user_name' and passwd='$passwd'";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row["cnt"] == 0 ? false : true;
	}

	function register($title, $comp_name, $customer, $passwd, $phone, $email, $attached, $contents)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into estimate_tbl (title, comp_name, customer, passwd, phone, email, attached, contents) values (?,?,?,?,?,?,?,?)");
		$stmt->bind_param('ssssssss', $title, $comp_name, $customer, $passwd, $phone, $email, $attached, $contents);
		$stmt->execute();

		$result = $mysqli->insert_id;
		$stmt->close();

		return $result;
	}

	function update($board_no, $title, $comp_name, $customer, $passwd, $phone, $email, $attached, $contents)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$sql  = "update estimate_tbl set title=?, comp_name=?, customer=?, passwd=?, phone=?, email=?, attached=?, contents=?" .
				" where board_no=?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ssssssssi', $title, $comp_name, $customer, $passwd, $phone, $email, $attached, $contents, $board_no);
		$stmt->execute();

		$result = $mysqli->affected_rows;
		$stmt->close();

		return $result;
	}

	function delete($board_no)
	{
		$this->deleteResByBoardNo($board_no);
		$this->deleteBoard($board_no);
	}

	function deleteBoard($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from estimate_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function getResList($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$sql = "select n.board_no, n.contents, n.user_id, u.user_name, n.reg_date, " .
				" TIMESTAMPDIFF(HOUR, n.reg_date, now()) as diff_hour".
				" from estimate_res_tbl n, user_tbl u where n.user_id=u.user_id and org_board_no=$board_no" .
				" order by board_no";

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

	function getResDetail($boardNo)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$row = NULL;
		$sql = "select * from estimate_res_tbl where board_no=$boardNo";

		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		return $row;
	}

	function registerRes($board_no, $contents, $user_id)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("insert into estimate_res_tbl (org_board_no, contents, user_id) values (?,?,?)");
		$stmt->bind_param('iss', $board_no, $contents, $user_id);
		$stmt->execute();

		$result = $mysqli->insert_id;
		$stmt->close();

		return $result;
	}

	function updateRes($res_no, $board_no, $contents, $user_id)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("update estimate_res_tbl set contents=?, org_board_no=?, user_id=? where board_no=?");
		$stmt->bind_param('sisi', $contents, $board_no, $user_id, $res_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function deleteRes($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from estimate_res_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}

	function deleteResByBoardNo($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$stmt = $mysqli->prepare("delete from estimate_res_tbl where org_board_no=?");
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

		$stmt = $mysqli->prepare("insert into estimate_file_tbl (board_no, file_path) values (?,?)");
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
				" from estimate_file_tbl where board_no=$board_no";

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

	function getFilesByBoardNo($board_no)
	{
		$mysqli = new mysqlx();

		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$sql =  "select f.file_no, f.board_no, f.file_path ".
				"  from estimate_file_tbl f, estimate_res_tbl r".
				" where r.board_no=f.board_no and r.org_board_no=$board_no";

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

		$stmt = $mysqli->prepare("delete from estimate_file_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();

		$result = $stmt->affected_rows;
		$stmt->close();

		return $result;
	}
}
?>
