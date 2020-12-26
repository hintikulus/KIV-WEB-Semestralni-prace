<?php


namespace konference\Controllers;


use konference\Models\Alerts;
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

            if(empty($errors[Alerts::ALERTS_WARNING]) && empty($errors[Alerts::ALERTS_DANGER])) {
                $password = password_hash($_POST['registrationPassWord'], PASSWORD_BCRYPT);

                $data = $this->db->createUser($_POST['registrationUserName'], $_POST['registrationEMail'],
                    $password, $_POST['registrationName'], $_POST['registrationSurName']);

                Alerts::merge_alerts($tplData, $data);

                var_dump($data);

                if(isset($data['result'])) {
                    $username = htmlspecialchars($_POST['registrationUserName']);
                    $this->login->login($data['result'], $username);
                    $tplData['logged'] = $username;
                    header('Location: ?page=uvod');
                }
            }

            Alerts::merge_alerts($tplData, $errors);

        }

        return $tplData;

    }

    private function isRegistrationDataOk(array $data):array {
        $result = Alerts::alertArray();

        if(!(DatabaseModel::isset($data, 'registrationName', 'registrationSurName', 'registrationEMail', 'registrationUserName',
                'registrationPassWord', 'registrationPassWord2') && isset($data['registrationSouhlas']))) {

            $result[Alerts::ALERTS_WARNING][] = Alerts::WARNING_FORM_NOT_COMPLETE;
            return $result;
        }

        if($data['registrationPassWord'] != $data['registrationPassWord2']) {
            $result[Alerts::ALERTS_WARNING][] = Alerts::WARNING_USER_REG_PASS_NOT_MATCH;
            return $result;
        }

        if(!Utilities::passWordValidation($data['registrationPassWord'])) {
            $result[Alerts::ALERTS_WARNING][] = Alerts::WARNING_USER_REG_PASS_VALIDATION;
            return $result;
        }

        return $result;

    }
}