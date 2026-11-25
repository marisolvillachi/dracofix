<?php
$page_title = 'DracoFix - Mantenimiento y Solución para tus Dispositivos';
$active = 'inicio';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<!-- Hero -->
<header class="hero-bg py-5">
    <div class="container px-5 text-center my-5">
        <img src="assets/img/logo-draco.jpg" alt="Draco, la mascota de DracoFix" class="logo-draco-hero">
        <p class="text-pink fw-bolder mb-2">LA COMANDANTE DE SOPORTE</p>
        <h1 class="display-5 fw-bolder text-white mb-2">Mantenimiento y Solución para tus Dispositivos</h1>
        <p class="hero-subtitle">Diagnóstico preciso para computadoras, impresoras y teléfonos. Traemos tu tecnología de vuelta al planeta.</p>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
            <a class="btn btn-draco-primary btn-lg" href="contacto.php">Solicitar Cotización</a>
            <a class="btn btn-draco-secondary btn-lg" href="portafolio.php">Ver Reparaciones</a>
        </div>
    </div>
</header>

<!-- Sobre DracoFix -->
<section class="py-5 border-bottom">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bolder text-white">Sobre la Comandante / DracoFix</h2>
                <p class="lead text-muted">Soy estudiante de Tecnologías de la Información y trabajo como becaria en soporte técnico. DracoFix es mi emprendimiento para compartir las reparaciones que hago: con diagnóstico honesto, trabajo ágil y sin vueltas.</p>
                <p class="text-muted">Atiendo computadoras, impresoras y celulares. Cada reparación queda registrada como una misión completada, con su diagnóstico y su solución.</p>
                <a class="btn btn-draco-primary" href="servicios.php">Conoce mis Servicios</a>
            </div>
            <div class="col-lg-6">
                <div class="card card-draco p-4">
                    <h3 class="h5 fw-bolder">¿Por qué DracoFix?</h3>
                    <p class="mb-2"><img src="assets/img/logo-draco.jpg" alt="Draco" class="logo-draco-inline"> <strong class="text-white">Draco</strong> es la constelación del Dragón, como el dragoncito de nuestro logo.</p>
                    <p class="mb-2"><i class="bi bi-tools text-cyan"></i> <strong class="text-white">Fix</strong> deja claro que es reparación y soporte.</p>
                    <p class="mb-0"><i class="bi bi-patch-check-fill text-yellow"></i> <strong class="text-white">Garantía:</strong> trabajo revisado y explicado antes de entregarse.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Servicios resumen -->
<section class="py-5 border-bottom" id="servicios">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bolder text-white">Nuestros Servicios</h2>
            <p class="lead text-muted mb-0">Lo que sí sabemos hacer, sin promesas de más</p>
        </div>
        <div class="row gx-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="card card-draco p-4">
                    <div class="feature feature-draco bg-gradient text-white rounded-3 mb-3" style="width:3rem;height:3rem;display:flex;align-items:center;justify-content:center;"><i class="bi bi-pc-display fs-4"></i></div>
                    <h2 class="h4 fw-bolder">PC y Laptops</h2>
                    <p>Limpieza profunda, cambio de pasta térmica, formateo, eliminación de virus y actualización de componentes (SSD / RAM).</p>
                    <a class="text-decoration-none text-pink" href="servicios.php">Ver detalles del servicio <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="card card-draco p-4">
                    <div class="feature feature-draco bg-gradient text-white rounded-3 mb-3" style="width:3rem;height:3rem;display:flex;align-items:center;justify-content:center;"><i class="bi bi-printer fs-4"></i></div>
                    <h2 class="h4 fw-bolder">Impresoras</h2>
                    <p>Mantenimiento a sistemas de tinta continua, desobstrucción de cabezales, reseteo de almohadillas y ajuste mecánico.</p>
                    <a class="text-decoration-none text-pink" href="servicios.php">Ver detalles del servicio <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-draco p-4">
                    <div class="feature feature-draco bg-gradient text-white rounded-3 mb-3" style="width:3rem;height:3rem;display:flex;align-items:center;justify-content:center;"><i class="bi bi-phone fs-4"></i></div>
                    <h2 class="h4 fw-bolder">Smartphones</h2>
                    <p>Cambio de centro de carga, sustitución de pantallas, cambio de batería y respaldo de información.</p>
                    <a class="text-decoration-none text-pink" href="servicios.php">Ver detalles del servicio <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reparaciones destacadas -->
<section class="py-5 border-bottom section-light">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bolder text-white">Misiones Completadas</h2>
            <p class="lead text-muted mb-0">Mantenimientos reales, con video del proceso en cámara rápida</p>
        </div>
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-6">
                <div class="card card-draco p-4">
                    <span class="badge badge-star mb-2" style="width:fit-content;"><i class="bi bi-printer"></i> Impresora</span>
                    <h3 class="h5 fw-bolder">Mantenimiento a impresora de tinta continua</h3>
                    <p class="mb-2"><strong class="text-white">Falla:</strong> no imprimía bien, cabezales tapados.</p>
                    <p class="mb-3"><strong class="text-white">Solución:</strong> limpieza y desobstrucción de cabezales y revisión del sistema de tinta continua.</p>
                    <p class="text-muted mb-0"><i class="bi bi-camera-video"></i> Video en cámara rápida: se agregará en cuanto termine de subirse a Drive.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-draco-secondary" href="portafolio.php">Ver todas las reparaciones</a>
        </div>
    </div>
</section>

<!-- Reseñas destacadas -->
<section class="py-5 border-bottom">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bolder text-white">Lo que dicen nuestros clientes</h2>
            <p class="lead text-muted mb-0">Reseñas reales de familiares y clientes</p>
        </div>
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-6">
                <div class="card card-draco p-4">
                    <p class="mb-1 text-yellow">★★★★★</p>
                    <p class="mb-1">“Mi impresora volvió a imprimir como nueva, y me explicaron qué le hicieron.”</p>
                    <div class="small text-muted">- Cliente de DracoFix</div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-draco-primary" href="resenas.php">Déjanos tu Comentario</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
