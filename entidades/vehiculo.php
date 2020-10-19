<?php

require_once './entidades/fileHandler.php';

class Vehiculo extends FileHandler
{
    public $_patente;
    public $_marca;
    public $_modelo;
    public $_precio;

    public function __construct($patente, $marca, $modelo, $precio)
    {
        $this->_patente = $patente;
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_precio = $precio;
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
        return $this->_patente . '*' . $this->_marca . '*' . $this->_modelo . '*' . $this->_precio;
    }

    public static function guardarVehiculos($patente, $marca, $modelo, $precio)
    {
        $listaVehiculos = self::readVehiculosJson();
        
        foreach ($listaVehiculos as $item) {
            if ($item->_patente == $patente) {
                return 'El vehiculo ya se encuentra registrado';
            }
        }
        $vehiculo = new Vehiculo($patente, $marca, $modelo, $precio);
        
        array_push($listaVehiculos, $vehiculo);
        self::saveVehiculosJson($listaVehiculos);
        return 'Se guardo el vehiculo';
    }

    public static function buscarVehiculo($patente)
    {
        $listaVehiculos = self::readVehiculosJson();

        foreach ($listaVehiculos as $item) {
            if ($item->_patente == $patente) {
                return $item;
            }
        }
        return "No existe $patente";
    }

    public static function buscarMarcaVehiculo($patente)
    {
        $listaVehiculos = self::readVehiculosJson();

        foreach ($listaVehiculos as $item) {
            if ($item->_patente == $patente) {
                return $item->_marca;
            }
        }
        return "No existe esa patente";
    }
    
    public static function buscarModeloVehiculo($patente)
    {
        $listaVehiculos = self::readVehiculosJson();

        foreach ($listaVehiculos as $item) {
            if ($item->_patente == $patente) {
                return $item->_modelo;
            }
        }
        return "No existe esa patente";
    }

    public static function saveVehiculosJson($obj)
    {
        parent::saveJson('./archivos/vehiculos.json', $obj);
    }

    public static function readVehiculosJson()
    {
        $lista = parent::readJson('./archivos/vehiculos.json');
        $arrayRetorno = array();

        foreach ($lista as $item) {
            $vehiculo = new Vehiculo($item->_patente, $item->_marca, $item->_modelo, $item->_precio);
            array_push($arrayRetorno, $vehiculo);
        }
        return $arrayRetorno;
    }
}
