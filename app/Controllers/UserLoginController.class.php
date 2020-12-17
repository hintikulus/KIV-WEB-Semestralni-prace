<?php


namespace konference\Controllers;


class UserLoginController implements IController {

    public function show(string $pageTitle): array {
        $tplData = [];

        $tplData['title'] = $pageTitle;

        return $tplData;

    }
}