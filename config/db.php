<?php
// DracoFix - Conexión SQLite, mismo patrón que en clase (sis_login / CRUD estudiantes).
// La base se crea sola en data/dracofix.db la primera vez que se abre el sitio.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db_path = __DIR__ . '/../data/dracofix.db';
if (!is_dir(__DIR__ . '/../data')) { mkdir(__DIR__ . '/../data', 0777, true); }
try {
    $pdo = new PDO('sqlite:' . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        rol TEXT NOT NULL DEFAULT 'cliente',
        creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");
    // Si la tabla usuarios ya existía sin rol, se agrega.
    $cols_usuarios = $pdo->query("PRAGMA table_info(usuarios)")->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('rol', $cols_usuarios, true)) {
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN rol TEXT NOT NULL DEFAULT 'cliente'");
    }
    $pdo->exec("CREATE TABLE IF NOT EXISTS misiones (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        categoria TEXT NOT NULL,
        falla TEXT NOT NULL,
        solucion TEXT NOT NULL,
        video_url TEXT,
        foto_url TEXT,
        fecha TEXT DEFAULT CURRENT_DATE
    )");
    // Si la tabla misiones ya existía sin foto_url, se agrega.
    $cols_misiones = $pdo->query("PRAGMA table_info(misiones)")->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('foto_url', $cols_misiones, true)) {
        $pdo->exec("ALTER TABLE misiones ADD COLUMN foto_url TEXT");
    }
    if (!in_array('video_antes_url', $cols_misiones, true)) {
        $pdo->exec("ALTER TABLE misiones ADD COLUMN video_antes_url TEXT");
    }
    if (!in_array('video_despues_url', $cols_misiones, true)) {
        $pdo->exec("ALTER TABLE misiones ADD COLUMN video_despues_url TEXT");
    }
    $pdo->exec("CREATE TABLE IF NOT EXISTS resenas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        email TEXT NOT NULL,
        servicio TEXT NOT NULL,
        calificacion INTEGER NOT NULL,
        comentario TEXT NOT NULL,
        fecha TEXT DEFAULT CURRENT_DATE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS cotizaciones (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER,
        nombre TEXT NOT NULL,
        contacto TEXT NOT NULL,
        tipo_dispositivo TEXT NOT NULL,
        marca_modelo TEXT NOT NULL,
        descripcion TEXT NOT NULL,
        estado TEXT DEFAULT 'pendiente',
        fecha TEXT DEFAULT CURRENT_DATE
    )");
    // Si la tabla ya existía sin usuario_id, se agrega (para bases creadas antes).
    $cols = $pdo->query("PRAGMA table_info(cotizaciones)")->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('usuario_id', $cols, true)) {
        $pdo->exec("ALTER TABLE cotizaciones ADD COLUMN usuario_id INTEGER");
    }
    // Ejemplos iniciales de Misiones (solo si la tabla está vacía).
    // Se pueden editar o eliminar desde la página, son datos, no contenido fijo.
    $total_misiones = (int)$pdo->query("SELECT COUNT(*) FROM misiones")->fetchColumn();
    if ($total_misiones === 0) {
        $stmt = $pdo->prepare("INSERT INTO misiones (titulo, categoria, falla, solucion, video_url, foto_url, video_antes_url, video_despues_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(['Mantenimiento a impresora de tinta continua', 'Impresora', 'Cabezales tapados y almohadillas saturadas de tinta, error al imprimir colores.', 'Limpieza y desobstrucción de cabezales, revisión del sistema de tinta continua y de las almohadillas.', 'assets/video/impresora-epson-durante.mp4,assets/video/impresora-epson-durante-2.mp4', 'assets/img/misiones/almohadillas-sucias-antes.jpg', 'assets/video/impresora-epson-antes.mp4', 'assets/video/impresora-epson-despues-rosa.mp4,assets/video/impresora-epson-despues-limpia.mp4,assets/video/impresora-epson-despues-2.mp4']);
        $stmt->execute(['Mantenimiento preventivo a laptop con sobrecalentamiento', 'PC / Laptop', 'Se calentaba y se apagaba.', 'Limpieza interna, cambio de pasta térmica y optimización del sistema.', '', '', '', '']);
        $stmt->execute(['Mantenimiento a impresora láser Samsung', 'Impresora', 'Mantenimiento preventivo, limpieza interna.', 'Limpieza interna, revisión de rodillos y tóner, armado y prueba de impresión.', 'assets/video/impresora-laser-mantenimiento.mp4', '', 'assets/video/impresora-laser-antes.mp4', '']);
    } else {
        // Para bases ya creadas: agregar la misión láser si aún no existe,
        // y la foto de almohadillas a la misión de tinta continua.
        $existe_laser = (int)$pdo->query("SELECT COUNT(*) FROM misiones WHERE titulo = 'Mantenimiento a impresora láser Samsung'")->fetchColumn();
        if ($existe_laser === 0) {
            $stmt = $pdo->prepare("INSERT INTO misiones (titulo, categoria, falla, solucion, video_url, foto_url, video_antes_url, video_despues_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(['Mantenimiento a impresora láser Samsung', 'Impresora', 'Mantenimiento preventivo, limpieza interna.', 'Limpieza interna, revisión de rodillos y tóner, armado y prueba de impresión.', 'assets/video/impresora-laser-mantenimiento.mp4', '', 'assets/video/impresora-laser-antes.mp4', '']);
        }
        $pdo->exec("UPDATE misiones SET foto_url = 'assets/img/misiones/almohadillas-sucias-antes.jpg' WHERE titulo = 'Mantenimiento a impresora de tinta continua' AND (foto_url IS NULL OR foto_url = '')");
        $pdo->exec("UPDATE misiones SET video_despues_url = 'assets/video/impresora-epson-despues-rosa.mp4,assets/video/impresora-epson-despues-limpia.mp4,assets/video/impresora-epson-despues-2.mp4', falla = 'Cabezales tapados y almohadillas saturadas de tinta, error al imprimir colores.' WHERE titulo = 'Mantenimiento a impresora de tinta continua' AND video_despues_url NOT LIKE '%impresora-epson-despues-2.mp4%'");
        $pdo->exec("UPDATE misiones SET video_url = 'assets/video/impresora-epson-durante.mp4,assets/video/impresora-epson-durante-2.mp4' WHERE titulo = 'Mantenimiento a impresora de tinta continua' AND video_url NOT LIKE '%impresora-epson-durante-2.mp4%'");
        $pdo->exec("UPDATE misiones SET video_antes_url = 'assets/video/impresora-epson-antes.mp4' WHERE titulo = 'Mantenimiento a impresora de tinta continua' AND (video_antes_url IS NULL OR video_antes_url = '')");
    }
    // Una reseña de ejemplo, solo si la tabla está vacía.
    $total_resenas = (int)$pdo->query("SELECT COUNT(*) FROM resenas")->fetchColumn();
    if ($total_resenas === 0) {
        $stmt = $pdo->prepare("INSERT INTO resenas (nombre, email, servicio, calificacion, comentario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['Cliente de DracoFix', 'cliente@dracofix.local', 'Impresora', 5, 'Mi impresora volvió a imprimir como nueva, y me explicaron qué le hicieron.']);
    }
} catch (PDOException $e) {
    die('Error de base de datos: ' . $e->getMessage());
}
