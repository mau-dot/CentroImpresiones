<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\Controller\CotizacionControlador;
use App\Enums\Papel;
use App\Excepciones\CotizacionInvalidaException;



$cotizacion = null;
$error = null;
$valorFormulario = static function (string $campo): string {
    $valor = $_POST[$campo] ?? '';
    return is_string($valor) || is_int($valor) ? (string) $valor : '';
};




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $cotizacion = (new CotizacionControlador())->cotizar($_POST);
    } catch (CotizacionInvalidaException $exception) {
        $error = $exception->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización de impresión</title>
</head>
<body>
    <h1>Cotización de impresión</h1>

    <?php if ($error !== null): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post">
        <label>
            Descripción
            <input type="text" name="descripcion" required value="<?= htmlspecialchars($valorFormulario('descripcion'), ENT_QUOTES, 'UTF-8') ?>">
        </label>

        <label>
            Páginas
            <input type="number" name="paginas" min="1" required value="<?= htmlspecialchars($valorFormulario('paginas'), ENT_QUOTES, 'UTF-8') ?>">
        </label>

        <label>
            Copias
            <input type="number" name="copias" min="1" required value="<?= htmlspecialchars($valorFormulario('copias'), ENT_QUOTES, 'UTF-8') ?>">
        </label>

        <label>
            Tipo de impresión
            <select name="tipo" required>
                <option value="bn" <?= $valorFormulario('tipo') === 'bn' ? 'selected' : '' ?>>Blanco y negro</option>
                <option value="color" <?= $valorFormulario('tipo') === 'color' ? 'selected' : '' ?>>Color</option>
            </select>
        </label>

        <label>
            Papel (para impresión a color)
            <select name="papel">
                <?php foreach (Papel::cases() as $papel): ?>
                    <option value="<?= htmlspecialchars($papel->value, ENT_QUOTES, 'UTF-8') ?>" <?= $valorFormulario('papel') === $papel->value ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst($papel->value), ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <button type="submit">Calcular cotización</button>
    </form>

    <?php if ($cotizacion !== null): ?>
        <section aria-labelledby="resultado">
            <h2 id="resultado">Resultado</h2>
            <p>Trabajo: <?= htmlspecialchars($cotizacion->descripcion, ENT_QUOTES, 'UTF-8') ?></p>
            <p>Total de hojas: <?= $cotizacion->totalHojas() ?></p>
            <p>Descuento: <?= number_format($cotizacion->porcentajeDescuento() * 100, 0) ?>%</p>
            <p>Total: $<?= number_format($cotizacion->total(), 2) ?></p>
        </section>
    <?php endif; ?>
</body>
</html>