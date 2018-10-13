<?php
Class mysqlx extends mysqli
{
	function __construct()
	{
		parent::__construct('localhost', 'powercoolair', 'power7367*', 'powercoolair');
	}

	function __destruct()
	{
		$this->close();
	}

	function close()
	{
		mysqli_close($this);
	}
}
?>
