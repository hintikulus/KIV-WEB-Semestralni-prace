<?php

namespace konference\Views\TemplateBased;

use konference\Views\IView;

/**
 * Trida vypisujici HTML hlavicku a paticku stranky.
 * @package kivweb\Views\TemplateBased
 */
class TemplateBasics implements IView {

    /** @var string PAGE_INTRODUCTION  Sablona s uvodni strankou. */
    const PAGE_INTRODUCTION = "IntroductionTemplate.tpl.php";
    /** @var string PAGE_USER_MANAGEMENT  Sablona se spravou uzivatelu. */
    const PAGE_INFORMATION = "InformationTemplate.tpl.php";

    const PAGE_USER_REGISTRATION = "UserRegistrationTemplate.tpl.php";
    const PAGE_USER_LOGIN = "UserLoginTemplate.tpl.php";

    const PAGE_USER_PROFILE = "UserProfileTemplate.tpl.php";
    const PAGE_USER_EDIT = "UserEditTemplate.tpl.php";

    const PAGE_ARTICLE_POST = "ArticlePostTemplate.tpl.php";
    const PAGE_ARTICLE_SHOW = "ArticleShowTemplate.tpl.php";

    const PAGE_ERROR_404 = "404.tpl.php";


    /**
     * Zajisti vypsani HTML sablony prislusne stranky.
     * @param array $templateData       Data stranky.
     * @param string $pageType          Typ vypisovane stranky.
     */
    public function printOutput(array $templateData, string $pageType = self::PAGE_INTRODUCTION)
    {
        //// vypis hlavicky
        $this->getHTMLHeader($templateData);

        //// vypis sablony obsahu
        // data pro sablonu nastavim globalni
        global $tplData;
        $tplData = $templateData;
        // nactu sablonu
        require_once($pageType);

        //// vypis pacicky
        $this->getHTMLFooter();
    }


    /**
     *  Vrati vrsek stranky az po oblast, ve ktere se vypisuje obsah stranky.
     *  @param string $pageTitle    Nazev stranky.
     */
    public function getHTMLHeader(array $tplData) {
        ?>

        <!doctype html>
        <html>
            <head>
                <meta charset='utf-8'>
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <title><?php echo WEB_TITLE; ?></title>

                <link rel="stylesteet" href="../vendor/components/font-awesome/css/font-awesome.css">
                <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.css">
            </head>
            <body>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
                        <div class="container-fluid">
                            <a class="navbar-brand text-dark" href="index.php?page=uvod"><h1 class="h5"><?= WEB_TITLE; ?></h1></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Otevřít navigaci">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarToggle">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active text-dark" href="index.php?page=uvod"><?= WEB_PAGES['uvod']['title']; ?> <span class="badge bg-danger">Připravuje se</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link active text-dark" href="index.php?page=information"><?= WEB_PAGES['information']['title']; ?></a>
                                    </li>
                                </ul>
                                <?php
                                if(isset($tplData['logged'])) {
                                ?>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Přihlášený uživatel: <?= $tplData['logged'] ?>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="?page=profile&user=<?= $tplData['logged']; ?>">Můj profil <span class="badge bg-danger">Připravuje se</span></h4></a></li>
                                            <li><a class="dropdown-item" href="#">Moje příspěvky <span class="badge bg-danger">Připravuje se</span></a></li>
                                            <li><a class="dropdown-item" href="?page=post">Nový příspěvek <span class="badge bg-danger">Připravuje se</span></a></li>
                                            <li><a class="dropdown-item" href="?page=useredit">Upravit profil</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="?page=login&action=logout">Odhlásit se</a></li>
                                        </ul>
                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div class="d-flex">
                                        <a class="btn btn-outline-primary me-2" href="?page=login">Přihlášení</a>
                                        <a class="btn btn-outline-danger" href="?page=registration">Registrace</a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </nav>
                </header>
                <main class="container pt-4">
        <?php
    }
    
    /**
     *  Vrati paticku stranky.
     */
    public function getHTMLFooter(){
        ?>

                </main>
                <footer>Cvičení z KIV/WEB</footer>

                <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
                <script src="../vendor/components/jquery/jquery.min.js"></script>
                <script src="../vendor/alexandermatveev/popper-bundle/AlexanderMatveev/PopperBundle/Resources/public/popper.min.js"></script>
                <script src="../vendor/ckeditor/ckeditor/ckeditor.js"></script>

                <script>
                    CKEDITOR.replace( 'editor1' );
                </script>
            </body>
        </html>

        <?php
    }
        
}

?>
