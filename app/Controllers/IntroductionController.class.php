<?php

namespace konference\Controllers;

use konference\Models\DatabaseModel;
use konference\Models\UserLoginModel;

require_once(DIRECTORY_MODELS.'/UserLoginModel.class.php');
// nactu rozhrani kontroleru
//require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 * @package kivweb\Controllers
 */
class IntroductionController extends PageController {

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

    /**
     * Vrati obsah uvodni stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle):array {
        $tplData = parent::show($pageTitle);
        //// vsechna data sablony budou globalni
        ///
        // data pohadek
        $tplData['stories'] = $this->db->getAllIntroductions();

        // vratim sablonu naplnenou daty
        return $tplData;
    }
    
}

?>
