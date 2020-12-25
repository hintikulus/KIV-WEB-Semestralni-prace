<?php


namespace konference\Controllers;


use konference\Models\DatabaseModel;
use konference\Models\Utilities;

class UserRegistrationController extends PageController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        parent::__construct();
        // inicializace prace s DB
        //require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = parent::show($pageTitle);

        if($this->login->isUserLogged()) {
            header('Location: ?page=uvod');
            return [];
        }

        if(isset($_POST['registrationSubmit'])) {
            $errors = $this->isRegistrationDataOk($_POST);

            if(isset($errors['success'])) {
                $password = password_hash($_POST['registrationPassWord'], PASSWORD_BCRYPT);

                $errors = $this->db->createUser($_POST['registrationUserName'], $_POST['registrationEMail'],
                    $password, $_POST['registrationName'], $_POST['registrationSurName']);

                if(isset($errors['success'])) {
                    $username = htmlspecialchars($_POST['registrationUserName']);
                    $this->login->login($username);
                    $tplData['logged'] = $username;
                    header('Location: ?page=uvod');
                }
            }

            $tplData['errors'] = $errors;
        }

        return $tplData;

    }

    private function isRegistrationDataOk(array $data):array {
        $result = [];
        $isOk = true;

        if(!(DatabaseModel::isset($data, 'registrationName', 'registrationSurName', 'registrationEMail', 'registrationUserName',
                'registrationPassWord', 'registrationPassWord2') && isset($data['registrationSouhlas']))) {

            $result['errors']['empty'] = "Nejsou vyplněna veškeré políčka";
            return $result;
        }

        if($data['registrationPassWord'] != $data['registrationPassWord2']) {
            $result['errors']['passWordEqual'] == "Hesla se neshodují";
            $isOk = false;
        }

        if(Utilities::passWordValidation($data['registrationPassWord'])) {
            $result['errors']['passWordStrength'] == "Heslo není dostatečně silné";
            $isOk = false;
        }

        if($isOk) {
            $result['success'] = "Registrace je v pořádku";
        }

        return $result;

    }
}