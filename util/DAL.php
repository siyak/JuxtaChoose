<?php
class DAL {
      public static function getUsers(){
        $sp = Factory::createStoredProcedureCall('get_users');
        $sp->addParam('poll_id', 1234);
        return $resultSet = Factory::getDataUtil()->executeResultSet($sp);
    }

    public static function getUserId() {
        $sp = Factory::createStoredProcedureCall('create_and_get_user');
        $params = Factory::getParams();
        $sp->addParam('name', $params->getName());
        $sp->addParam('email', $params->getEmail());
        $sp->addParam('fb_user_id', $params->getFbUserId());
        $sp->addParam('fb_user_link', $params->getFbUserLink());
        return $resultSet = Factory::getDataUtil()->executeResultSet($sp);
    }

    /**
     * @param $pollTitle
     * @return int pollId
     */
    public static function createPoll($pollTitle) {
        $sp = Factory::createStoredProcedureCall('create_poll');
        $sp->addParam('user_id', Factory::getUserID());
        $sp->addParam('poll_title', $pollTitle);
        $resultSet = Factory::getDataUtil()->executeResultSet($sp);
        return $resultSet[0]['id'];
    }

    /**
     * @param int $pollId
     * @param $optionArray
     * @return mixed
     */
    public static function addPollOption($pollId, $optionArray){
        $sp = Factory::createStoredProcedureCall('add_poll_option');
        $sp->addParam('poll_id', trim($pollId));
        $sp->addParam('img_src', trim($optionArray['productImgSrc']));
        $sp->addParam('img_desc', trim($optionArray['productTitle']));
        $sp->addParam('cost', trim($optionArray['productCost']));
        $sp->addParam('product_url', trim($optionArray['productUrl']));
        $resultSet = Factory::getDataUtil()->executeResultSet($sp);
        return $resultSet;
    }

    /**
     * @param int $pollId
     * @param $pollOptionId
     * @return mixed
     */
    public static function addVote($pollId, $pollOptionId) {
        $sp = Factory::createStoredProcedureCall('add_vote');
        $sp->addParam('poll_id', $pollId);
        $sp->addParam('poll_option_id', $pollOptionId);
        $sp->addParam('user_id', Factory::getUserID());
        $resultSet = Factory::getDataUtil()->executeResultSet($sp);
        return $resultSet;
    }

    /**
     * @param int $pollId
     * @return mixed
     */
    public static function getPollInfoById($pollId){
        $sp = Factory::createStoredProcedureCall('get_poll_info_by_id');
        $sp->addParam('poll_id', $pollId);
        return  Factory::getDataUtil()->executeResultSet($sp);
    }

    /**
     * @param int $pollId
     * @return mixed
     */
    public static function getPollOptionsById($pollId){
        $sp = Factory::createStoredProcedureCall('get_poll_options_by_id');
        $sp->addParam('poll_id', $pollId);
        return  Factory::getDataUtil()->executeResultSet($sp);
    }

    /**
     * @param int $pollId
     * @return mixed
     */
    public static function getStatusByUserInfo($pollId){
        $sp = Factory::createStoredProcedureCall('get_status_by_user_info');
        $sp->addParam('poll_id', $pollId);
        $sp->addParam('user_id', Factory::getUserID());
        return  Factory::getDataUtil()->executeResultSet($sp);
    }

    /**
     * @param int $pollId
     * @param $pollOptionId
     * @return mixed
     */
    public static function getPollVotesById($pollId, $pollOptionId){
        $sp = Factory::createStoredProcedureCall('get_poll_votes_by_id');
        $sp->addParam('poll_id', $pollId);
        $sp->addParam('poll_option_id', $pollOptionId);
        return  Factory::getDataUtil()->executeResultSet($sp);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public static function getPollsCreatedBy(){
        $sp = Factory::createStoredProcedureCall('get_polls_created_by');
        $sp->addParam('user_id', Factory::getUserID());
        return  Factory::getDataUtil()->executeResultSet($sp);
    }
}

