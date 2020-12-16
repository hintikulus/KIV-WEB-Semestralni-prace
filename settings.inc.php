<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

/** Adresa serveru. */
define("DB_SERVER","10.0.0.5"); // https://students.kiv.zcu.cz lze 147.228.63.10, ale musite byt na VPN
/** Nazev databaze. */
define("DB_NAME","KIVWEB");
/** Uzivatel databaze. */
define("DB_USER","web");
/** Heslo uzivatele databaze */
define("DB_PASS","");


//// Nazvy tabulek v DB ////

/** Tabulka s pohadkami. */
define("TABLE_INTRODUCTION", "orionlogin_mvc_introduction");
/** Tabulka s uzivateli. */
define("TABLE_USER", "orionlogin_mvc_user");

//// Informace o webu ////
define("WEB_TITLE", "Konference TechMasters");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
//const DIRECTORY_CONTROLLERS = "Controllers";
/** Adresar modelu. */
//const DIRECTORY_MODELS = "Models";
/** Adresar sablon */
//const DIRECTORY_VIEWS = "Views";

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "uvod";

/** Dostupne webove stranky. */
const WEB_PAGES = array(//// Uvodni stranka ////
    "uvod" => array(
        "title" => "Úvodní stránka",

        //// kontroler
        //"file_name" => "IntroductionController.class.php",
        "controller_class_name" => \konference\Controllers\IntroductionController::class, // poskytne nazev tridy vcetne namespace

        // ClassBased sablona
        //"view_class_name" => \konference\Views\ClassBased\IntroductionTemplate::class,

        // TemplateBased sablona
        "view_class_name" => \konference\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \konference\Views\TemplateBased\TemplateBasics::PAGE_INTRODUCTION,
    ),
    //// KONEC: Uvodni stranka ////

    //// Sprava uzivatelu ////
    "sprava" => array(
        "title" => "Správa uživatelů",

        //// kontroler
        //"file_name" => "UserManagementController.class.php",
        "controller_class_name" => \konference\Controllers\UserManagementController::class,

        // ClassBased sablona
        //"view_class_name" => \kivweb\Views\ClassBased\UserManagementTemplate::class,

        // TemplateBased sablona
        "view_class_name" => \konference\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \konference\Views\TemplateBased\TemplateBasics::PAGE_USER_MANAGEMENT,
    ),
    //// KONEC: Sprava uzivatelu ////

    "administrace" => array(
        "title" => "Administrace",
    ),

    "articleshow" => array(
        "title" => "Zobrazení příspěvků"

    ),

    "articleedit" => array(
        "title" => "Úprava příspěvků"

    ),

    "articlecreate" => array(
        "title" => "Vytvoření příspěvku"

    ),

    "registration" => array(
        "title" => "Registrace nového uživatele",
        "controller_class_name" => \konference\Controllers\UserRegistrationController::class,
        "view_class_name" => \konference\Views\TemplateBased\TemplateBasics::class,
        "template_type" => \konference\Views\TemplateBased\TemplateBasics::PAGE_USER_REGISTRATION,

    ),

    "login" => array(
        "title" => "Přihlášení uživatele"

    )



);

?>
