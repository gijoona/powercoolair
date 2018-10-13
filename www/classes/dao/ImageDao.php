<?php
require_once 'mysqlx.php';

class ImageDao
{
	function registerTempFile($work_no, $file_path)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$sql = "insert into temp_file_tbl (work_no, file_path)" .
				" values (?,?)";
	
		$stmt = $mysqli->prepare($sql);
	
		if ($stmt === false)
			die('Statement failed: '. $mysqli->error);
	
		$rc = $stmt->bind_param('is', $work_no, $file_path);
	
		if ($rc === false)
			die('bind_param() failed: ' . $stmt->error);
	
		$rc = $stmt->execute();
	
		if ($rc === false)
			die('execute() failed: ' . $stmt->error);
	
		$result = $stmt->affected_rows;
		$stmt->close();
	
		return $result;
	}
	
	function getTempFiles($work_no)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$sql = "select file_no, work_no, file_path from temp_file_tbl where doc_no=$work_no";
	
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
	
	function deleteTempFiles($work_no)
	{
		$mysqli = new mysqlx();
	
		if (mysqli_connect_errno())
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	
		$stmt = $mysqli->prepare("delete from temp_file_tbl where work_no=?");
		$stmt->bind_param('i', $work_no);
		$stmt->execute();
	
		$result = $stmt->affected_rows;
		$stmt->close();
	
		return $result;
	}
}
?>