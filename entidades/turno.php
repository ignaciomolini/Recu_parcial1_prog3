<?php

require_once './entidades/fileHandler.php';

class Turno extends FileHandler
{
    public $_patente;
    public $_marca;
    public $_modelo;
    public $_precio;
    public $_fecha;
    public $_tipoServicio;

    public function __construct($patente, $marca, $modelo, $precio, $fecha, $tipoServicio)
    {
        $this->_patente = $patente;
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_precio = $precio;
        $this->_fecha = $fecha;
        $this->_tipoServicio = $tipoServicio;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return $this->_patente . '*' . $this->_marca . '*' . $this->_modelo . '*' . $this->_precio  . '*' . $this->_fecha . '*' . $this->_tipoServicio;
    }

    public static function guardarTurnos($patente, $marca, $modelo, $precio, $fecha, $tipoServicio)
    {
        $listaTurnos = self::readTurnosJson();
    
        $turno = new Turno($patente, $marca, $modelo, $precio, $fecha, $tipoServicio);
        
        array_push($listaTurnos, $turno);
        self::saveTurnosJson($listaTurnos);
        return 'Se guardo el turno';
    }

    

    public static function saveTurnosJson($obj)
    {
        parent::saveJson('./archivos/turnos.json', $obj);
    }

    public static function readTurnosJson()
    {
        $lista = parent::readJson('./archivos/turnos.json');
        $arrayRetorno = array();

        foreach ($lista as $item) {
            $turno = new Turno($item->_patente, $item->_marca, $item->_modelo, $item->_precio, $item->_fecha, $item->_tipoServicio);
            array_push($arrayRetorno, $turno);
        }
        return $arrayRetorno;
    }
}
