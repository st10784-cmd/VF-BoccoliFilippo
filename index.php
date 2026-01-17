<?php
require_once "models/ClsLavagnaDMO.php";
require_once "bl/ClsLavagnaBL.php";
session_start();

//varibili per rendere più dinamica la pagina HTML
$main_mode = "Inserisci"; //Testo nel bottone principale
$main_titolo = "Catalogo lavagne"; //Testo del titolo
$nome_pagina = "index.php"; //Nome della pagina, dinamico per esigenze di debug
$destinazione_pag = "index.php?mode=insert"; //Link con tanto di parametri per reindirizzare la pagina

$Testohtml = "";
$tabellaLavagne = "";

$upd_marca = "";
$upd_forma = "";
$upd_altezza = "";
$upd_larghezza = "";
$upd_tipo = "";


if(isset($_GET['mode']))
	$mode = $_GET['mode'];
else
	$mode = "none";

print_r($mode);
//Inizio codice pagina
switch($mode)
{
	case 'insert':
        inserisci();
		break;

	case 'delete':
        elimina();
		break;

	case 'update':
        modifica();//Permetto all'utente di modificare
		break;

	case 'modify':
        aggiorna();//Eseguo gli aggiornamenti 
		break;

	default:
		break;
}

if(!isset($_SESSION['lavagne']))
{
    print_r("CREO IL NUOVO ARRAY IN SESSIONE<br>");
    $_SESSION['lavagne'] = array();
}

//Prendo tutte le lavagne dal database e le carico in sessione
$_SESSION['lavagne'] = ClsLavagnaBL::Visualizza();

generaTabella($tabellaLavagne);


/*
if(isset($_GET['mode']))
{   
    if(isset($_POST['marca']) && 
        isset($_POST['forma']) &&
        isset($_POST['altezza']) &&
        isset($_POST['larghezza']) &&
        isset($_POST['tipo']))
    {
        if(!empty($_POST['marca']) && 
            !empty($_POST['forma']) &&
            !empty($_POST['altezza']) &&
            !empty($_POST['larghezza']) &&
            !empty($_POST['tipo']))
        {
            if($_GET['mode'] === 'insert')
            {
                $marca = $_POST['marca'];
                $forma = $_POST['forma'];
                $altezza = $_POST['altezza'];
                $larghezza = $_POST['larghezza'];
                $tipo = $_POST['tipo'];

                $new_lavagna = new ClsLavagnaDMO($marca, $forma, $altezza,$larghezza,$tipo);
                print_r("Inserisco la nuova lavagna<br>");
                ClsLavagnaBL::Inserisci($new_lavagna);
            }
            if($_GET['mode'] === 'modify')
            {
                print_r("SONO IN MODIFY<br>");
                $new_modello = $_POST['modello'];
                $new_prezzo = $_POST['prezzo'];
                $new_colore = $_POST['colore'];
                $indice = $_GET['indice'];
                $modified_mouse = new ClsMouse($new_modello, $new_prezzo, $new_colore);
                print_r("Modifico mouse ad indice $indice<br>");
                ClsMouseHelper::Modifica($modified_mouse, $indice);
            }
            
        }

    }
    else
    {
        if($_GET['mode'] === 'delete')
        {
            $indice = $_GET['indice'];
            print_r("Rimuovo il mouse alla posizione: $indice<br>");
            ClsMouseHelper::Elimina($indice);
        }
        else if($_GET['mode'] === 'update')
        {
            //L'utente vuole aggiornare questo elemento
            $indice = $_GET['indice'];
            //Carico gli input con i suoi attributi
            $upd_modello = $_SESSION['mouses'][$indice]->getModello();
            $upd_prezzo = $_SESSION['mouses'][$indice]->getPrezzo();
            $upd_colore[$_SESSION['mouses'][$indice]->getIndiceColore()] = true;

            //Cambio alcune variabili in modo che la pagina sia pronta ad
            //accogliere una modifica piuttosto che un nuovo inserimento
            $main_mode  = "Modifica"; //cambio il testo del bottone primario
            $main_titolo = "Modifica il mouse"; //cambio il titolo
            $destinazione_pag = "$nome_pagina?mode=modify&indice=$indice";
        }
    }           

}
*/

//Controlla che tutti i campi passino sia il controllo "isSet" che "!isEmpty"
function isAllSet()
{   
    $isAllSet = false;
    $isAllSet = 
        isset($_POST['marca']) && 
        isset($_POST['forma']) &&
        isset($_POST['altezza']) &&
        isset($_POST['larghezza']) &&
        isset($_POST['tipo'])&
        !empty($_POST['marca']) && 
        !empty($_POST['forma']) &&
        !empty($_POST['altezza']) &&
        !empty($_POST['larghezza']) &&
        !empty($_POST['tipo']);
    print_r($isAllSet);
    return $isAllSet;
}
// #region FUNZIONI CRUD
//Inserisce una nuova lavagna
function inserisci(){
    if(isAllSet())
    {
        $marca = $_POST['marca'];
        $forma = $_POST['forma'];
        $altezza = $_POST['altezza'];
        $larghezza = $_POST['larghezza'];
        $tipo = $_POST['tipo'];

        $new_lavagna = new ClsLavagna(NULL, $marca, $forma, $altezza,$larghezza,$tipo);
        print_r("Inserisco la nuova lavagna<br>");
        ClsLavagnaBL::Inserisci($new_lavagna);
    }
}

//Modifica (la pagina dovrà mandare a schermao la lavagna selezionata in dettaglio e permettere di modificare)
function modifica(){}

//Elimina da index
function elimina(){
    $indice = $_GET['indice'];
    print_r("Rimuovo la lavagna alla posizione: $indice<br>");
    ClsLavagnaBL::Elimina($indice);
}

//Eseguo la modifica della lavagna, sovrascrivo l'index dato con la lavagna data
function aggiorna(){}

// #endregion

function generaTabella(&$testoHtml)
{
    //<tr> -> righe
    //<td> -> colonne    
    global $nome_pagina;
    $testoHtml .= "<table>";
    $testoHtml .= "<tr>  <th>marca</th>  <th>forma</th>   <th>altezza</th> <th>larghezza</th> <th>tipo</th></tr>";
    foreach ($_SESSION['lavagne'] as $key=>$lavagna)
    {
		$id = $lavagna->getID();
		$forma = $lavagna->getForma();
		$marca = $lavagna->getMarca();
		$altezza = $lavagna->getAltezza();
		$larghezza = $lavagna->getLarghezza();
		$tipo = $lavagna->getTipo();
        $testoHtml .= "<tr>";
        $testoHtml .= "<td>{$marca}</td>";
        $testoHtml .= "<td>{$forma}</td>";
        $testoHtml .= "<td>{$altezza}</td>";
        $testoHtml .= "<td>{$larghezza}</td>";
        $testoHtml .= "<td>{$tipo}</td>";
        $testoHtml .= "<td><a href='$nome_pagina?mode=update&indice=$id'>Aggiorna</a></td>";
        $testoHtml .= "<td><a href='$nome_pagina?mode=delete&indice=$id'>Elimina</a></td>";
        $testoHtml .= "</tr>\n";
    } 

    $testoHtml .= "</table>";
}

?>

<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVENTARIO LAVAGNE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="css/default.css">	
  </head>
  <body>
	<?php echo $tabellaLavagne;?>
	<br>
	<form action="<?php echo $destinazione_pag; ?>" method="POST">
            <div>
                <label class="form-label">Marca lavagna: </label>
                <input type="text" name="marca" id = "marca" class ="" value="<?php echo $upd_marca;?>"></input>
            </div>
			<br>

            <div>
                <label class="form-label">Forma lavagna: </label>
                <input type="text" name="forma" id = "forma" class ="" value="<?php echo $upd_forma;?>"></input>
            </div>
            <br>

			<div>
                <label class="form-label">Altezza lavagna: </label>
                <input type="text" name="altezza" id = "altezza" class ="" value="<?php echo $upd_altezza;?>"></input>
            </div>
			<br>

			<div>
                <label class="form-label">Larghezza lavagna: </label>
                <input type="text" name="larghezza" id = "larghezza" class ="" value="<?php echo $upd_larghezza;?>"></input>
            </div>
            <br>

			<div>
                <label class="form-label">Tipo lavagna: </label>
                <input type="text" name="tipo" id = "tipo" class ="" value="<?php echo $upd_tipo;?>"></input>
            </div>
            <br>
            
            <button type="submit" name ="Inserisci" class="btn btn-primary">Inserisci</button>
        </form>
	<!-- questa riga sempre per ultima -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

