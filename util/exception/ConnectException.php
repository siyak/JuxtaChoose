<?php
require_once("DatabaseException.php");

class ConnectException extends DatabaseException
{
	public function __construct($message)
	{
		parent::__construct($message);
	}	
}
