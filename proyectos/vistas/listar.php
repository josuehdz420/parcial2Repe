<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Cotizaciones</title>
    <link rel="stylesheet" href="css/imprenta.css">
</head>
<body>
    <div class="container">
        <h1>Listado de Cotizaciones Registradas</h1>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Modalidad</th>
                    <th>Total Hojas</th>
                    <th>Descuento (%)</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $acumuladoTotales = 0;
                if (!empty($cotizaciones)):
                    foreach ($cotizaciones as $c):
                        $acumuladoTotales += $c['total'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($c['cliente']) ?></td>
                    <td><?= htmlspecialchars($c['descripcion']) ?></td>
                    <td><?= htmlspecialchars(strtoupper($c['modalidad'])) ?></td>
                    <td><?= $c['totalHojas'] ?></td>
                    <td><?= number_format($c['porcentajeDescuento'], 0) ?>%</td>
                    <td>$<?= number_format($c['total'], 2) ?></td>
                </tr>
                <?php 
                    endforeach;
                else: 
                ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay cotizaciones registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Total General:</strong></td>
                    <td><strong>$<?= number_format($acumuladoTotales, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <form action="listar.php" method="POST">
            <button type="submit" name="vaciar" value="1">Vaciar listado</button>
        </form>
        <p><a href="index.php">Nueva Cotización</a></p>
    </div>
</body>
</html>