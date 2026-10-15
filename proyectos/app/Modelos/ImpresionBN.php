<?php
namespace Imprenta\Modelos;

use Imprenta\Enums\Papel;

class ImpresionBN extends TrabajoImpresion {
    public function __construct(string $descripcion, int $paginas, int $copias) {
        parent::__construct($descripcion, $paginas, $copias, Papel::Bond);
    }

    public function precioPorPagina(): float {
        return 0.05 + $this->papel->recargo();
    }
}