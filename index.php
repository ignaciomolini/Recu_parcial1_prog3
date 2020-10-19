<?php
require_once './entidades/usuario.php';
require_once './entidades/servicio.php';
require_once './entidades/vehiculo.php';
require_once './entidades/turno.php';

require __DIR__ . '/vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'] ?? '';
$token = getallheaders()['token'] ?? '';

$path = explode('/',$path_info);



switch ($path_info) {
    case '/registro':
        if ($method == 'POST') {
            $email = $_POST['email'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $password = $_POST['password'] ?? '';

            Usuario::registrarUsuario($email, $tipo, $password);
        }
        break;

    case '/login':
        if ($method == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            Usuario::login($email, $password);
        }
        break;

    case '/vehiculo':
        if (Usuario::validarToken($token)) {
            if ($method == 'POST') {
                $patente= $_POST['patente'] ?? '';
                $marca = $_POST['marca'] ?? '';
                $modelo = $_POST['modelo'] ?? '';
                $precio = $_POST['precio'] ?? '';

                echo Vehiculo::guardarVehiculos($patente, $marca, $modelo, $precio);
            }
        } else {
            echo '<br>No tiene los permisos<br>';
        }
        break;

    case '/patente/aaa123':
        if (Usuario::validarToken($token)) {
            if ($method == 'GET') {
                $path = explode('/', $path_info);
                echo Vehiculo::buscarVehiculo($path[2]);
            }
        } else {
            echo '<br>No tiene los permisos<br>';
        }
        break;

    case '/servicio':
        if (Usuario::validarToken($token)) {
            if ($method == 'POST') {
                $patente= $_POST['patente'] ?? '';
                $marca = $_POST['marca'] ?? '';
                $modelo = $_POST['modelo'] ?? '';
                $precio = $_POST['precio'] ?? '';
                echo Servicio::guardarServicios($id, $tipo, $precio, $demora);
            }
        } else {
            echo '<br>No tiene los permisos<br>';
        }
        break;

    case '/turno':
        if (Usuario::validarToken($token)) {
            if ($method == 'POST') {
                $patente= $_POST['patente'] ?? '';
                $fecha = $_POST['fecha'] ?? '';
                $marca = Vehiculo::buscarMarcaVehiculo($patente);
                $modelo = Vehiculo::buscarModeloVehiculo($patente); 
                $precio = Servicio::buscarPrecioServicio($patente);
                $tipoServicio = Servicio::buscarTipoServicio($patente);
                echo Turno::guardarTurnos($patente, $marca, $modelo, $precio, $fecha, $tipoServicio);
            }
        } else {
            echo '<br>No tiene los permisos<br>';
        }
        break;

    default:
        echo 'path incorrecto';
        break;
}


