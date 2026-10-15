<?php
declare(strict_types=1);
namespace App\Models;
use App\Enums\Papel;

class ImpresionBN extends TrabajoImpresion{

    public Papel $papel;
    public function __construct(){
        $this->papel = Papel::Bond;
    }

    public function precioPorPagina(): float{
        return 0.05;
    }


}


?>
