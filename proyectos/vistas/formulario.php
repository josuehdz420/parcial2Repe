<?php
$err = $errores ?? [];
$val = $valores ?? ['cliente' => '', 'descripcion' => '', 'modalidad' => 'bn', 'paginas' => '', 'copias' => '', 'papelStr' => 'bond'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización Centro de Impresiones</title>
    <link rel="stylesheet" href="css/imprenta.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Cotización</h1>
        <form action="index.php" method="POST">
            <div class="grid-container">
                <div class="form-group">
                    <label for="cliente">Correo Electrónico del Cliente:</label>
                    <input type="email" id="cliente" name="cliente" value="<?= htmlspecialchars($val['cliente']) ?>" class="<?= isset($err['cliente']) ? 'campo-error' : '' ?>">
                    <?php if(isset($err['cliente'])): ?><span class="error"><?= $err['cliente'] ?></span><?php endif; ?>
                </div>

                <div class="form-group span-2">
                    <label for="descripcion">Descripción del Trabajo:</label>
                    <input type="text" id="descripcion" name="descripcion" value="<?= htmlspecialchars($val['descripcion']) ?>" class="<?= isset($err['descripcion']) ? 'campo-error' : '' ?>">
                    <?php if(isset($err['descripcion'])): ?><span class="error"><?= $err['descripcion'] ?></span><?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Modalidad:</label>
                    <div>
                        <label><input type="radio" name="modalidad" value="bn" <?= ($val['modalidad'] === 'bn') ? 'checked' : '' ?>> B/N</label>
                        <label><input type="radio" name="modalidad" value="color" <?= ($val['modalidad'] === 'color') ? 'checked' : '' ?>> Color</label>
                    </div>
                    <?php if(isset($err['modalidad'])): ?><span class="error"><?= $err['modalidad'] ?></span><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="papel">Tipo de Papel:</label>
                    <select id="papel" name="papel" class="<?= isset($err['papel']) ? 'campo-error' : '' ?>">
                        <?php foreach(\Imprenta\Enums\Papel::cases() as $p): ?>
                            <option value="<?= $p->value ?>" <?= ($val['papelStr'] === $p->value) ? 'selected' : '' ?>><?= ucfirst($p->value) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(isset($err['papel'])): ?><span class="error"><?= $err['papel'] ?></span><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="paginas">Páginas (1 - 300):</label>
                    <input type="number" id="paginas" name="paginas" value="<?= htmlspecialchars($val['paginas']) ?>" class="<?= isset($err['paginas']) ? 'campo-error' : '' ?>">
                    <?php if(isset($err['paginas'])): ?><span class="error"><?= $err['paginas'] ?></span><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="copias">Copias (1 - 50):</label>
                    <input type="number" id="copias" name="copias" value="<?= htmlspecialchars($val['copias']) ?>" class="<?= isset($err['copias']) ? 'campo-error' : '' ?>">
                    <?php if(isset($err['copias'])): ?><span class="error"><?= $err['copias'] ?></span><?php endif; ?>
                </div>

                <div class="form-group span-2">
                    <button type="submit">Cotizar</button>
                </div>
            </div>
        </form>
        <p><a href="listar.php">Ver Listado de Cotizaciones</a></p>
    </div>
</body>
</html>