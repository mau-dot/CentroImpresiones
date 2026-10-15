<?php
namespace App\Exceptions;
use DomainException;

class CotizacionInvalidaException extends DomainException{
    public function __construct(readonly string $campo)
    {
        parent::__construct("El campo $campo es invalido");
    }
}

?>