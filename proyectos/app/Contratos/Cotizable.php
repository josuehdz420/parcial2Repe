<?php
namespace Imprenta\Contratos;

interface Cotizable {
    public function totalHojas(): int;
    public function porcentajeDescuento(): float;
    public function total(): float;
}