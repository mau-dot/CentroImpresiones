<?php
declare(strict_types=1);
namespace App\Contracts;


interface Cotizable{
    public function totalHojas(): int;
    public function porcentajeDescuento() : float;
    public  function total() : float;
    

}

?>