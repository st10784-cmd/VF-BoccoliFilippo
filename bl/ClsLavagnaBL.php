<?php
require_once "models/ClsLavagnaDMO.php";
require_once "inc/ClsConnessione.php";
class ClsLavagnaBL
{
    //Inserimento
    public static function SelectByID($id)
    {
        $db= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

        //Controllo se la connesione al DB è riuscita 
        if($db->connect_error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore di connessione ad Database</div>";
        }

        $query = "SELECT * FROM lavagne WHERE ID=?";

        //preparo lo statement della query parametrica
        //sostituirà il ? con il valore del campo username
        $stmt = $db->prepare($query);

        //bind: i=integer, d=double, s=string, b=blob(campo binario molto grande ades imagie)
        $stmt->bind_param("i", $id);

        //Eseguo la query 
        $stmt->execute();

        //Controllo se è avvenuto un'errore 
        if ($stmt->error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore nella richiesta al Database</div>";
        }

        $result = $stmt->get_result();        

        $row = mysqli_fetch_assoc($result);

        $lavagna = new ClsLavagna(
        $row['ID'],
        $row['marca'],
        $row['forma'],
        $row['altezza'],
        $row['larghezza'],
        $row['tipo']);

        $stmt->close();
        return $lavagna;
    }
    
    //Inserimento
    public static function Inserisci($lavagna)
    {

        $forma = $lavagna->getForma();
        $marca = $lavagna->getMarca();
        $altezza = $lavagna->getAltezza();
        $larghezza = $lavagna->getLarghezza();
        $tipo = $lavagna->getTipo();

        $db= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

        //Controllo se la connesione al DB è riuscita 
        if($db->connect_error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore di connessione ad Database</div>";
        }

        $query = "INSERT INTO lavagne (id,forma,marca,altezza,larghezza,tipo) VALUES (NULL,?,?,?,?,?)";

        //preparo lo statement della query parametrica
        //sostituirà il ? con il valore del campo username
        $stmt = $db->prepare($query);

        //erroe qua
        //bind: i=integer, d=double, s=string, b=blob(campo binario molto grande es imagie)
        $stmt->bind_param("sssss", 
            $forma,
            $marca,
            $altezza,
            $larghezza,
            $tipo);

        //Eseguo la query 
        $stmt->execute();

        //Controllo se è avvenuto un'errore 
        if ($stmt->error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore nella richiesta al Database</div>";
        }
        //$result = $stmt->get_result();        
        $stmt->close();
    }

    //Elimina
    public static function Elimina($indice)
    {
        $db= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
        //Controllo se la connesione al DB è riuscita 
        if($db->connect_error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore di connessione ad Database</div>";
        }

        $query = "DELETE FROM lavagne WHERE id=?;";

        //preparo lo statement della query parametrica
        //sostituirà il ? con il valore del campo username
        $stmt = $db->prepare($query);

        //bind: i=integer, d=double, s=string, b=blob(campo binario molto grande es imagie)
        $stmt->bind_param("i", $indice);

        //Eseguo la query 
        $stmt->execute();

        //Controllo se è avvenuto un'errore 
        if ($stmt->error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore nella richiesta al Database</div>";
        }       
        $stmt->close();
    }

    //Modifica
    public static function Modifica($lavagna, $indice)
    {
        
        $forma = $lavagna->getForma();
        $marca = $lavagna->getMarca();
        $altezza = $lavagna->getAltezza();
        $larghezza = $lavagna->getLarghezza();
        $tipo = $lavagna->getTipo();
        $id = $lavagna->getId();


        $db= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

        //Controllo se la connesione al DB è riuscita 
        if($db->connect_error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore di connessione ad Database</div>";
        }
        
        $query = "UPDATE lavagne SET forma=?, marca=?, altezza=?, larghezza=?, tipo=? WHERE id=?";

        //preparo lo statement della query parametrica
        //sostituirà il ? con il valore del campo username
        $stmt = $db->prepare($query);

        //bind: i=integer, d=double, s=string, b=blob(campo binario molto grande es imagie)
        $stmt->bind_param("sssssi", 
            $forma,
            $marca,
            $altezza,
            $larghezza,
            $tipo,
            $id);

        //Eseguo la query 
        $stmt->execute();

        //Controllo se è avvenuto un'errore 
        if ($stmt->error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore nella richiesta al Database</div>";
        }
        $stmt->close();
    }

    //Visualizza
    public static function Visualizza()
    {
        $arr_lavagne = array();

        $db= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

        if($db->connect_error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore di connessione ad Database</div>";
        }

        $query = "SELECT * FROM lavagne";

        $stmt = $db->prepare($query);

        $stmt->execute();

        //Controllo se è avvenuto un'errore 
        if ($stmt->error)
        {
            $Testohtml = "<div class='alert alert-danger'>Errore nella richiesta al Database</div>";
        }

        $result = $stmt->get_result();    
        
        // x ciclare tutte le righe
        while ($row = mysqli_fetch_assoc($result)) 
        { 
            $new_lavagna = new ClsLavagna(
            $row['ID'], 
            $row['marca'], 
            $row['forma'], 
            $row['altezza'],
            $row['larghezza'],
            $row['tipo']);

            $arr_lavagne[] = $new_lavagna;
        }
        $stmt->close();
        return $arr_lavagne;
    }
}
?>