<?php


namespace konference\Controllers;
use konference\Models\Alerts;
use konference\Models\UserLoginModel;


class PageController implements IController {

    protected $login;

    public function __construct() {
        $this->login = new UserLoginModel();
    }

    public function show(string $pageTitle): array {
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData[Alerts::ALERTS_SUCCESS] = [];
        $tplData[Alerts::ALERTS_WARNING] = [];
        $tplData[Alerts::ALERTS_DANGER] = [];

        if($this->login->isUserLogged()) {
            $tplData['logged'] = $this->login->getUserName();
        }

        return $tplData;
    }
}