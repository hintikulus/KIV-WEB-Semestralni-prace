<?php

namespace konference\Models;

use \PDO;
use \PDOException;

/**
 * Trida spravujici databazi.
 * @package kivweb\Models
 */
class DatabaseModel {

    /** @var DatabaseModel $database  Singleton databazoveho modelu. */
    private static $database;

    /** @var \PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
    private $pdo;

    /**
     * Inicializace pripojeni k databazi.
     */
    private function __construct() {
        // inicializace DB
        $this->pdo = new \PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // vynuceni kodovani UTF-8
        $this->pdo->exec("set names utf8");
    }

    /**
     * Tovarni metoda pro poskytnuti singletonu databazoveho modelu.
     * @return DatabaseModel    Databazovy model.
     */
    public static function getDatabaseModel(){
        if(empty(self::$database)){
            self::$database = new DatabaseModel();
        }
        return self::$database;
    }

    public static function htmlspecialchars(array $array):array {
        foreach($array as $key => $value) {
            $array[$key] = htmlspecialchars($value);
        }

        return $array;
    }

    public static function isset():bool {
        $argNumber = func_num_args();

        if($argNumber < 2) return true;

        $array = func_get_arg(0);
        $result = true;

        for($i = 1; $i < $argNumber; $i++) {
           $result = $result && isset($array[func_get_arg($i)]) && !empty($array[func_get_arg($i)]);
        }

        return $result;
    }
    //////////////////////////////////////////////////////////
    ///////////  Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////

    /**
     *  Vrati seznam vsech pohadek pro uvodni stranku.
     *  @return array Obsah uvodu.
     */
    public function getAllIntroductions():array {
        // pripravim dotaz
        $q = "SELECT * FROM ".TABLE_ARTICLES;
        // provedu a vysledek vratim jako pole
        // protoze je o uzkazku, tak netestuju, ze bylo neco vraceno
        return $this->pdo->query($q)->fetchAll();
    }
    
    
    /**
     *  Vrati seznam vsech uzivatelu pro spravu uzivatelu.
     *  @return array Obsah spravy uzivatelu.
     */
    public function getAllUsers():array {
        // pripravim dotaz
        $q = "SELECT * FROM ".TABLE_USERS;
        // provedu a vysledek vratim jako pole
        // protoze je o uzkazku, tak netestuju, ze bylo neco vraceno
        return $this->pdo->query($q)->fetchAll();
    }

    public function loginUser(string $login, string $password) {
        $login = htmlspecialchars($login);

        $q = "SELECT id_user, login, password from " . TABLE_USERS . " WHERE login = :login OR email = :email;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindParam(':login', $login);
        $vystup->bindParam(':email', $login);
        $vystup->execute();
        if($vystup->rowCount() == 0) {
            return null;
        }

        $result = $vystup->fetchAll()[0];

        if(password_verify($password, $result['password'])) {
            return $result;
        } else {
            return null;
        }
    }

    public function createUser(string $login, string $email, string $password, string $name, string $surname) {
        $login = htmlspecialchars($login);
        $email = htmlspecialchars($email);
        $name = htmlspecialchars($name);
        $surname = htmlspecialchars($surname);

        $q = "SELECT login, email from " . TABLE_USERS . " WHERE login = :login OR email = :email";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindParam(':login', $login);
        $vystup->bindParam(':email', $email);
        $vystup->execute();
        echo $vystup->rowCount() . $login . $email;
        if($vystup->rowCount() > 0) {
            $result = $vystup->fetchObject();
            var_dump($result);

            $errors = array();
            echo('Uživatel s takovým emailem nebo uživ. jménem již existuje.');

            return $errors;
        }

        $q = "INSERT INTO " . TABLE_USERS . " (login, email, password, name, surname) 
            VALUES (:login, :email, :password, :name, :surname);";
        echo $q;
        $vystup = $this->pdo->prepare($q);
        $vystup->bindParam(':login', $login);
        $vystup->bindParam(':email', $email);
        $vystup->bindParam(':password', $password);
        $vystup->bindParam(':name', $name);
        $vystup->bindParam(':surname', $surname);

        if($vystup->execute()) {
            $errors['success'] = "Uživatel byl v pořádku registrován";
        } else {
            $errors['databaseProblem'] = "Vyskytl se problém se spojením s databází, registrace uživatele nebyla provedena.";
        }

        return $errors;
    }
    
    /**
     *  Smaze daneho uzivatele z DB.
     *  @param int $userId  ID uzivatele.
     */
    public function deleteUser(int $userId):bool {
        // pripravim dotaz
        $q = "DELETE FROM ".TABLE_USERS." WHERE id_user = $userId";
        // provedu dotaz
        $res = $this->pdo->query($q);
        // pokud neni false, tak vratim vysledek, jinak null
        if ($res) {
            // neni false
            return true;
        } else {
            // je false
            return false;
        }
    }

    public function getUserInfo(int $userId) {

        $q = "SELECT * FROM " . TABLE_USERS . " WHERE id_user = :id_user";
        $res = $this->pdo->prepare($q);
        $res->bindParam(':id_user', $userId);
        if($res->execute()) {
            return $res->fetchAll()[0];
        } else {
            return null;
        }
    }

    public function getUserInfoByUserName(string $username) {

        $q = "SELECT * FROM " . TABLE_USERS . " WHERE login = :username";
        $res = $this->pdo->prepare($q);
        $res->bindParam(':username', $username);
        if($res->execute()) {
            return $res->fetchAll()[0];
        } else {
            return null;
        }
    }

    public function changeUserPassword(int $userId, string $old_password, $new_password) {
        $userInfo = $this->getUserInfo($userId);

        if(!password_verify($old_password, $userInfo['password'])) {
           return false;
        }

        $password = password_hash($new_password, PASSWORD_BCRYPT);

        $q = "UPDATE " . TABLE_USERS . " SET password = :pass WHERE id_user = :id_user";
        $res = $this->pdo->prepare($q);
        $res->bindParam(":pass", $password);
        $res->bindParam("id_user", $userId);
        return $res->execute();
    }

    public function execute():bool {
        if(func_num_args() == 0) {
            return false;
        }

        $q = func_get_arg(0);
        $res = $this->pdo->prepare($q);

        $args = func_get_args();

        for($i = 1; $i < func_num_args(); $i++) {
            $res->bindParam($i, $args[$i]);
        }

        return $res->execute();


    }

    public function postArticle($author, $title, $abstract, $file) {
        $q = "INSERT INTO " . TABLE_ARTICLES . " (id_author, title, abstract, file) VALUES (:author, :title, :abstract, :file)";
        $res = $this->pdo->prepare($q);
        $res->bindParam(":author", $author);
        $res->bindParam(":title", $title);
        $res->bindParam(":abstract", $abstract);
        $res->bindParam(":file", $file, PDO::PARAM_LOB);

        if($res->execute()) {
        } else {
        }
    }

    public function getArticle($articleId) {
        $q = "SELECT title, abstract, file, time_posted, state, users.name, users.surname, users.login, octet_length(file) as size 
            FROM " . TABLE_ARTICLES . " INNER JOIN " . TABLE_USERS . " ON users.id_user = articles.id_author 
            where articles.id_article = :id_article";
        $res = $this->pdo->prepare($q);
        $res->bindParam(":id_article", $articleId);
        if($res->execute()) {
            return $res->fetchAll()[0];
        } else {
            return null;
        }
    }

    //////////////////////////////////////////////////////////
    ///////////  KONEC: Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////

}

?>
