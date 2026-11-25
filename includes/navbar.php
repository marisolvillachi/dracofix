<?php
// DracoFix - navbar común. Usa $active: inicio | servicios | portafolio | resenas | contacto
if (!isset($active)) { $active = 'inicio'; }
function nav_active($name, $active) { return $name === $active ? ' active" aria-current="page' : ''; }
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-draco">
    <div class="container px-5">
        <a class="navbar-brand fw-bolder" href="index.php"><img src="assets/img/logo-draco.jpg" alt="Draco" class="logo-draco-nav">DRACOFIX</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Mostrar menú"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo nav_active('inicio', $active); ?>" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link<?php echo nav_active('servicios', $active); ?>" href="servicios.php">Servicios</a></li>
                <li class="nav-item"><a class="nav-link<?php echo nav_active('portafolio', $active); ?>" href="portafolio.php">Reparaciones</a></li>
                <li class="nav-item"><a class="nav-link<?php echo nav_active('resenas', $active); ?>" href="resenas.php">Reseñas</a></li>
                <?php if (esta_logueado()): ?>
                <li class="nav-item"><a class="nav-link<?php echo nav_active('dashboard', $active); ?>" href="dashboard.php">Hola, <?php echo htmlspecialchars(usuario_actual_nombre(), ENT_QUOTES, 'UTF-8'); ?></a></li>
                <li class="nav-item"><a class="btn btn-outline-light btn-sm ms-lg-2 mt-2 mt-lg-0" href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link<?php echo nav_active('login', $active); ?>" href="login.php">Iniciar sesión</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="btn btn-draco-primary btn-sm ms-lg-2 mt-2 mt-lg-0" href="contacto.php">Solicitar Cotización</a></li>
            </ul>
        </div>
    </div>
</nav>
