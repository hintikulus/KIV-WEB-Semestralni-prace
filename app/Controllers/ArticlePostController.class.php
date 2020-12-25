<?php


namespace konference\Controllers;

use konference\Models\DatabaseModel;
use konference\Models\Utilities;

class ArticlePostController extends PageController {

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

        echo "zaciname testovat \n";

        if(isset($_POST['articlePostSubmit'])) {
            echo "tlacitko bylo stisknuto\n";
            if(isset($_POST['articlePostTitle']) && !empty($_POST['articlePostTitle']
                    && isset($_POST['articlePostAbstract']) && !empty($_POST['articlePostAbstract']))) {
                echo "vse vyplneno\n";
                if(!empty($_FILES['articlePostFile']['name'])) {
                    echo "dokonce i soubor \n";
                    if($_FILES['articlePostFile']['error'] != 0) {
                        echo "nějaká chyba v errorech";
                    } else {
                        $title = htmlspecialchars($_POST['articlePostTitle']);
                        $abstract = $_POST['articlePostAbstract'];

                        $fileName = $_FILES['articlePostFile']['name'];
                        $file_tmp = $_FILES['articlePostFile']['tmp_name'];
                        echo "jdeme na to!";
                        if($pdf_blob = fopen($file_tmp, "rb")) {
                            echo "zapisuju";
                            $this->db->postArticle($this->login->getUserId(), $title, $abstract, $pdf_blob);
                        }
                    }

                }
            }
        }


        $tplData['userInfo'] = $this->db->getUserInfo($this->login->getUserId());

        return $tplData;

    }
}