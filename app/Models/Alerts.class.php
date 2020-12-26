<?php


namespace konference\Models;


class Alerts {

    const ALERT_SUCCESS = "Úspěch";
    const ALERT_WARNING = "Upozornění";
    const ALERT_DANGER = "Chyba";

    const ALERTS_SUCCESS = "success";
    const ALERTS_WARNING = "warning";
    const ALERTS_DANGER = "danger";

    const WARNING_FORM_NOT_COMPLETE = "Nebyly zadány veškeré povinné informace.";
    const DANGER_UNEXPECTED_ERROR = "Vyskytla se neočekávaná chyba.";

    /**
     * Alerty pro editaci uživatelských informací
     */
    const SUCCESS_USER_EDIT_INFO = "Uživatelské informace byly úspěšně změněny.";
    const SUCCESS_USER_EDIT_BIO = "Uživatelova biografie byla úspěšně upravena.";
    const SUCCESS_USER_EDIT_PASS = "Uživatelské heslo bylo úspěšně změněno.";

    const WARNING_USER_EDIT_PASS_VALIDATION = "Zadané heslo neplňuje minimální podmínky hesla. Heslo musí být dlouhé 
        minimálně 8 znaků a obsahovat minimálně jedno malé písmeno, velké písmeno a číslici.";
    const WARNING_USER_EDIT_PASS_NOT_MATCH = "Zadaná hesla nejsou shodná.";
    const WARNING_USER_EDIT_PASS_OLD_NOT_MATCH = "Aktuální heslo není správné.";
    const DANGER_USER_EDIT_PASS_NOT_CHANGED = "Heslo nebylo změněno.";

    const WARNING_USER_EDIT_NOT_FILL = "Nebyly zadány veškeré povinné údaje.";

    const DANGER_USER_EDIT_INFO_NOT_CHANGED = "Uživatelské informace nebyly změněny.";

    /**
     * Alerty pro přihlašování
     */
    const WARNING_USER_LOGIN_INVALID_CREDENTIALS = "Uživatelské jméno nebo heslo není správné.";

    /**
     * Alerty pro registraci
     */
    const WARNING_USER_REG_USERNAME_EXISTS = "Uživatel se zadaným uživatelským jménem již existuje.";
    const WARNING_USER_REG_EMAIL_EXISTS = "Uživatel se zadanou emailovou adresou již existuje.";
    const WARNING_USER_REG_PASS_NOT_MATCH = "Zadaná hesla se neshodují.";
    const WARNING_USER_REG_PASS_VALIDATION = "Zadané heslo neplňuje minimální podmínky hesla. Heslo musí být dlouhé 
        minimálně 8 znaků a obsahovat minimálně jedno malé písmeno, velké písmeno a číslici.";

    /**
     * Alerty pro postování příspěvku
     */

    const WARNING_ARTICLE_POST_FILE_ERROR = "Při nahrávání souboru došlo k chybě.";
    const WARNING_ARTICLE_POST_NO_FILE = "Povinný soubor nebyl přiložen.";
    const WARNING_ARTICLE_POST_BAD_FILE_TYPE = "Soubor je nesprávného typu. Typ souboru musí být PDF.";

    const DANGER_ARTICLE_POST_NOT_PUBLISHED = "Článek nebyl zveřejněn.";



    /**
     * Sjednotí dva seznamy alertů (druhý vloží do prvního)
     * @param array $arr1 seznam alertů
     * @param array $arr2 seznam alertů
     * @return array Výsledné sjednocení seznamů (první seznam)
     */
    public static function merge_alerts(array &$arr1, array &$arr2):array {
        $arr1[Alerts::ALERTS_SUCCESS] = array_merge($arr1[Alerts::ALERTS_SUCCESS], $arr2[Alerts::ALERTS_SUCCESS]);
        $arr1[Alerts::ALERTS_WARNING] = array_merge($arr1[Alerts::ALERTS_WARNING], $arr2[Alerts::ALERTS_WARNING]);
        $arr1[Alerts::ALERTS_DANGER] = array_merge($arr1[Alerts::ALERTS_DANGER], $arr2[Alerts::ALERTS_DANGER]);

        return $arr1;
    }

    public static function alertArray():array {
        $arr = [];
        $arr[self::ALERTS_SUCCESS] = [];
        $arr[self::ALERTS_WARNING] = [];
        $arr[self::ALERTS_DANGER] = [];

        return $arr;
    }
}