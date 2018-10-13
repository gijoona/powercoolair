<?php
require_once 'mysqlx.php';

class ContactDao
{
	var $lpp;
	
	function __construct()
	{
		$this->lpp = 10;
	}
	
	function getList()
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$sql = "select n.board_no, n.contents, n.user_id, u.user_name, n.reg_date, " .
				" TIMESTAMPDIFF(HOUR, n.reg_date, now()) as diff_hour".
				" from contact_res_tbl n, user_tbl u where n.user_id=u.user_id and org_board_no=$board_no" .
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
	
	function getResList($board_no)
	{
		$mysqli = new mysqlx();
		
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$sql = "select n.board_no, n.contents, n.user_id, u.user_name, DATE_FORMAT(n.reg_date, \"%Y-%m-%d\") as reg_date, " .
				" TIMESTAMPDIFF(HOUR, n.reg_date, now()) as diff_hour".
				" from contact_res_tbl n, user_tbl u where n.user_id=u.user_id and org_board_no=$board_no" .
				" order by board_no desc";
		
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
		$sql = "select count(*) as cnt from contact_tbl";
	
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
		$sql = "select count(*) as cnt from contact_tbl";
	
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
		$sql = "select * from contact_tbl where board_no=$boardNo";
	
		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}
	
		return $row;
	}

	function getDetailRes($boardNo)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$row = NULL;
		$sql = "select * from contact_res_tbl where board_no=$boardNo";
	
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
		$sql = "select count(*) cnt from contact_tbl where board_no=$board_no and user_name='$user_name' and passwd='$passwd'";
		
		if ($result = $mysqli->query($sql))
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}
		
		return $row["cnt"] == 0 ? false : true;
	}
	
	function register($title, $contents, $user_name, $passwd, $is_public)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$stmt = $mysqli->prepare("insert into contact_tbl (title, contents, user_name, passwd, is_public) values (?,?,?,?,?)");
		$stmt->bind_param('ssssi', $title, $contents, $user_name, $passwd, $is_public);
		$stmt->execute();
	
		$result = $mysqli->insert_id;
		$stmt->close();
	
		return $result;
	}
	
	function registerRes($board_no, $contents, $user_id)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$stmt = $mysqli->prepare("insert into contact_res_tbl (org_board_no, contents, user_id) values (?,?,?)");
		$stmt->bind_param('iss', $board_no, $contents, $user_id);
		$stmt->execute();
	
		$result = $mysqli->insert_id;
		$stmt->close();
	
		return $result;
	}
	
	function update($board_no, $title, $contents, $user_name, $passwd, $is_public)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$stmt = $mysqli->prepare("update contact_tbl set title=?, contents=?, user_name=?, passwd=?, is_public=? where board_no=?");
		$stmt->bind_param('ssssii', $title, $contents, $user_name, $passwd, $is_public, $board_no);
		$stmt->execute();
	
		$result = $stmt->affected_rows;
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
	
		$stmt = $mysqli->prepare("update contact_res_tbl set contents=?, org_board_no=?, user_id=? where board_no=?");
		$stmt->bind_param('sisi', $contents, $board_no, $user_id, $res_no);
		$stmt->execute();
	
		$result = $stmt->affected_rows;
		$stmt->close();
	
		return $result;
	}
	
	function delete($board_no)
	{
		$this->deleteContactRes($board_no);
		$this->deleteContact($board_no);
	}
	
	function deleteRes($res_no)
	{
		$mysqli = new mysqlx();
		
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$stmt = $mysqli->prepare("delete from contact_res_tbl where board_no=?");
		$stmt->bind_param('i', $res_no);
		$stmt->execute();
		
		$result = $stmt->affected_rows;
		$stmt->close();
		
		return $result;
	}
	
	function deleteContact($board_no)
	{
		$mysqli = new mysqlx();
		
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$stmt = $mysqli->prepare("delete from contact_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();
		
		$result = $stmt->affected_rows;
		$stmt->close();
		
		return $result;
	}
	function deleteContactRes($board_no)
	{
		$mysqli = new mysqlx();
		
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$stmt = $mysqli->prepare("delete from contact_res_tbl where org_board_no=?");
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
	
		$stmt = $mysqli->prepare("insert into contact_file_tbl (board_no, file_path) values (?,?)");
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
				" from contact_file_tbl where board_no=$board_no";
	
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
	
		$stmt = $mysqli->prepare("delete from contact_file_tbl where board_no=?");
		$stmt->bind_param('i', $board_no);
		$stmt->execute();
	
		$result = $stmt->affected_rows;
		$stmt->close();
	
		return $result;
	}
}
?>