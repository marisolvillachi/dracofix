<?php
// DracoFix - Iniciar sesión. Misma lógica que sis_login de clase.
require_once __DIR__ . '/includes/auth.php';

if (esta_logueado()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Correo o contraseña incorrectos.';
    } else {
        $stmt = $pdo->prepare('SELECT id, nombre, email, password, rol FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_rol'] = $usuario['rol'] ?? 'cliente';
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Correo o contraseña incorrectos.';
    }
}

$page_title = 'Iniciar sesión - DracoFix';
$active = 'login';
include 'includes/header.php';
include 'includes/navbar.php';
?>
<section class="py-5"><div class="container py-4"><div class="row justify-content-center"><div class="col-12 col-md-8 col-lg-5">
<div class="card card-draco shadow border-0"><div class="card-body p-4 p-md-5">
<div class="text-center mb-4"><img src="assets/img/logo-draco.jpg" alt="Draco" class="logo-draco-hero" style="width:90px;height:90px;margin-bottom:0.5rem;">
<h1 class="h3 text-white mb-2">Bienvenido</h1><p class="text-muted mb-0">Inicia sesión para cotizar en DracoFix</p></div>
<?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
<div class="alert alert-success" role="status">Registro completado. Ya puedes iniciar sesión.</div>
<?php endif; ?>
<?php if ($error !== ''): ?>
<div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
<form id="formLogin" method="POST" action="login.php" novalidate>
<div class="mb-3"><label for="email" class="form-label">Correo electrónico</label><input type="email" class="form-control" id="email" name="email" required autocomplete="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"></div>
<div class="mb-4"><label for="password" class="form-label">Contraseña</label><input type="password" class="form-control" id="password" name="password" required autocomplete="current-password"></div>
<div id="errorLogin" class="text-danger mb-3"></div>
<button type="submit" class="btn btn-draco-primary w-100">Iniciar sesión</button>
</form>
<p class="text-center mt-4 mb-0 text-muted">¿No tienes una cuenta? <a href="register.php" class="text-pink">Regístrate</a></p>
</div></div>
</div></div></div></section>
<?php include 'includes/footer.php'; ?>
