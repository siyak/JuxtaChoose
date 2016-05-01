<?php

class Params {
    private $pollOptions;
    private $name;
    private $email;
    private $fbUserId;
    private $fbUserLink;
    private $pollTitle;
    private $pollId;
    private $pollOptionId;


    function __construct() {
        $this->pollOptions = Util::arrayReturn('poll_options', $_POST);
        $this->name = trim(Util::arrayReturn('fb_user_name', $_REQUEST));
        $this->fbUserId = trim(Util::arrayReturn('fb_user_id', $_REQUEST));
        $this->fbUserLink = trim(Util::arrayReturn('fb_user_link', $_REQUEST));
        $this->email = trim(Util::arrayReturn('fb_user_email', $_REQUEST));
        $this->pollTitle = trim(Util::arrayReturn('poll_title', $_POST));
        $this->pollId = Util::pollIdDecode(trim(Util::arrayReturn('poll_id', $_REQUEST)));
        $this->pollOptionId = trim(Util::arrayReturn('poll_option_id', $_REQUEST));
    }

    /**
     * @return array
     */
    public function getPollOptions() {
        return $this->pollOptions;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFbUserId() {
        return $this->fbUserId;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPollTitle() {
        return $this->pollTitle;
    }

    /**
     * @return string
     */
    public function getPollId() {
        return $this->pollId;
    }

    /**
     * @return string
     */
    public function getPollOptionId() {
        return $this->pollOptionId;
    }

    /**
     * @return string
     */
    public function getFbUserLink() {
        return $this->fbUserLink;
    }



}