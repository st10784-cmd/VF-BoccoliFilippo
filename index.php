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
    $_SESSION['lavagne'] = array();
}

//Prendo tutte le lavagne dal database e le carico in sessione
$_SESSION['lavagne'] = ClsLavagnaBL::Visualizza();

generaTabella($tabellaLavagne);


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

//Elimina da index
function elimina(){
    $id = $_GET['id'];
    ClsLavagnaBL::Elimina($id);
}

//Modifica
function modifica(){
    //Varibili per mostrare in details la lavagna
    global $upd_marca;
    global $upd_forma;
    global $upd_altezza;
    global $upd_larghezza;
    global $upd_tipo;

    //Variabili per indirizzare la pagina
    global $nome_pagina;
    global $main_mode;
    global $main_titolo;
    global $destinazione_pag;

    //L'utente vuole aggiornare questo elemento
    $id = $_GET['id'];
    //Carico gli input con i suoi attributi
    $lavagna = ClsLavagnaBL::SelectByID($id);

    $upd_forma = $lavagna->getForma();
    $upd_marca = $lavagna->getMarca();
    $upd_altezza = $lavagna->getAltezza();
    $upd_larghezza = $lavagna->getLarghezza();
    $upd_tipo = $lavagna->getTipo();

    //Cambio alcune variabili in modo che la pagina sia pronta ad
    //accogliere una modifica piuttosto che un nuovo inserimento
    $main_mode  = "Modifica"; //cambio il testo del bottone primario
    $main_titolo = "Modifica il mouse"; //cambio il titolo
    $destinazione_pag = "$nome_pagina?mode=modify&id=$id";
}

//Eseguo la modifica della lavagna, sovrascrivo l'index dato con la lavagna data
function aggiorna(){
    
    //Informazioni dall'url
    $id = $_GET['id'];
    //Informazione dalla form
    $marca = $_POST['marca'];
    $forma = $_POST['forma'];
    $altezza = $_POST['altezza'];
    $larghezza = $_POST['larghezza'];
    $tipo = $_POST['tipo'];
    
    $modified_lavagna = new ClsLavagna($id, $marca, $forma, $altezza,$larghezza,$tipo);
    print_r("Modifico mouse ad indice $id<br>");
    ClsLavagnaBL::Modifica($modified_lavagna, $id);
}

// #endregion

function generaTabella(&$testoHtml)
{
    //<tr> -> righe
    //<td>/<th> -> colonne    
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
        $testoHtml .= "<td><a href='$nome_pagina?mode=update&id=$id'>Aggiorna</a></td>";
        $testoHtml .= "<td><a href='$nome_pagina?mode=delete&id=$id'>Elimina</a></td>";
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
            
            <button type="submit" name ="Azione" class="btn btn-primary"><?php echo $main_mode;?></button>
        </form>
	<!-- questa riga sempre per ultima -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

