document.addEventListener('DOMContentLoaded', () => {
    window.openClientModal = function (id = null, name = '', phone = '', address = '') {
        // Cambiar el título del modal según sea creación o edición
        document.getElementById('clientModalLabel').innerText = id ? 'Editar Cliente' : 'Registrar Cliente';
        // Rellenar los campos del formulario con datos existentes (si los hay)
        document.getElementById('clientId').value = id || '';
        document.getElementById('clientName').value = name || '';
        document.getElementById('clientPhone').value = phone || '';
        document.getElementById('clientAddress').value = address || '';

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('clientModal'));
        modal.show();
    };

    window.saveClient = function () {
        // Obtener valores del formulario
        const id = document.getElementById('clientId').value;
        const name = document.getElementById('clientName').value;
        const phone = document.getElementById('clientPhone').value;
        const address = document.getElementById('clientAddress').value;

        // Recuperar el usuario_id desde localStorage
        const usuarioId = localStorage.getItem('user_id');

        if (!usuarioId) {
            alert('No se encontró el ID del usuario. Por favor, vuelva a iniciar sesión.');
            return;
        }

        // Determinar método y URL según si es creación o edición
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/clientes/${id}` : '/clientes';

        // Enviar datos al backend
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                phone: phone,
                address: address,
                usuario_id: usuarioId // Enviar el usuario_id
            })
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload(); // Recargar la página después de guardar
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message) {
                    alert(error.message);
                } else {
                    alert('Hubo un error al guardar el cliente.');
                }
            });
    };
});
