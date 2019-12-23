<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuario y contraseña</title>
</head>
<body>
    <h2>Usuario y contraseña</h2>
    <h2>Bienvenido a clinica @include('layouts.nombreEmpresa') </h2>
    <p>
        Usuario: {{$user->name}} <br>
        Contraseña: {{$password}}<br>
    </p>
    <strong> Almacene la clave en un lugar seguro </strong>
    <br>
    <cite>Saludos, clinica @include('layouts.nombreEmpresa') </cite>
</body>
</html>