<?php
declare(strict_types=1);
namespace App\Enums;

enum Papel: string{
    case Bond = "bond";
    case Couche = "couche";
    case Opalina = "opalina";

    public function recargo(): float{
        return match($this){
            self::Bond => 0.00,
            self::Couche => 0.05,
            self::Opalina => 0.10,

        };
    }
}

?>