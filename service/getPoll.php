<?php
require_once('PollInfoUtil.php');

class getPoll {
    public static function execute() {
        $pollId = Factory::getParams()->getPollId();
        $jsonArray = PollInfoUtil::getPollInfo($pollId);
        return json_encode($jsonArray);
    }

}

echo getPoll::execute();