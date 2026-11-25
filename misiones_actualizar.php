<?php
// DracoFix - Actualizar misión. UPDATE, patrón actualizar.php del CRUD de clase. Solo admin.
require_once __DIR__ . '/includes/auth.php';
requerir_admin();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$titulo = trim($_POST['titulo'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$falla = trim($_POST['falla'] ?? '');
$solucion = trim($_POST['solucion'] ?? '');
$video_url = trim($_POST['video_url'] ?? '');
$foto_url = trim($_POST['foto_url'] ?? '');
$video_antes_url = trim($_POST['video_antes_url'] ?? '');
$video_despues_url = trim($_POST['video_despues_url'] ?? '');

if (!$id || $titulo === '' || $categoria === '' || $falla === '' || $solucion === '') {
    exit('Datos inválidos. Regresa al formulario.');
}

$consulta = $pdo->prepare('UPDATE misiones SET titulo = ?, categoria = ?, falla = ?, solucion = ?, video_url = ?, foto_url = ?, video_antes_url = ?, video_despues_url = ? WHERE id = ?');
$consulta->execute([$titulo, $categoria, $falla, $solucion, $video_url, $foto_url, $video_antes_url, $video_despues_url, $id]);

header('Location: portafolio.php');
exit;
