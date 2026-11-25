// DracoFix - JavaScript: validación de formularios y mensajes
document.addEventListener('DOMContentLoaded', function () {
    function validar(formId, errorId, campos) {
        var form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', function (e) {
            var error = document.getElementById(errorId);
            var mensajes = [];
            campos.forEach(function (campo) {
                var input = document.getElementById(campo.id);
                if (!input || !input.value.trim()) {
                    mensajes.push('Falta: ' + campo.nombre);
                    if (input) input.classList.add('is-invalid');
                } else if (input) {
                    input.classList.remove('is-invalid');
                    if (campo.email && input.value.indexOf('@') === -1) {
                        mensajes.push('El correo no es válido.');
                    }
                }
            });
            if (mensajes.length > 0) {
                e.preventDefault();
                if (error) error.textContent = mensajes.join(' ');
                alert(mensajes.join('\n'));
            }
        });
    }
    validar('formLogin', 'errorLogin', [
        { id: 'email', nombre: 'correo', email: true },
        { id: 'password', nombre: 'contraseña' }
    ]);
    validar('formRegistro', 'errorRegistro', [
        { id: 'nombre', nombre: 'nombre' },
        { id: 'email', nombre: 'correo', email: true },
        { id: 'password', nombre: 'contraseña' },
        { id: 'confirmar', nombre: 'confirmar contraseña' }
    ]);
    validar('formResena', 'errorResena', [
        { id: 'nombre', nombre: 'nombre' },
        { id: 'email', nombre: 'correo', email: true },
        { id: 'servicio', nombre: 'servicio' },
        { id: 'calificacion', nombre: 'calificación' },
        { id: 'comentario', nombre: 'comentario' }
    ]);
    validar('formCotizacion', 'errorCotizacion', [
        { id: 'nombre', nombre: 'nombre' },
        { id: 'email', nombre: 'contacto' },
        { id: 'tipo', nombre: 'tipo de dispositivo' },
        { id: 'marca', nombre: 'marca y modelo' },
        { id: 'descripcion', nombre: 'descripción de la falla' }
    ]);
});
