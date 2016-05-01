<?php
error_reporting(E_ALL);

function customErrorHandler($errno) {

    if ($errno == E_RECOVERABLE_ERROR || $errno == E_ERROR) {
        throw new Exception("ErrorHandledException");
    } else
        return true;
}

set_error_handler("customErrorHandler");
class Config {

    const local = 1;

    public static $hostName;
    public static $thisSetup;
    public static $dbSetup;
    public static $databaseName;
    public static $userName;
    public static $password;

    public function __construct() {
        /*if(self::local==0){
            require_once("../../includes/config.php");
            require_once(FUNCTION_DIR . "general.functions.php");
        }*/
        self::$hostName = '';
        self::$databaseName = '';
        self::$userName = '';
        self::$password = '';

        self::setupConfigurationLive();
    }


    public function setupConfiguration() {


        self::$hostName = "127.0.0.1";
        self::$databaseName = "juxta_master";
        self::$userName = "yeah_right";
        self::$password = "ooooookay";
        self::$hostName = self::$hostName . ':3306';
        if (array_key_exists('test', $_GET)) //TODO: set IP based
        {
            define('TEST', true);
        } else {
            define('TEST', false);
        }
    }

    public function setupConfigurationLive() {


        self::$hostName = ":/cloudsql/juxtachoose:backend";
        self::$databaseName = "juxta_master";
        self::$userName = "yeah_right";
        self::$password = "ooooookay";
        if (array_key_exists('test', $_GET)) //TODO: set IP based
        {
            define('TEST', true);
        } else {
            define('TEST', false);
        }
    }
}

