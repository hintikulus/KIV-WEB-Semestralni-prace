<?php


namespace konference\Models;


class UserLoginModel {

    private $ses;

    private $dUserId = "id";
    private $dUserName = "username";
    private $dDate = "datum";

    public function __construct() {
        require_once("UserSessionModel.class.php");
        $this->ses = new UserSessionModel();
    }

    public function isUserLogged():bool {
        return $this->ses->isSessionSet($this->dUserName);
    }

    public function login($userId, $userName) {
        $this->ses->addSession($this->dUserId, $userId);
        $this->ses->addSession($this->dUserName, $userName);
        $this->ses->addSession($this->dDate, date("d. m. Y, G:m:s"));
    }

    public function getUserId():int {
        if($this->isUserLogged()) {
            return (int) $this->ses->readSession($this->dUserId);
        }
    }

    public function getUserName() {
        if($this->isUserLogged()) {
            return $this->ses->readSession($this->dUserName);
        }

        return null;
    }

    public function logout() {
        $this->ses->removeSession($this->dUserName);
        $this->ses->removeSession($this->dDate);
    }


}