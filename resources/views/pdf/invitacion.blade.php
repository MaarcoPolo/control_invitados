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
        .nombre-evento{
            text-align: center;
            font-size: 20rem;
            text-transform: uppercase;
            color: #6a73a0;
            font-weight: bold;
        }
        .lugar{
            text-align: center;
            font-size: 20rem;
            text-transform: uppercase;
            color: #6a73a0;
            font-weight: bold;
        }
        .primera-linea{
            text-align: center;
            font-weight: bold;
            font-size: 28rem;
        }
        .segunda-linea{
            text-align: center;
            font-size: 20rem;
        }
        .texto-fecha{
            margin-top: 0%;
            text-align: center;
            font-size: 30rem;
            text-transform: uppercase;

        }
        .hora{
            text-align: center;
            font-size: 35rem;
        }
        .sede{
            text-align: center;

        }
        .domicilio{
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
    <p><span class="primera-linea">TRIBUNALES DE JUSTICIA LOCAL</span><br><br>
    <span class="segunda-linea">EL  EVENTO  SE  LLEVARÁ  A  CABO  EL  PRÓXIMO</span><br><br>
    <span class="texto-fecha">{{$f}}</span><br><br><br>
    <span class="hora">{{$hora}}</span><br><br><br>
    <span class="sede">{{$evento->sede}}</span><br><br><br>
    <span class="direccion">{{$evento->domicilio_sede}}</span>
    </p>
</body>
</html>