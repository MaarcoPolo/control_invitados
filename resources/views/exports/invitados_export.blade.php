<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitados</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dependencia</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Estado</th>
                <th>Municipio</th>
                <th>Evento</th>
                <th>Zona</th>
                <th>Confirmo Asistencia</th>
                <th>Ingreso al evento</th>
                <th>Hora Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invitados as $key => $invitado)
            <tr>                
                <td>{{$invitado->nombreC}}</td>
                <td>{{$invitado->dependencia}}</td>
                <td>{{$invitado->cargo}}</td>
                <td>{{$invitado->area}}</td>
                <td>{{$invitado->telefono}}</td>
                <td>{{$invitado->email}}</td>
                <td>{{$invitado->estado}}</td>
                <td>{{$invitado->municipio}}</td>
                <td>{{$invitado->evento}}</td>
                <td>{{$invitado->zona}}</td>
                <td>{{$invitado->confirmo}}</td>
                <td>{{$invitado->ingreso}}</td>
                <td>{{$invitado->hora_ingreso}}</td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
</body>
</html>