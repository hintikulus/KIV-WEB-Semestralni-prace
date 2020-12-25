<?php


namespace konference\Models;


class Utilities {

    public static function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

    public static function passWordValidation($password) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if(!$uppercase || !$lowercase || !$number|| strlen($password) < 8) {
            return false;
        }

        return true;
    }

    public static function checkCKEditorString($s) {
        if(str_pos($s, "<form") != false || str_pos($s, "</form>") != false) return false;
        if(str_pos($s, "<script") != false || str_pos($s, "</script>") != false) return false;

        return true;
    }
}