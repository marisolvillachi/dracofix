<?php
// DracoFix - Eliminar misión. DELETE, patrón eliminar.php del CRUD de clase. Solo admin.
require_once __DIR__ . '/includes/auth.php';
requerir_admin();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID inválido.');
}

$consulta = $pdo->prepare('DELETE FROM misiones WHERE id = ?');
$consulta->execute([$id]);

header('Location: portafolio.php');
exit;
