<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
</head>
<body>
<!-- Mensaje de bienvenida -->
<h1>Bienvenido, {{ $usuario->name }}</h1>
<h2>Listado de Clientes</h2>

@foreach ($clientes as $cliente)
    <h3>Cliente: {{ $cliente->name }}</h3>
    <p>Teléfono: {{ $cliente->phone }}</p>
    <p>Dirección: {{ $cliente->address }}</p>
    <p>Usuario ID: {{ $cliente->usuario_id }}</p>

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
            @endforeach
        </ul>
    @else
        <p>Este cliente no tiene mascotas registradas.</p>
    @endif
@endforeach
</body>
</html>
