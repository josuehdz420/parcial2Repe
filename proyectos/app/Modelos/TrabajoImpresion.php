<?php
namespace Imprenta\Modelos;

use Imprenta\Contratos\Cotizable;
use Imprenta\Enums\Papel;

abstract class TrabajoImpresion implements Cotizable {
    public function __construct(
        public readonly string $descripcion,
        public readonly int $paginas,
        public readonly int $copias,
        public readonly Papel $papel
    ) {}

    public function totalHojas(): int {
        return $this->paginas * $this->copias;
    }

    public function porcentajeDescuento(): float {
        $hojas = $this->totalHojas();
        return match(true) {
            $hojas >= 500 => 0.15,
            $hojas >= 100 => 0.10,
            default => 0.0,
        };
    }

    abstract public function precioPorPagina(): float;

    public function total(): float {
        $subtotal = $this->totalHojas() * $this->precioPorPagina();
        $descuento = $subtotal * $this->porcentajeDescuento();
        return $subtotal - $descuento;
    }
}