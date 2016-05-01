<?php

class Factory {
	private static $params = null;
	private static $userID = null;

    /**
     * @static
     * @return Params
     */
	public static function getParams()
	{
		
		if( is_null( self::$params  ) )
		{
			self::$params = new Params();
		}
		return self::$params;
	}

    /**
     * @static
     * @return int
     */
	public static function getUserID()
	{

		if( is_null( self::$userID  ) )
		{
            $result = DAL::getUserId();
            self::$userID = $result[0]['id'];
		}
		return self::$userID;
	}

	/**
     * @static
     * @return Database
     */
	public static function getDataUtil() {
		return new Database(Config::$hostName, Config::$userName, Config::$password, Config::$databaseName);
	}

	/**
     * @param $spName
     * @return SP
     */
	public static function createStoredProcedureCall($spName) {
		return new SP($spName);
	}


}