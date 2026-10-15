<?php
declare(strict_types=1);
namespace App\Excepciones;
use DomainException;

class CotizacionInvalidaException extends DomainException{
    public function __construct(readonly string $campo)
    {
        parent::__construct("El campo $campo es invalido");
    }
}