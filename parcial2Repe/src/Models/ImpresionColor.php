<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\Papel;
use App\Models\TrabajoImpresion;

class ImpresionColor extends TrabajoImpresion{

    public function __construct(public Papel $papel){

    }

    public function precioPorPagina(): float{
        return 0.15 + $this->papel->recargo();
    }

    public function totalHojas(): int{
        return $this->paginas * $this->copias;
    }

    public function porcentajeDescuento() : float{
        return match(true){
            $this->totalHojas() > 500 => 0.15,
            $this->totalHojas() > 100 => 0.10,
            default => 0.00
        };
    }

     public final function total() : float{
        return $this->totalHojas() * $this->precioPorPagina() * (1 - $this->porcentajeDescuento());
    }

}


?>