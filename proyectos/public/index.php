<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imprenta\Controladores\CotizacionControlador;

$controlador = new CotizacionControlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador->cotizar();
} else {
    $controlador->formulario();
}