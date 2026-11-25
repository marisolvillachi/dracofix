<?php
// DracoFix - Editar misión. Muestra el formulario con los datos existentes. Solo admin.
require_once __DIR__ . '/includes/auth.php';
requerir_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID inválido.');
}

$consulta = $pdo->prepare('SELECT * FROM misiones WHERE id = ?');
$consulta->execute([$id]);
$mision = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$mision) {
    exit('Misión no encontrada.');
}

$page_title = 'Editar misión - DracoFix';
$active = 'portafolio';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<section class="py-5"><div class="container py-4" style="max-width: 650px;">
<h1 class="mb-4 text-white">Editar misión</h1>
<div class="card card-draco shadow-sm"><div class="card-body">
<form action="misiones_actualizar.php" method="POST">
<input type="hidden" name="id" value="<?php echo $mision['id']; ?>">
<div class="mb-3"><label class="form-label" for="titulo">Título de la reparación</label><input class="form-control" id="titulo" type="text" name="titulo" required maxlength="150" value="<?php echo htmlspecialchars($mision['titulo'], ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="categoria">Categoría</label><select class="form-control" id="categoria" name="categoria" required>
<option <?php echo $mision['categoria'] === 'PC / Laptop' ? 'selected' : ''; ?>>PC / Laptop</option>
<option <?php echo $mision['categoria'] === 'Impresora' ? 'selected' : ''; ?>>Impresora</option>
<option <?php echo $mision['categoria'] === 'Teléfono' ? 'selected' : ''; ?>>Teléfono</option>
<option <?php echo $mision['categoria'] === 'Otro' ? 'selected' : ''; ?>>Otro</option>
</select></div>
<div class="mb-3"><label class="form-label" for="falla">Falla detectada / Diagnóstico</label><input class="form-control" id="falla" type="text" name="falla" required maxlength="255" value="<?php echo htmlspecialchars($mision['falla'], ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="solucion">Solución aplicada</label><input class="form-control" id="solucion" type="text" name="solucion" required maxlength="255" value="<?php echo htmlspecialchars($mision['solucion'], ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="video_url">Video del proceso / enlace (opcional)</label><input class="form-control" id="video_url" type="text" name="video_url" maxlength="255" value="<?php echo htmlspecialchars($mision['video_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="video_antes_url">Video del antes (opcional)</label><input class="form-control" id="video_antes_url" type="text" name="video_antes_url" maxlength="255" value="<?php echo htmlspecialchars($mision['video_antes_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="video_despues_url">Video del después (opcional)</label><input class="form-control" id="video_despues_url" type="text" name="video_despues_url" maxlength="255" value="<?php echo htmlspecialchars($mision['video_despues_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="foto_url">Foto del antes (opcional)</label><input class="form-control" id="foto_url" type="text" name="foto_url" maxlength="255" value="<?php echo htmlspecialchars($mision['foto_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<button class="btn btn-draco-primary" type="submit">Guardar cambios</button>
<a class="btn btn-draco-secondary" href="portafolio.php">Cancelar</a>
</form>
</div></div>
</div></section>
<?php include 'includes/footer.php'; ?>
