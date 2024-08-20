<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Citas en Línea</title>
    <style>
        body{
        font-family: "Montserrat", sans-serif;
        }
        .primera-linea{
            line-height: 20%;
            justify-content: center;
            text-align: center;
            font-weight: bold;
            font-size: 27rem;
            color: #565658;
        }
        .segunda-linea{
            line-height: 20%;
            justify-content: center;
            text-align: center;
            font-size: 15rem;
            
        }
        .texto-fecha{
            justify-content: center;
            text-align: center;
            font-size: 25rem;
            text-transform: uppercase;

        }
        .hora{
            justify-content: center;
            text-align: center;
            font-size: 30rem;
        }
        .sede{
            font-weight: bold;
            justify-content: center;
            text-align: center;
            font-size: 25rem;
        }
        .direccion{
            justify-content: center;
            text-align: center;
        }
        .nombre{
            line-height: 20%;
            font-weight: bold;
            justify-content: center;
            text-align: center;
            font-size: 25rem;
        }
        .cargo{            
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p><span class="primera-linea">{{$evento->nombre}}</span></p>
    <p><span class="segunda-linea">EL  EVENTO  SE  LLEVARÁ  A  CABO  EL  PRÓXIMO</span></p>
    <p><span class="texto-fecha">{{$f}}</span></p>
    <p><span class="hora">{{$hora}}</span></p>
    <p><span class="sede">{{$evento->sede}}</span></p>
    <p><span class="direccion">{{$evento->domicilio_sede}}</span></p>
    <p><span class="nombre">{{$invitado->nombre}} {{$invitado->apellido_p}} {{$invitado->apellido_m}}</span></p>
    <p><span class="cargo">{{$invitado->cargo}}</span></p>

</body>
</html>