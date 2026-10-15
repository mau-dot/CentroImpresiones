<?php
declare(strict_types=1);
namespace App\Models;
use App\Contracts\Cotizable;
abstract class TrabajoImpresion implements Cotizable{

    public function __construct(public readonly string $descripcion, public readonly int $paginas, public readonly int $copias)
    {
        
    }

    public abstract function precioPorPagina(): float;
    public function totalHojas(): int{
        return $this->paginas * $this->copias;
    }
    public function porcentajeDescuento() : float{
        return 0.00;
    }
    public  function total() : float{
        return $this->totalHojas() * $this->precioPorPagina();
    }

}

?>