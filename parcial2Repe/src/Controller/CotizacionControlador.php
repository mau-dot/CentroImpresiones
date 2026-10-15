<?php
declare(strict_types=1);
namespace App\Controller;

use App\Enums\Papel;
use App\Excepciones\CotizacionInvalidaException;
use App\Models\ImpresionBN;
use App\Models\ImpresionColor;
use App\Models\TrabajoImpresion;

class CotizacionControlador
{
    public function formulario(): void
    {
        require __DIR__ . '/../../public/formulario.php';
    }
    public function cotizar(array $datos): TrabajoImpresion
    {
        $descripcion = $datos['descripcion'] ?? null;
        if (!is_string($descripcion) or trim($descripcion) === '') {
            throw new CotizacionInvalidaException('descripción');
        }

        $paginas = $this->enteroPositivo($datos, 'paginas');
        $copias = $this->enteroPositivo($datos, 'copias');
        if ($paginas > intdiv(PHP_INT_MAX, $copias)) {
            throw new CotizacionInvalidaException('total de hojas');
        }

        $tipo = $datos['tipo'] ?? null;

        if ($tipo === 'bn') {
            return new ImpresionBN(trim($descripcion), $paginas, $copias);
        }

        if ($tipo === 'color') {
            $papelIngresado = $datos['papel'] ?? null;
            $papel = is_string($papelIngresado) ? Papel::tryFrom($papelIngresado) : null;
            if ($papel === null) {
                throw new CotizacionInvalidaException('papel');
            }

            return new ImpresionColor(trim($descripcion), $paginas, $copias, $papel);
        }

        throw new CotizacionInvalidaException('tipo de impresión');
    }

    private function enteroPositivo(array $datos, string $campo): int
    {
        $valor = $datos[$campo] ?? null;
        if (!is_string($valor) && !is_int($valor)) {
            throw new CotizacionInvalidaException($campo);
        }

        $entero = filter_var($valor, FILTER_VALIDATE_INT);
        if ($entero === false || $entero < 1) {
            throw new CotizacionInvalidaException($campo);
        }

        return $entero;
    }
}