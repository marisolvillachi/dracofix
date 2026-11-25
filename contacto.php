<?php
// DracoFix - Cotización con sesión. Guardado con el patrón guardar.php del CRUD de clase.
require_once __DIR__ . '/includes/auth.php';

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!esta_logueado()) {
        header('Location: login.php');
        exit;
    }
    $nombre = trim($_POST['nombre'] ?? '');
    $contacto = trim($_POST['email'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($nombre === '' || $contacto === '' || $tipo === '' || $marca === '' || $descripcion === '') {
        $error = 'Completa todos los campos.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO cotizaciones (usuario_id, nombre, contacto, tipo_dispositivo, marca_modelo, descripcion) VALUES (:usuario_id, :nombre, :contacto, :tipo, :marca, :descripcion)');
        $stmt->execute([
            ':usuario_id' => $_SESSION['usuario_id'],
            ':nombre' => $nombre,
            ':contacto' => $contacto,
            ':tipo' => $tipo,
            ':marca' => $marca,
            ':descripcion' => $descripcion
        ]);
        header('Location: dashboard.php');
        exit;
    }
}

$page_title = 'Contacto y Cotizaciones - DracoFix';
$active = 'contacto';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<header class="hero-bg py-5"><div class="container px-5 text-center my-5">
<h1 class="display-5 fw-bolder text-white mb-2">Contacto y Cotizaciones</h1>
<p class="hero-subtitle">Cuéntanos qué le pasa a tu equipo y te cotizamos. Para cotizar necesitas iniciar sesión.</p>
</div></header>
<section class="py-5"><div class="container px-5 my-5"><div class="row gx-5 justify-content-center"><div class="col-lg-6">
<?php if (!esta_logueado()): ?>
<div class="card card-draco p-4 text-center">
<h2 class="h5 fw-bolder text-white">Inicia sesión para cotizar</h2>
<p class="text-muted">Tu cotización se guarda en tu cuenta, para que puedas verla en Mi cuenta.</p>
<div class="d-grid gap-2">
<a class="btn btn-draco-primary" href="login.php">Iniciar sesión</a>
<a class="btn btn-draco-secondary" href="register.php">Crear una cuenta</a>
</div>
</div>
<?php else: ?>
<?php if ($error !== ''): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
<form id="formCotizacion" method="post" action="contacto.php" novalidate>
<div class="mb-3"><label class="form-label" for="nombre">Nombre Completo</label><input class="form-control" id="nombre" name="nombre" type="text" required value="<?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="email">Correo Electrónico / WhatsApp</label><input class="form-control" id="email" name="email" type="text" required value="<?php echo htmlspecialchars($_SESSION['usuario_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label class="form-label" for="tipo">Tipo de Dispositivo</label><select class="form-control" id="tipo" name="tipo" required><option value="">Elige...</option><option>Laptop</option><option>PC de Escritorio</option><option>Impresora</option><option>Smartphone</option><option>Otro</option></select></div>
<div class="mb-3"><label class="form-label" for="marca">Marca y Modelo del Equipo</label><input class="form-control" id="marca" name="marca" type="text" required></div>
<div class="mb-3"><label class="form-label" for="descripcion">Descripción de la falla o mantenimiento requerido</label><textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea></div>
<div id="errorCotizacion" class="text-danger mb-3"></div>
<button class="btn btn-draco-primary btn-lg w-100" type="submit">Enviar Cotización</button>
</form>
<p class="text-muted mt-3 mb-0">Hola, <?php echo htmlspecialchars(usuario_actual_nombre(), ENT_QUOTES, 'UTF-8'); ?>. Tu cotización se guardará en SQLite y la verás en <a href="dashboard.php" class="text-pink">Mi cuenta</a>.</p>
<?php endif; ?>
</div></div></div></section>
<?php include 'includes/footer.php'; ?>
