<!DOCTYPE html>
<html>
<head>
    <title>Hola Chum</title>
</head>
<body>
<h1>¡Hola, Chum!</h1>
</body>
</html>
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
