<?php
class ExceptionFactory
{
	/**
	 * Returns object of DatabaseException class
	 *
	 * @param null $message
	 * @return DatabaseException
	 * @throws DatabaseException
	 */
	public static function throwDatabaseException($message = null)
	{
		require_once("DatabaseException.php");
		throw new DatabaseException($message);
	}

	/**
	 * Returns object of DatabaseConnectException class
	 *
	 * @param null $message
	 * @return DatabaseException
	 * @throws ConnectException
	 */
	public static function throwDatabaseConnectException($message = null)
	{
		require_once("ConnectException.php");
		throw new ConnectException($message);
	}
}