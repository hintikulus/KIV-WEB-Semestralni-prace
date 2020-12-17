<?php

namespace konference\Views\TemplateAdministration;

use konference\Views\IView;
use konference\Views\TemplateBased\TemplateBasics;

/**
 * Trida vypisujici HTML hlavicku a paticku stranky.
 * @package kivweb\Views\TemplateBased
 */
class TemplateAdministration extends TemplateBasics implements IView {

    const PAGE_ADMIN_USER_MANAGEMENT = "AdminUserManagementTemplate.tpl.php";

    /**
     * Zajisti vypsani HTML sablony prislusne stranky.
     * @param array $templateData       Data stranky.
     * @param string $pageType          Typ vypisovane stranky.
     */
    public function printOutput(array $templateData, string $pageType = self::PAGE_INTRODUCTION)
    {
        //// vypis hlavicky
        $this->getHTMLHeader($templateData['title']);

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
    public function getHTMLHeader(string $pageTitle) {
        parent::getHTMLHeader($pageTitle);
        ?>
            <div class="row mt-4">
                <div class="col-md-2">
                    <h3>Administrace</h3>
                    <nav class="">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Seznam mých článků</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Články ke schválení</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Správa uživatelů</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-10">
                    <h4><?= $pageTitle; ?></h4>
        <?php
    }

    /**
     *  Vrati paticku stranky.
     */
    public function getHTMLFooter(){
        ?>

            </div>
        </div>
        <?php
        parent::getHTMLFooter();
        ?>


        <?php
    }
        
}

?>
