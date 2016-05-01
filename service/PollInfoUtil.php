<?php

require_once('commonIncludes.php');
class PollInfoUtil {

    /**
     * @return array
     */
    public static function getPollInfo($pollId) {
        $pollInfo = DAL::getPollInfoById($pollId);
        $pollInfo['poll_id'] = Util::pollIdEncode($pollInfo['poll_id']);

        $pollOptions = DAL::getPollOptionsById($pollId);
        foreach ($pollOptions as $index => $pollOption) {
            $pollOption['poll_id'] = Util::pollIdEncode($pollOption['poll_id']);
            $poll_option_id = $pollOption['poll_option_id'];
            $pollVotesById = DAL::getPollVotesById($pollId, $poll_option_id);
            $pollOption['voters'] = $pollVotesById;
            $pollOption['votes'] = count($pollVotesById);
            $pollOptions[$index] = $pollOption;
        }

        $result = DAL::getStatusByUserInfo($pollId);
        $status = $result[0]['status'];

        $jsonArray = array(
            'poll_id' => Util::pollIdEncode($pollId)
        , 'status' => $status
        , 'poll_info' => Util::arrayReturn(0, $pollInfo)
        , 'poll_options' => $pollOptions
        );
        return $jsonArray;
    }
} 