<?php
// DracoFix - Sesión, mismo patrón que sis_login de clase.
require_once __DIR__ . '/../config/db.php';

function esta_logueado() {
    return isset($_SESSION['usuario_id']);
}

function usuario_actual_nombre() {
    return $_SESSION['usuario_nombre'] ?? 'Usuario';
}

function es_admin() {
    return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
}

function requerir_admin() {
    requerir_login();
    if (!es_admin()) {
        header('Location: dashboard.php');
        exit;
    }
}

function requerir_login() {
    if (!esta_logueado()) {
        header('Location: login.php');
        exit;
    }
}
