# DracoFix - Soporte y Reparación Tecnológica

Proyecto final de Programación Web. Mantenimiento y soporte técnico para computadoras, impresoras y celulares.

## Tecnologías
- HTML5, CSS + Bootstrap 5.3.0
- JavaScript (validación de formularios)
- PHP
- SQLite (`data/dracofix.db`, se crea sola)

## Páginas
- `index.php` - Inicio
- `servicios.php` - Catálogo de servicios
- `portafolio.php` - Misiones Completadas (reparaciones reales)
- `resenas.php` - Reseñas y formulario
- `contacto.php` - Contacto y cotizaciones (requiere sesión)
- `register.php` - Crear cuenta
- `login.php` - Iniciar sesión
- `dashboard.php` - Mi cuenta (privada, muestra mis cotizaciones)
- `logout.php` - Cerrar sesión

## Login (mismo patrón que sis_login de clase)
- `config/db.php` crea la tabla `usuarios` en SQLite, con `password_hash`.
- `register.php`: nombre, correo, contraseña mínimo 8 caracteres, confirmar contraseña.
- `login.php`: verifica con `password_verify`, regenera la sesión y guarda `usuario_id`, `usuario_nombre` y `usuario_rol`.
- `dashboard.php`: solo entra si hay sesión, si no redirige a `login.php`.
- Para probar: abre `register.php`, crea una cuenta, luego inicia sesión y pide una cotización en `contacto.php`. La verás en Mi cuenta.

## Rol admin y CRUD de Misiones
- La tabla `usuarios` tiene columna `rol`, por default `cliente`.
- Para hacerte admin: regístrate normal, luego en la base cambia tu rol con esta línea SQL (en DB Browser for SQLite, o en la consola de SQLite):
  `UPDATE usuarios SET rol = 'admin' WHERE email = 'tu@correo.com';`
  Después cierra sesión y vuelve a entrar.
- Solo el admin ve el formulario para agregar misiones en `portafolio.php` y los botones Editar / Eliminar.
- CRUD con el patrón del ejemplo `crud_estudiantes` de clase:
  - `portafolio.php`: lista dinámica (Leer)
  - `misiones_guardar.php`: INSERT (Crear)
  - `misiones_editar.php`: formulario con datos existentes
  - `misiones_actualizar.php`: UPDATE (Actualizar)
  - `misiones_eliminar.php`: DELETE (Eliminar, con confirmación)
- Al crear la base por primera vez se agregan 2 misiones de ejemplo, que se pueden editar o eliminar desde la página.

## Cómo ejecutarlo en WampServer
1. Copia la carpeta `dracofix` a `C:\wamp64\www\`
2. Inicia WampServer (icono en verde)
3. Abre en el navegador: `http://localhost/dracofix/`
4. La base SQLite se crea sola en `data/dracofix.db` al cargar cualquier página que incluya `config/db.php`.

## Paleta
Fondo #0B0C10, tarjetas #1F2833, texto #FFFFFF / #C5C6C7, cian #00B4D8, rosa #F72585, amarillo #FFD166.

## Reseñas
- `resenas.php` guarda en SQLite con INSERT preparado (nombre, correo, servicio, calificación 1-5, comentario) y lista las reseñas dinámicamente, con estrellas. El formulario es público, no requiere sesión.

## Pendiente
- Video del después de la impresora láser, si lo grabas
- Subir a GitHub marisolvillachi/dracofix y repasar para la entrevista presencial

## Videos y fotos en Misiones
- Epson tinta continua: foto antes `assets/img/misiones/almohadillas-sucias-antes.jpg` (almohadillas saturadas), video antes `assets/video/impresora-epson-antes.mp4` (11 s, almohadillas llenas), video durante `assets/video/impresora-epson-durante.mp4` (22 s) y `assets/video/impresora-epson-durante-2.mp4` (25 s, Marisol armando y limpiando la Epson) y video después `assets/video/impresora-epson-despues-rosa.mp4` (10 s, prueba con el logo en rosa, el color que fallaba), `assets/video/impresora-epson-despues-limpia.mp4` (10 s, interior limpio) y `assets/video/impresora-epson-despues-2.mp4` (13 s, recorrido del interior limpio).
- Láser Samsung: video antes `assets/video/impresora-laser-antes.mp4` (11 s, con polvo) y video durante `assets/video/impresora-laser-mantenimiento.mp4` (31 s, limpieza).
- En `portafolio.php` los .mp4 locales se reproducen con `<video controls>`; un campo puede llevar varios videos separados por coma.
