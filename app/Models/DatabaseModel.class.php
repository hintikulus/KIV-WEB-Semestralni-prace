<?php

namespace konference\Models;

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

    //////////////////////////////////////////////////////////
    ///////////  KONEC: Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////

}

?>
