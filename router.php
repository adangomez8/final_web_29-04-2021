<?php
    require_once 'controllers/adminController.php';

    // definimos la base url de forma dinamica
    define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

    // define una acción por defecto
    if (empty($_GET['action'])) {
        $_GET['action'] = 'altaEncuesta';
    } 

    // toma la acción que viene del usuario y parsea los parámetros
    $accion = $_GET['action']; 
    $parametros = explode('/', $accion);

    // decide que camino tomar según TABLA DE RUTEO
    switch ($parametros[0]) {
        case 'altaEncuesta':
            $controller = new AdminController();
            $controller->formEncuesta();
        break;
        case 'confirmarAltaEncuesta':
            $controller = new AdminController();
            $controller->confirmAltaEncuesta();
        break;
        case 'buscarIdEncuesta':
            $controller = new AdminController();
            $controller->buscarIdEncuesta();
        break;
        case 'resultadosEncuestaXId':
            $controller = new AdminController();
            $controller->resultadosEncuestaXId();
        break;
        case 'buscarTituloYOpcionEncuesta':
            $controller = new AdminController();
            $controller->buscarTituloYOpcionEncuesta();
        break;
        case 'resultadosEncuestaXTitYOpc':
            $controller = new AdminController();
            $controller->resultadosEncuestaXTitYOpc();
        break;
    }