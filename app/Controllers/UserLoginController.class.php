<?php


namespace konference\Controllers;

use konference\Models\DatabaseModel;

class UserLoginController extends PageController {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = parent::show($pageTitle);

        if(isset($_GET['action']) && $_GET['action'] == 'logout') {
            $this->login->logout();
            header('Location: ?page=uvod');
        }

        if($this->login->isUserLogged()) {
            header('Location: ?page=uvod');
            return;
        }

        if(isset($_POST['loginSubmit'])) {
            if(DatabaseModel::isset($_POST, "loginUserName", "loginPassWord")) {
                if($this->db->loginUser($_POST['loginUserName'], $_POST['loginPassWord'])) {
                    $username = htmlspecialchars($_POST['loginUserName']);
                    $this->login->login($username);
                    $tplData['logged'] = $username;
                    header('Location: ?page=uvod');
                }

            }
        }

        return $tplData;

    }
}