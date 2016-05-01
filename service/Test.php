<?php
require_once('commonIncludes.php');
class Test {
    public static function execute(){
        echo json_encode(DAL::getUsers());
        var_dump($_POST);
    }
}
//echo 1;
Test::execute();