<?php
// DracoFix - Reseñas. Guardado en SQLite y listado dinámico.
// El formulario es público; la reseña se guarda con INSERT preparado y se muestra al recargar.
$page_title = 'Reseñas - DracoFix';
$active = 'resenas';
include 'includes/header.php';
include 'includes/navbar.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $servicio = trim($_POST['servicio'] ?? '');
    $calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_INT);
    $comentario = trim($_POST['comentario'] ?? '');

    if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $servicio === '' || $calificacion === false || $calificacion < 1 || $calificacion > 5 || $comentario === '') {
        $error = 'Revisa los datos de tu reseña: nombre, correo válido, servicio, calificación de 1 a 5 y comentario.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO resenas (nombre, email, servicio, calificacion, comentario) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $email, $servicio, $calificacion, $comentario]);
        header('Location: resenas.php?guardado=ok');
        exit;
    }
}

$resenas = $pdo->query('SELECT * FROM resenas ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<header class="hero-bg py-5"><div class="container px-5 text-center my-5">
<h1 class="display-5 fw-bolder text-white mb-2">Reseñas y Comentarios</h1>
<p class="hero-subtitle">Tu opinión nos ayuda a mejorar y a que otros confíen en DracoFix.</p>
</div></header>
<section class="py-5"><div class="container px-5 my-5">
<?php if (isset($_GET['guardado']) && $_GET['guardado'] === 'ok'): ?>
<div class="alert alert-success" role="status">¡Gracias! Tu reseña ya se publicó.</div>
<?php endif; ?>
<?php if ($error !== ''): ?>
<div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
<div class="row gx-5">
<div class="col-lg-6 mb-4">
<?php foreach ($resenas as $resena): ?>
<div class="card card-draco p-4 mb-4">
<p class="mb-1 text-yellow"><?php echo str_repeat('★', (int)$resena['calificacion']) . str_repeat('☆', 5 - (int)$resena['calificacion']); ?></p>
<p>“<?php echo htmlspecialchars($resena['comentario'], ENT_QUOTES, 'UTF-8'); ?>”</p>
<div class="small text-muted">- <?php echo htmlspecialchars($resena['nombre'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo htmlspecialchars($resena['servicio'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo htmlspecialchars($resena['fecha'], ENT_QUOTES, 'UTF-8'); ?></div>
</div>
<?php endforeach; ?>
<?php if (count($resenas) === 0): ?>
<div class="card card-draco p-4"><p class="text-muted mb-0">Todavía no hay reseñas. Sé la primera persona en opinar.</p></div>
<?php endif; ?>
</div>
<div class="col-lg-6 mb-4"><div class="card card-draco p-4"><h2 class="h5 fw-bolder">Escribe tu Opinión</h2>
<form id="formResena" method="post" action="resenas.php" novalidate>
<div class="mb-3"><label class="form-label" for="nombre">Nombre</label><input class="form-control" id="nombre" name="nombre" type="text" required></div>
<div class="mb-3"><label class="form-label" for="email">Correo Electrónico</label><input class="form-control" id="email" name="email" type="email" required></div>
<div class="mb-3"><label class="form-label" for="servicio">Servicio Recibido</label><select class="form-control" id="servicio" name="servicio" required><option value="">Elige...</option><option>PC</option><option>Impresora</option><option>Celular</option><option>Otro</option></select></div>
<div class="mb-3"><label class="form-label" for="calificacion">Calificación (1 a 5 estrellas)</label><select class="form-control" id="calificacion" name="calificacion" required><option value="">Elige...</option><option value="5">5 ★★★★★</option><option value="4">4 ★★★★</option><option value="3">3 ★★★</option><option value="2">2 ★★</option><option value="1">1 ★</option></select></div>
<div class="mb-3"><label class="form-label" for="comentario">Tu Comentario</label><textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea></div>
<div id="errorResena" class="text-danger mb-3"></div>
<button class="btn btn-draco-primary" type="submit">Publicar Reseña</button>
</form>
</div></div>
</div></div></section>
<?php include 'includes/footer.php'; ?>
