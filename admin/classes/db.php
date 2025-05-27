<?php
class DB
{
	private $_conn, $_query, $_res;
	function __construct($path)
	{
		$this->_conn = new PDO('sqlite:' . $path);
	}
	function Execute($query)
	{
		$sth = $this->_conn->exec($query);
		return $sth;
	}
	function Select($query)
	{
		if ($query == "")
			return -1;
		$this->_query = $query;
		$this->_res = $this->_conn->query($this->_query) or die(print_r($this->_conn->errorInfo(),true));
		return 1;
	}
	function Fetch($i)
	{
		$line = $this->_res->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT, $i);
		return $line;
	}
	function LastError()
	{
		return $this->_conn->errorInfo();
	}
	function Commit()
	{
		return $this->_conn->commit();
	}
}
?>
