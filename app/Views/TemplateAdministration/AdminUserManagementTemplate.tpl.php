<?php
///////////////////////////////////////////////////////////////////////////
/////////// Sablona pro zobrazeni stranky se spravou uzivatelu  ///////////
///////////////////////////////////////////////////////////////////////////

//// pozn.: sablona je samostatna a provadi primy vypis do vystupu:
// -> lze testovat bez zbytku aplikace.
// -> pri vyuziti Twigu se sablona obejde bez PHP.

/*
////// Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
//// UKAZKA DAT: Uvod bude vypisovat informace z tabulky, ktera ma nasledujici sloupce:
// id, date, author, title, text
$tplData['title'] = "Sprava uživatelů (TPL)";
$tplData['users'] = [
    array("id_user" => 1, "first_name" => "František", "last_name" => "Noha",
            "login" => "frnoha", "password" => "Tajne*Heslo", "email" => "fr.noha@ukazka.zcu.cz", "web" => "www.zcu.cz")
];
$tplData['delete'] = "Úspěšné mazání.";
define("DIRECTORY_VIEWS", "../Views");
const WEB_PAGES = array(
    "uvod" => array("title" => "Sprava uživatelů (TPL)")
);
////// KONEC: Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
*/

//// vypis sablony
// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

?>
<!-- ------------------------------------------------------------------------------------------------------- -->
<div class="alert-info">TemplateAdmin</div>

<!-- Vypis obsahu sablony -->
<?php
// muze se hodit:
//<form method='post'>
//    <input type='hidden' name='id_user' value=''>
//    <button type='submit' name='action' value='delete'>Smazat</button>
//</form>

// mam vypsat hlasku?
if(isset($tplData['delete'])){
    echo "<div class='alert'>$tplData[delete]</div>";
}

$res = "<div class='table-responsive-md'><table class='table table-hover'><tr><th>ID</th><th>Jméno</th><th>Příjmení</th><th>Login</th><th>E-mail</th><th>Web</th><th>Akce</th></tr>";
// projdu data a vypisu radky tabulky
foreach($tplData['users'] as $u){
    $res .= "<tr><td>$u[id_user]</td><td>$u[name]</td><td>$u[surname]</td><td>$u[login]</td><td>$u[email]</td><td>$u[id_role]</td>"
            ."<td><form method='post'>"
            ."<input type='hidden' name='id_user' value='$u[id_user]'>"
            ."<button type='submit' name='action' value='delete'>Smazat</button>"
            ."</form></td></tr>";
}

$res .= "</table></div></div>";
echo $res;

?>
