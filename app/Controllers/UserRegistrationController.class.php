<?php


namespace konference\Controllers;


use konference\Models\DatabaseModel;

class UserRegistrationController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        //require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = [];

        $tplData['title'] = $pageTitle;

        if(isset($_POST['registrationSubmit'])) {
            if(DatabaseModel::isset($_POST, 'registrationName', 'registrationSurName', 'registrationEMail', 'registrationUserName',
                'registrationPassWord', 'registrationPassWord2') && isset($_POST['registrationSouhlas'])) {

                if($_POST['registrationPassWord'] == $_POST['registrationPassWord2']) {
                    $password = password_hash($_POST['registrationPassWord'], PASSWORD_BCRYPT);

                    $errors = $this->db->createUser($_POST['registrationUserName'], $_POST['registrationEMail'],
                        $password, $_POST['registrationName'], $_POST['registrationSurName']);

                    foreach($errors as $error) echo $error . '<br>';
                }

            }
        }

        return $tplData;

    }
}