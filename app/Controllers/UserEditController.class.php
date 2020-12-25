<?php


namespace konference\Controllers;

use konference\Models\DatabaseModel;
use konference\Models\Utilities;

class UserEditController extends PageController {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = parent::show($pageTitle);

        if(!$this->login->isUserLogged()) {
            header('Location: ?page=login');
            return [];
        }

        if(isset($_POST['userEditInfoSubmit'])) {
            if(isset($_POST['userEditInfoName']) && isset($_POST['userEditInfoSurName'])) {
                if(!empty($_POST['userEditInfoName']) && !empty($_POST['userEditInfoSurName'])) {
                    $name = htmlspecialchars($_POST['userEditInfoName']);
                    $surname = htmlspecialchars($_POST['userEditInfoSurName']);
                    $this->db->execute("UPDATE " . TABLE_USERS . " SET name = ?, surname = ? WHERE id_user = ?",
                        $name, $surname, $this->login->getUserId());
                }
            }
        }


        if(isset($_POST['userEditBioSubmit'])) {
            $bio = "";
            if(isset($_POST['userEditBio'])) {
                $bio = $_POST['userEditBio'];
            }

            $this->db->execute("UPDATE " . TABLE_USERS . " SET bio = ? WHERE id_user = ?", $bio, $this->login->getUserId());
        }


        if(isset($_POST['userEditPassSubmit'])) {
            if(isset($_POST['userEditPassOld']) && isset($_POST['userEditPass1'])
                && isset($_POST['userEditPass2']) && !empty($_POST['userEditPassOld'])) {

                $pass1 = $_POST['userEditPass1'];
                $pass2 = $_POST['userEditPass2'];

                if($pass1 == $pass2) {
                    if (Utilities::passWordValidation($pass1)) {
                        $this->db->changeUserPassword($this->login->getUserId(), $_POST['userEditPassOld'], $pass1);
                    }
                }
            }
        }

        $tplData['userInfo'] = $this->db->getUserInfo($this->login->getUserId());

        return $tplData;

    }
}