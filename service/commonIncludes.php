<?
require_once("../util/Util.php");
require('../util/bean/Params.php');
require('../util/bean/Factory.php');
require('../util/exception/ExceptionFactory.php');
require('../util/config.php');
require('../util/DAL.php');
require('../util/Database.php');
require('../util/SP.php');
new Config();
if (!TEST) {
    header('Content-Type: application/json');
}