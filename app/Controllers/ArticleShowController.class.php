<?php


namespace konference\Controllers;

use konference\Models\DatabaseModel;
use konference\Models\Utilities;

class ArticleShowController extends PageController {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle):array {
        $tplData = parent::show($pageTitle);
        //// vsechna data sablony budou globalni
        ///
        // data pohadek
        if(isset($_GET['article'])) {
            $articleId = $_GET['article'];
            if($articleId > 0) {
                $tplData['articleInfo'] = $this->db->getArticle($articleId);

                if(!isset($tplData['articleInfo'])) {
                    header("Location: ?page=404");
                }

                if(isset($_POST['articleShowDownload'])) {
                    $size = $tplData['articleInfo']['size'];
                    $file = $tplData['articleInfo']['file'];
                    $title = str_replace(" ", "_", $tplData['articleInfo']['title']) . ".pdf";
                    header("Content-length: " . $size);
                    header("Content-type: application/pdf");
                    header("Content-disposition: attachment; filename=" . $title);
                    echo $file;
                    ob_clean();
                    flush();
                    exit;
                }
            }
        }

        // vratim sablonu naplnenou daty
        return $tplData;
    }
}