<?php
require_once('commonIncludes.php');
class addPoll {
    public static function execute(){
        $params = Factory::getParams();
        $pollTitle = $params->getPollTitle();
        $pollOptions = $params->getPollOptions();

        $pollId = DAL::createPoll($pollTitle);
        foreach ($pollOptions as $pollOption) {
            DAL::addPollOption($pollId, $pollOption);
        }
        return json_encode(array('poll_id' => Util::pollIdEncode($pollId)));
    }
}
echo addPoll::execute();