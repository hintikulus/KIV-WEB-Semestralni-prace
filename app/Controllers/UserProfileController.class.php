<?php


namespace konference\Controllers;

use konference\Models\DatabaseModel;

class UserProfileController extends PageController {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = parent::show($pageTitle);

        if(isset($_GET['user'])) {
            $userInfo = $this->db->getUserInfoByUserName($_GET['user']);

            if($userInfo != null) {
                $tplData['userInfo'] = $userInfo;
            } else {
                header("Location: ?page=404");
            }
        }

        return $tplData;

    }
}