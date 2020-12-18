<?php


namespace konference\Controllers;


use konference\Models\DatabaseModel;

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
            return;
        }

        if(isset($_POST['registrationSubmit'])) {
            if(DatabaseModel::isset($_POST, 'registrationName', 'registrationSurName', 'registrationEMail', 'registrationUserName',
                'registrationPassWord', 'registrationPassWord2') && isset($_POST['registrationSouhlas'])) {

                if($_POST['registrationPassWord'] == $_POST['registrationPassWord2']) {
                    $password = password_hash($_POST['registrationPassWord'], PASSWORD_BCRYPT);

                    $errors = $this->db->createUser($_POST['registrationUserName'], $_POST['registrationEMail'],
                        $password, $_POST['registrationName'], $_POST['registrationSurName']);

                    if(isset($errors['success'])) {
                        $username = htmlspecialchars($_POST['registrationUserName']);
                        $this->login->login($username);
                        $tplData['logged'] = $username;
                        header('Location: ?page=uvod');
                    }

                    foreach($errors as $error) echo $error . '<br>';
                }

            }
        }

        return $tplData;

    }
}