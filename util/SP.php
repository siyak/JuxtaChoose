<?php
function escape($strToken)
{
	return mysql_real_escape_string($strToken);
}

class SP
{
	private $storedProcedureName;
	private $srtfProcedureType;

	private $parameters = array();

	public function __construct($storedProcedureName)
	{
		$this->storedProcedureName = $storedProcedureName;
	}
	
	public function getProcedureType()
	{
		return $this->srtfProcedureType;
	}	
	
	public function addParam($paramName, $paramValue)
	{
		if($paramValue === '' && !is_null($paramValue))
		{
			$paramValue = null;
		}
		if($paramName == null || empty($paramName))
			throw new Exception("Empty parameter name");
		$this->parameters[$paramName] = $paramValue;
	}

	public function getParam ( $paramName )
	{
		$returnValue = NULL;
		if( $paramName!=='' && array_key_exists( $paramName , $this->parameters ))
		{
			$returnValue = $this->parameters[$paramName];
		}
		return $returnValue;
	}
	
	public function getAllParams(){
	    return $this->parameters;
	}
	
	public function getStatement()
	{
		if($this->storedProcedureName == null || empty($this->storedProcedureName))
			throw new Exception("Empty stored procedure name");
		$ret = '';
		foreach($this->parameters as $name => $value)
		{
			if(is_null($value))
				$ret = $ret.', @'.$name.':= null';
			else if(preg_match('/^-?[\d]{1,5}$/', $value) | is_bool($value))
				$ret = $ret.', @'.$name.':='.$value;
			else if(preg_match('/^-?[\d]{18}$/', $value))
				$ret = $ret.', @'.$name.':='.$value;
			else
				$ret = $ret.', @'.$name.':=N\''.escape($value).'\'';
		}
		if(strpos($ret, ',') === 0) $ret = substr($ret, 1);
		$ret = 'CALL '.$this->storedProcedureName.'('.$ret.');';
		return $ret;
	}

	public function makeParamsUnicodeSafe()
	{
		foreach($this->parameters as $paramName => $paramVal)
		{
			if( Util::isStringSet($paramVal) && !is_numeric($paramVal) && (utf8_encode(utf8_decode($paramVal)) != $paramVal) )
			{
				$this->parameters[$paramName] = iconv("UTF-8", "ISO-8859-1//IGNORE", $paramVal);
			}
		}
	}

	public function getStoredProcedureName()
	{
		return $this->storedProcedureName;
	}
}