<?php


namespace konference\Controllers;


class UserRegistrationController implements IController {

    public function show(string $pageTitle): array {
        $tplData = [];

        $tplData['title'] = $pageTitle;

        return $tplData;

    }
}