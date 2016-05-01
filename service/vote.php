<?php
require_once('commonIncludes.php');

class vote {
    public static function execute() {

        $params = Factory::getParams();
        $pollId = $params->getPollId();
        $pollOptionId = $params->getPollOptionId();
        $voteResult = DAL::addVote($pollId, $pollOptionId);
        return json_encode(array('poll_id' => $voteResult[0]['result'] == 'true' ? Util::pollIdEncode($pollId) : null));
    }
}

echo vote::execute();