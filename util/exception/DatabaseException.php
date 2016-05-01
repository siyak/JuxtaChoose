<?php
class DatabaseException extends Exception
{
	public function __construct($message)
	{
		if($message == null) $message = mysql_error(); 
		parent::__construct($message);
	}
}