<?php
// DracoFix - Crear cuenta. Misma lógica que sis_login de clase.
require_once __DIR__ . '/includes/auth.php';

if (esta_logueado()) {
    header('Location: dashboard.php');
    exit;
}

$errores = [];
$nombre = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($nombre === '' || strlen($nombre) > 100) {
        $errores[] = 'El nombre es obligatorio y debe tener máximo 100 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $errores[] = 'Ingresa un correo electrónico válido.';
    }
    if (strlen($password) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }
    if ($password !== $confirmar) {
        $errores[] = 'Las contraseñas no coinciden.';
    }

    if (!$errores) {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
            $stmt->execute([':nombre' => $nombre, ':email' => $email, ':password' => $hash]);
            header('Location: login.php?registro=ok');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errores[] = 'Este correo ya está registrado.';
            } else {
                $errores[] = 'No se pudo completar el registro.';
            }
        }
    }
}

$page_title = 'Crear cuenta - DracoFix';
$active = 'login';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<section class="py-5"><div class="container py-4"><div class="row justify-content-center"><div class="col-12 col-md-8 col-lg-5">
<div class="card card-draco shadow border-0"><div class="card-body p-4 p-md-5">
<div class="text-center mb-4"><img src="assets/img/logo-draco.jpg" alt="Draco" class="logo-draco-hero" style="width:90px;height:90px;margin-bottom:0.5rem;">
<h1 class="h3 text-white mb-2">Crear cuenta</h1><p class="text-muted mb-0">Regístrate para cotizar en DracoFix</p></div>
<?php if ($errores): ?>
<div class="alert alert-danger" role="alert"><ul class="mb-0"><?php foreach ($errores as $error): ?><li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<form id="formRegistro" method="POST" action="register.php" novalidate>
<div class="mb-3"><label for="nombre" class="form-label">Nombre</label><input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required autocomplete="name" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label for="email" class="form-label">Correo electrónico</label><input type="email" class="form-control" id="email" name="email" maxlength="254" required autocomplete="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-3"><label for="password" class="form-label">Contraseña</label><input type="password" class="form-control" id="password" name="password" minlength="8" required autocomplete="new-password"><div class="form-text text-muted">Mínimo 8 caracteres.</div></div>
<div class="mb-4"><label for="confirmar" class="form-label">Confirmar contraseña</label><input type="password" class="form-control" id="confirmar" name="confirmar" minlength="8" required autocomplete="new-password"></div>
<div id="errorRegistro" class="text-danger mb-3"></div>
<button type="submit" class="btn btn-draco-primary w-100">Registrarme</button>
</form>
<p class="text-center mt-4 mb-0 text-muted">¿Ya tienes una cuenta? <a href="login.php" class="text-pink">Inicia sesión</a></p>
</div></div>
</div></div></div></section>
<?php include 'includes/footer.php'; ?>
