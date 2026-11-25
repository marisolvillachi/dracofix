<?php
// DracoFix - Misiones Completadas. Lectura dinámica desde SQLite.
// Crear / editar / eliminar solo para admin, con el patrón del CRUD de clase.
$page_title = 'Reparaciones - DracoFix';
$active = 'portafolio';
include 'includes/header.php';
include 'includes/navbar.php';

$misiones = $pdo->query('SELECT * FROM misiones ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
// Un campo de video puede tener varios videos separados por coma.
function mostrar_videos($lista, $etiqueta) {
    if (empty($lista)) return;
    echo '<p class="mb-1 text-muted">' . $etiqueta . ':</p>';
    foreach (explode(',', $lista) as $url) {
        $url = trim($url);
        if ($url === '') continue;
        $url_esc = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        if (str_ends_with($url, '.mp4')) {
            echo '<video controls preload="metadata" class="w-100 rounded mb-3"><source src="' . $url_esc . '" type="video/mp4"></video>';
        } else {
            echo '<p><a class="text-pink" href="' . $url_esc . '" target="_blank" rel="noopener">Ver video</a></p>';
        }
    }
}
?>
<header class="hero-bg py-5"><div class="container px-5 text-center my-5">
<h1 class="display-5 fw-bolder text-white mb-2">Misiones Completadas</h1>
<p class="hero-subtitle">Bitácora de reparaciones reales hechas a familiares y clientes.</p>
<p class="text-muted">¿Quieres ver el proceso en video? Síguenos en TikTok para ver el detrás de escenas de nuestras reparaciones.</p>
</div></header>
<section class="py-5"><div class="container px-5 my-5">

<?php if (es_admin()): ?>
<div class="card card-draco shadow-sm mb-4"><div class="card-header text-white fw-bolder">Agregar misión (solo admin)</div><div class="card-body">
<form action="misiones_guardar.php" method="POST">
<div class="row g-3">
<div class="col-md-6"><label class="form-label" for="titulo">Título de la reparación</label><input class="form-control" id="titulo" type="text" name="titulo" required maxlength="150" placeholder="Ej. Mantenimiento a impresora de tinta continua"></div>
<div class="col-md-6"><label class="form-label" for="categoria">Categoría</label><select class="form-control" id="categoria" name="categoria" required><option value="">Elige...</option><option>PC / Laptop</option><option>Impresora</option><option>Teléfono</option><option>Otro</option></select></div>
<div class="col-md-6"><label class="form-label" for="falla">Falla detectada / Diagnóstico</label><input class="form-control" id="falla" type="text" name="falla" required maxlength="255"></div>
<div class="col-md-6"><label class="form-label" for="solucion">Solución aplicada</label><input class="form-control" id="solucion" type="text" name="solucion" required maxlength="255"></div>
<div class="col-md-6"><label class="form-label" for="video_url">Video del proceso / enlace TikTok / Drive (opcional)</label><input class="form-control" id="video_url" type="text" name="video_url" maxlength="255" placeholder="assets/video/....mp4, assets/video/....mp4"></div>
<div class="col-md-6"><label class="form-label" for="video_antes_url">Video del antes (opcional)</label><input class="form-control" id="video_antes_url" type="text" name="video_antes_url" maxlength="255" placeholder="assets/video/....mp4"></div>
<div class="col-md-6"><label class="form-label" for="video_despues_url">Video del después (opcional)</label><input class="form-control" id="video_despues_url" type="text" name="video_despues_url" maxlength="255" placeholder="assets/video/....mp4"></div>
<div class="col-12"><label class="form-label" for="foto_url">Foto del antes (opcional)</label><input class="form-control" id="foto_url" type="text" name="foto_url" maxlength="255" placeholder="assets/img/misiones/....jpg"></div>
</div>
<button class="btn btn-draco-primary mt-3" type="submit">Guardar misión</button>
</form>
</div></div>
<?php endif; ?>

<div class="row gx-5">
<?php foreach ($misiones as $mision): ?>
<div class="col-lg-6 mb-4"><div class="card card-draco p-4 h-100">
<span class="badge badge-star mb-2" style="width:fit-content;"><?php echo htmlspecialchars($mision['categoria'], ENT_QUOTES, 'UTF-8'); ?></span>
<h2 class="h5 fw-bolder"><?php echo htmlspecialchars($mision['titulo'], ENT_QUOTES, 'UTF-8'); ?></h2>
<p><strong class="text-white">Falla:</strong> <?php echo htmlspecialchars($mision['falla'], ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong class="text-white">Solución:</strong> <?php echo htmlspecialchars($mision['solucion'], ENT_QUOTES, 'UTF-8'); ?></p>
<?php if (!empty($mision['foto_url'])): ?>
<p class="mb-1 text-muted">Antes:</p>
<img src="<?php echo htmlspecialchars($mision['foto_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Antes del mantenimiento" class="img-fluid rounded mb-3">
<?php endif; ?>
<?php mostrar_videos($mision['video_antes_url'] ?? '', 'Antes'); ?>
<?php mostrar_videos($mision['video_url'] ?? '', 'Durante el mantenimiento'); ?>
<?php mostrar_videos($mision['video_despues_url'] ?? '', 'Después'); ?>
<?php if (empty($mision['video_url']) && empty($mision['video_despues_url'])): ?>
<p class="text-muted mb-0">Video en cámara rápida: pendiente, se está subiendo a Drive.</p>
<?php endif; ?>
<?php if (es_admin()): ?>
<div class="d-flex gap-2 mt-3">
<a class="btn btn-warning btn-sm" href="misiones_editar.php?id=<?php echo $mision['id']; ?>">Editar</a>
<form action="misiones_eliminar.php" method="POST" onsubmit="return confirm('¿Eliminar esta misión?');">
<input type="hidden" name="id" value="<?php echo $mision['id']; ?>">
<button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
</form>
</div>
<?php endif; ?>
</div></div>
<?php endforeach; ?>
<?php if (count($misiones) === 0): ?>
<div class="col-12"><p class="text-center text-muted">Todavía no hay misiones registradas.</p></div>
<?php endif; ?>
</div>
</div></section>
<?php include 'includes/footer.php'; ?>
