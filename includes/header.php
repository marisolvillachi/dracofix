<?php
// DracoFix - header común. $page_title y $active se definen antes de incluirlo.
// auth.php inicia la sesión y conecta a SQLite, antes de cualquier HTML.
require_once __DIR__ . '/auth.php';
if (!isset($page_title)) { $page_title = 'DracoFix - Soporte y Reparación Tecnológica'; }
if (!isset($active)) { $active = 'inicio'; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="DracoFix - Mantenimiento y soporte técnico para computadoras, impresoras y celulares en Guadalajara." />
    <meta name="author" content="DracoFix" />
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dracofix.css" rel="stylesheet" />
</head>
<body>
