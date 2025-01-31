<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes y Mascotas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/modalclient.js"></script>
    <script src="../js/modalpet.js"></script>
</head>
<body>

<div class="container mt-5">
    <h1>Bienvenido, {{ $usuario->name }}</h1>
    <h2>Listado de Clientes</h2>

    <div id="clientList">
        @foreach ($clientes as $cliente)
            <div class="card p-3 mb-3">
                <li class="list-unstyled pb-4"  >
                    <h3>Cliente: {{ $cliente->name }}</h3>
                    <button class="btn btn-warning btn-sm" onclick="openClientModal({{ $cliente->id }}, '{{ $cliente->name }}', '{{ $cliente->phone }}', '{{ $cliente->address }}')">Editar Cliente</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteClient({{ $cliente->id }})">Eliminar Cliente</button>
                </li>

                <p>Teléfono: {{ $cliente->phone }}</p>
                <p>Dirección: {{ $cliente->address }}</p>

                @if ($cliente->mascotas->isNotEmpty())
                    <h4>Mascotas:</h4>
                    <ul>
                        @foreach ($cliente->mascotas as $mascota)
                            <li>
                                Nombre: {{ $mascota->name }},
                                Especie: {{ $mascota->especie }},
                                Raza: {{ $mascota->raza }},
                                Edad: {{ $mascota->edad }}
                            </li>
                            <li class="list-unstyled pl-2" >
                                <button class="btn btn-warning btn-sm" onclick="openPetModal({{ $mascota->id }}, '{{ $mascota->name }}', '{{ $mascota->especie }}', '{{ $mascota->raza }}', '{{ $mascota->edad }}', {{ $cliente->id }})">Editar Mascota</button>
                                <button class="btn btn-danger btn-sm" onclick="deletePet({{ $mascota->id }})">Eliminar Mascota</button>
                            </li>


                        @endforeach
                    </ul>
                @else
                    <p>Este cliente no tiene mascotas registradas.</p>
                @endif

                <button class="btn btn-primary btn-sm mt-3" onclick="openPetModal(null, '', '', '', '', {{ $cliente->id }})">Registrar Mascota</button>
            </div>
        @endforeach
    </div>

    <button class="btn btn-primary mt-4" onclick="openClientModal()">Registrar Cliente</button>
</div>

<!-- Modal para Clientes -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Registrar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="clientForm">
                    <input type="hidden" id="clientId"> <!-- Campo oculto para edición -->
                    <div class="mb-3">
                        <label for="clientName" class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="clientName" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientPhone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="clientPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientAddress" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="clientAddress">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveClient()">Guardar Cliente</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Mascotas -->
<div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="petModalLabel">Registrar Mascota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="petForm">
                    <input type="hidden" id="petId"> <!-- Campo oculto para edición -->
                    <input type="hidden" id="clientIdForPet"> <!-- Relación cliente-mascota -->

                    <div class="mb-3">
                        <label for="petName" class="form-label">Nombre de la Mascota</label>
                        <input type="text" class="form-control" id="petName" required>
                    </div>
                    <div class="mb-3">
                        <label for="petEspecie" class="form-label">Especie</label>
                        <input type="text" class="form-control" id="petEspecie" required>
                    </div>
                    <div class="mb-3">
                        <label for="petRaza" class="form-label">Raza</label>
                        <input type="text" class="form-control" id="petRaza">
                    </div>
                    <div class="mb-3">
                        <label for="petEdad" class="form-label">Edad</label>
                        <input type="number" class="form-control" id="petEdad" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="savePet()">Guardar Mascota</button>
            </div>
        </div>
    </div>
</div>

<script>
    var userIdFromBlade = {{ $usuario->id }};
</script>

</body>
</html>
