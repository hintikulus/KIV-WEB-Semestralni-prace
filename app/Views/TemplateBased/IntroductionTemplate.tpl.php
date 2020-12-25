<?php
/////////////////////////////////////////////////////////////
/////////// Sablona pro zobrazeni uvodni stranky  ///////////
/////////////////////////////////////////////////////////////

//// pozn.: sablona je samostatna a provadi primy vypis do vystupu:
// -> lze testovat bez zbytku aplikace.
// -> pri vyuziti Twigu se sablona obejde bez PHP.

/*
////// Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
//// UKAZKA: Uvod bude vypisovat informace z tabulky, ktera ma nasledujici sloupce:
// id, date, author, title, text
$tplData['title'] = "Úvodní stránka (TPL)";
$tplData['stories'] = [
    array("id_introduction" => 1, "date" => "2016-11-01 10:53:00", "author" => "A.B.", "title" => "Nadpis", "text" => "abcd")
];
define("DIRECTORY_VIEWS", "../Views");
const WEB_PAGES = array(
    "uvod" => array("title" => "Úvodní stránka (TPL)")
);
////// KONEC: Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
*/

//// vypis sablony
// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

?>

<form class="row">
    <h4>Vyhledávání</h4>
    <div class="form-group col-md-10">
        <input type="text" class="form-control" name="uvodSearchText" id="uvodSearchText" placeholder="Vyhledávání podle názvu nebo příjmení autora">
    </div>
    <div class="form-group col-md-2">
        <input type="submit" class="btn btn-outline-primary col-12" name="uvodSearchSubmit" value="Hledat">
    </div>
</form>

<!-- ------------------------------------------------------------------------------------------------------- -->
<div class="alert-info">TemplateBased</div>

<!-- Vypis obsahu sablony -->
<?php
// muze se hodit: strtotime($d['date'])

// vypis pohadek
$res = "";

if(array_key_exists('stories', $tplData)) {
    foreach ($tplData['stories'] as $d) {
        $res .= "<h2>$d[title]</h2>";
        $res .= "<b>Autor:</b> $d[author] (" . date("d. m. Y, H:i.s", strtotime($d['date'])) . ")<br><br>";
        $res .= "<div style='text-align:justify;'><b>Úryvek:</b> $d[text]</div><hr>";
    }
} else {
    $res .= "Pohádky nenalezeny";
}
echo $res;

?>
