<?php
class ClsLavagna
{    
    private $marca;
    private $forma;
    private $larghezza;
    private $altezza;
    private $tipo;

    //Costruttore
    public function __construct($marca,$forma,$larghezza,$altezza,$tipo)
    {        
        $this->setMarca($marca);
        $this->setForma($forma);
        $this->setLarghezza($larghezza);
        $this->setAltezza($altezza);
        $this->setTipo($tipo);
    }

    //Marca
    public function setMarca($marca)
    {
        if(!empty($marca))
            $this->marca = $marca;
    }

    public function getMarca(){
        return $this->marca;
    }
    //Forma

    public function setForma($forma)
    {
        if(!empty($forma))
            $this->forma = $forma;
    }

    public function getForma(){
        return $this->forma;
    }

    //Larghezza
    public function setLarghezza($larghezza)
    {
        if($larghezza !== 0)
            $this->larghezza = $larghezza;
    }

    public function getLarghezza(){
        return $this->larghezza;
    }

    //Altezza

    public function setAltezza($altezza)
    {
        if($altezza !== 0)
            $this->altezza = $altezza;
    }

    public function getAltezza(){
        return $this->altezza;
    }
    //Tipo
    
    public function setTipo($tipo)
    {
        if(!empty($tipo))
            $this->tipo = $tipo;
    }

    public function getTipo(){
        return $this->tipo;
    }


}
?>