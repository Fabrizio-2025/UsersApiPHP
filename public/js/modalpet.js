document.addEventListener('DOMContentLoaded', () => {
    window.openPetModal = function (id = null, name = '', especie = '', raza = '', edad = '', clientId = null) {
        document.getElementById('petModalLabel').innerText = id ? 'Editar Mascota' : 'Registrar Mascota';
        document.getElementById('petId').value = id || '';
        document.getElementById('petName').value = name || '';
        document.getElementById('petEspecie').value = especie || '';
        document.getElementById('petRaza').value = raza || '';
        document.getElementById('petEdad').value = edad || '';
        document.getElementById('clientIdForPet').value = clientId || '';

        const modal = new bootstrap.Modal(document.getElementById('petModal'));
        modal.show();
    };

    window.savePet = function () {
        const id = document.getElementById('petId').value;
        const clientId = document.getElementById('clientIdForPet').value;
        const name = document.getElementById('petName').value;
        const especie = document.getElementById('petEspecie').value;
        const raza = document.getElementById('petRaza').value;
        const edad = document.getElementById('petEdad').value;

        const method = id ? 'PUT' : 'POST';
        const url = id ? `/mascotas/${id}` : '/mascotas';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, especie, raza, edad, cliente_id: clientId })
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al guardar la mascota.');
            });
    };
});
