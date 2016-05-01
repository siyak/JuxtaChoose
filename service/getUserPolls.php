<?php
require_once('PollInfoUtil.php');

class getUserPolls {
    public static function execute() {
        $pollsCreated = DAL::getPollsCreatedBy();
        $jsonArray = array();
        foreach ($pollsCreated as $poll) {
            $jsonArray[] = PollInfoUtil::getPollInfo($poll['poll_id']);
        }

        return json_encode($jsonArray);
    }
}
echo getUserPolls::execute();