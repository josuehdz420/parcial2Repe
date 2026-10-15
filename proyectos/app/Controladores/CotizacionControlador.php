<?php
namespace Imprenta\Controladores;

use Imprenta\Modelos\ImpresionBN;
use Imprenta\Modelos\ImpresionColor;
use Imprenta\Enums\Papel;
use Imprenta\Excepciones\CotizacionInvalidaException;

class CotizacionControlador {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cotizaciones'])) {
            $_SESSION['cotizaciones'] = [];
        }
    }

    public function formulario(array $errores = [], array $valores = []): void {
        require_once __DIR__ . '/../../vistas/formulario.php';
    }

    public function cotizar(): void {
        $errores = [];
        $campoError = '';

        $cliente = trim($_POST['cliente'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $modalidad = trim($_POST['modalidad'] ?? '');
        $paginas = $_POST['paginas'] ?? '';
        $copias = $_POST['copias'] ?? '';
        $papelStr = $_POST['papel'] ?? 'bond';

        $valores = compact('cliente', 'descripcion', 'modalidad', 'paginas', 'copias', 'papelStr');

        try {
            if (empty($cliente) || !filter_var($cliente, FILTER_VALIDATE_EMAIL)) {
                throw new CotizacionInvalidaException('cliente', 'El correo electrónico es obligatorio y debe ser válido.');
            }
            if (empty($descripcion)) {
                throw new CotizacionInvalidaException('descripcion', 'La descripción del trabajo es obligatoria.');
            }
            if ($modalidad !== 'bn' && $modalidad !== 'color') {
                throw new CotizacionInvalidaException('modalidad', 'Seleccione una modalidad válida.');
            }
            if (!filter_var($paginas, FILTER_VALIDATE_INT) || (int)$paginas < 1 || (int)$paginas > 300) {
                throw new CotizacionInvalidaException('paginas', 'Las páginas deben ser un entero entre 1 y 300.');
            }
            if (!filter_var($copias, FILTER_VALIDATE_INT) || (int)$copias < 1 || (int)$copias > 50) {
                throw new CotizacionInvalidaException('copias', 'Las copias deben ser un entero entre 1 y 50.');
            }

            $papelEnum = Papel::tryFrom($papelStr);
            if ($modalidad === 'bn' && $papelStr !== 'bond') {
                throw new CotizacionInvalidaException('papel', 'Si la modalidad es bn, el papel debe ser bond.');
            }
            if (!$papelEnum) {
                throw new CotizacionInvalidaException('papel', 'Tipo de papel inválido.');
            }

            if ($modalidad === 'bn') {
                $trabajo = new ImpresionBN($descripcion, (int)$paginas, (int)$copias);
            } else {
                $trabajo = new ImpresionColor($descripcion, (int)$paginas, (int)$copias, $papelEnum);
            }

            $_SESSION['cotizaciones'][] = [
                'cliente' => $cliente,
                'descripcion' => $trabajo->descripcion,
                'modalidad' => $modalidad,
                'totalHojas' => $trabajo->totalHojas(),
                'porcentajeDescuento' => $trabajo->porcentajeDescuento() * 100,
                'total' => $trabajo->total()
            ];

            header('Location: listar.php');
            exit;

        } catch (CotizacionInvalidaException $e) {
            $errores[$e->campo] = $e->getMessage();
            $this->formulario($errores, $valores);
        }
    }

    public function listar(): void {
        if (isset($_POST['vaciar'])) {
            $_SESSION['cotizaciones'] = [];
            header('Location: listar.php');
            exit;
        }
        $cotizaciones = $_SESSION['cotizaciones'] ?? [];
        require_once __DIR__ . '/../../vistas/listar.php';
    }
}