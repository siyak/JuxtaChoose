<?php
function dbconnect($server, $userName, $password) {
    return mysql_connect($server, $userName, $password);
}

function convertMssqlErrorToConnectException($errstr) {
    restore_error_handler();
    ExceptionFactory::throwDatabaseConnectException($errstr);
}

function convertMssqlErrorToException($errstr) {
    restore_error_handler();
    ExceptionFactory::throwDatabaseException($errstr . ": " . mysql_error());
}

function unescape($strToken) {
    return str_replace("''", "'", $strToken);
}

class Database {
    private $connectionResource;

    public function __construct($server, $userName, $password, $databaseName) {
        $this->connectionResource = dbconnect($server, $userName, $password);

        if (!$this->connectionResource) {
            $this->connectionResource = dbconnect($server, $userName, $password);
        }

        if (!$this->connectionResource) {
            set_error_handler('convertMssqlErrorToConnectException', E_WARNING);
            $this->connectionResource = dbconnect($server, $userName, $password);
            restore_error_handler();
        }

        if ($databaseName != null) {
            $this->selectDatabase($databaseName);
        }
    }

    public function selectDatabase($databaseName) {
        set_error_handler('convertMssqlErrorToConnectException', E_WARNING);
        mysql_select_db($databaseName, $this->connectionResource);
        restore_error_handler();
    }

    public function closeConnection() {
        if (is_resource($this->connectionResource)) {
            set_error_handler('convertMssqlErrorToException', E_WARNING);
            mysql_close($this->connectionResource);
            restore_error_handler();
        }
    }

    /**
     * Public for testing. Treat as protected to override
     *
     * @param  $sql
     * @return resource
     * @throws DatabaseException
     */
    private function rawExecuteQuery($sql) {
        set_error_handler('convertMssqlErrorToException', E_WARNING);
        $resultSet = mysql_query($sql, $this->connectionResource);
        if ($resultSet == false) {
            ExceptionFactory::throwDatabaseException();
        }

        restore_error_handler();
        return $resultSet;
    }

    public function executeLargeResultSet(SP $storedProcedure) {
        return $this->rawExecuteQuery($storedProcedure->getStatement());
    }

    /**
     * Enter description here...
     *
     * @param SP $storedProcedure
     * @param bool $returnArray
     * @return array
     */
    public function executeResultSet($storedProcedure, $returnArray = false) {
        $rs = $this->executeLargeResultSet($storedProcedure);
        $ret = array();
        if ($rs !== true) {
            if ($returnArray) {
                $row = mysql_fetch_array($rs);
                while ($row) {
                    $ret [] = $row;
                    $row = mysql_fetch_array($rs);
                }
            } else {
                $row = mysql_fetch_assoc($rs);
                while ($row) {
                    $ret [] = $row;
                    $row = mysql_fetch_assoc($rs);
                }
            }
        }

        return $ret;
    }

    public function executeQuery($storedProcedure, $returnArray = false) {
        $rs = $this->executeResultSet($storedProcedure, $returnArray);
        return (isset ($rs [0])) ? $rs [0] : array();
    }

    public function executeColumnarQuery($storedProcedure) {
        $rs = $this->executeResultSet($storedProcedure, true);
        $returnRs = array();
        foreach ($rs as $val) {
            $returnRs[] = Util::arrayReturn(0, $val);
        }
        return $returnRs;
    }

    public function executeScalar($storedProcedure) {
        $returnArray = TRUE;
        $return = $this->executeQuery($storedProcedure, $returnArray);
        return $this->returnFirstChildOf2DElementIfItExistsWithoutPhpWarnings($return);
    }

    private function returnFirstChildOf2DElementIfItExistsWithoutPhpWarnings($return) {
        if (isset ($return) && is_array($return)) {
            if (isset ($return [0])) {
                $returnValue = $return [0];
            } else {
                $returnValue = false;
            }
        } else {
            $returnValue = false;
        }
        return $returnValue;
    }

    public function executeUpdate($storedProcedure) {
        $this->executeQuery($storedProcedure);
    }

    public function __destruct() {
        set_error_handler('convertMssqlErrorToException', E_WARNING);
        $this->closeConnection();
        restore_error_handler();
    }

}
