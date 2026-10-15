<?php
namespace Imprenta\Excepciones;

class CotizacionInvalidaException extends \DomainException {
    public readonly string $campo;

    public function __construct(string $campo, string $mensaje) {
        parent::__construct($mensaje);
        $this->campo = $campo;
    }
}