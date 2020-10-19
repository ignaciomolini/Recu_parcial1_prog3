<?php

require_once './entidades/fileHandler.php';

class Servicio extends FileHandler
{
    public $_id;
    public $_tipo;
    public $_precio;
    public $_demora;

    public function __construct($id, $tipo, $precio, $demora)
    {
        $this->_id = $id;
        $this->_tipo = $tipo;
        $this->_precio = $precio;
        $this->_demora = $demora;
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
        return $this->_id . '*' . $this->_tipo . '*' . $this->_precio . '*' . $this->_demora;
    }

    public static function guardarServicios($id, $tipo, $precio, $demora)
    {
        $servicio = new Servicio($id, $tipo, $precio, $demora);
        $listaServicios = self::readServiciosJson();
         
        array_push($listaServicios, $servicio);
        self::saveServiciosJson($listaServicios);

        return 'Se guardo el servicio';
    }

    public static function buscarPrecioServicio($patente)
    {
        $listaServicios = self::readServiciosJson();

        foreach ($listaServicios as $item) {
            if ($item->_id == $patente) {
                return $item->_precio;
            }
        }
        return "No existe esa patente";
    }

    public static function buscarTipoServicio($patente)
    {
        $listaServicios = self::readServiciosJson();

        foreach ($listaServicios as $item) {
            if ($item->_id == $patente) {
                return $item->_tipo;
            }
        }
        return "No existe esa patente";
    }

    public static function saveServiciosJson($obj)
    {
        parent::saveJson('./archivos/tiposServicios.json', $obj);
    }

    public static function readServiciosJson()
    {
        $lista = parent::readJson('./archivos/tiposServicios.json');
        $arrayRetorno = array();

        foreach ($lista as $item) {
            $servicio = new Servicio($item->_id, $item->_tipo, $item->_precio, $item->_demora);
            array_push($arrayRetorno, $servicio);
        }

        return $arrayRetorno;
    }
}
