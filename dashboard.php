<?php
// DracoFix - Mi cuenta. Página privada, mismo patrón que sis_login.
require_once __DIR__ . '/includes/auth.php';
requerir_login();

$nombre = usuario_actual_nombre();
$email = $_SESSION['usuario_email'] ?? '';
$mis_cotizaciones = [];
$stmt = $pdo->prepare('SELECT * FROM cotizaciones WHERE usuario_id = :id ORDER BY id DESC');
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$mis_cotizaciones = $stmt->fetchAll();

$page_title = 'Mi cuenta - DracoFix';
$active = 'dashboard';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<section class="py-5"><div class="container px-5 my-5">
<div class="card card-draco p-4 p-md-5 mb-4">
<h1 class="h3 text-white">¡Hola, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>!</h1>
<p class="text-muted mb-1">Has iniciado sesión correctamente. Esta es tu página privada en DracoFix.</p>
<p class="text-muted mb-3">Correo: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?> | Rol: <span class="badge badge-star"><?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'cliente', ENT_QUOTES, 'UTF-8'); ?></span></p>
<div class="d-flex gap-2 flex-wrap">
<a class="btn btn-draco-primary" href="contacto.php">Solicitar una cotización</a>
<?php if (es_admin()): ?><a class="btn btn-draco-secondary" href="portafolio.php">Administrar Misiones</a><?php endif; ?>
<a class="btn btn-draco-secondary" href="logout.php">Cerrar sesión</a>
</div>
</div>

<h2 class="h4 fw-bolder text-white mb-3">Mis cotizaciones</h2>
<?php if (count($mis_cotizaciones) === 0): ?>
<div class="card card-draco p-4"><p class="text-muted mb-0">Todavía no tienes cotizaciones. Pide la primera desde Contacto.</p></div>
<?php else: ?>
<div class="table-responsive"><table class="table table-dark table-striped align-middle">
<thead><tr><th>ID</th><th>Dispositivo</th><th>Marca / Modelo</th><th>Estado</th><th>Fecha</th></tr></thead>
<tbody>
<?php foreach ($mis_cotizaciones as $c): ?>
<tr>
<td><?php echo $c['id']; ?></td>
<td><?php echo htmlspecialchars($c['tipo_dispositivo'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($c['marca_modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($c['estado'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($c['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>
</div></section>
<?php include 'includes/footer.php'; ?>
