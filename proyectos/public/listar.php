<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Imprenta\Controladores\CotizacionControlador;

$controlador = new CotizacionControlador();
$controlador->listar();