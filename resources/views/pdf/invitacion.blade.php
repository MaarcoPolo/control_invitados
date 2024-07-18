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
            justify-content: center;
            text-align: center;
            font-weight: bold;
            font-size: 28rem;
        }
        .segunda-linea{
            line-height: 0%;
            justify-content: center;
            text-align: center;
            font-size: 20rem;
            
        }
        .texto-fecha{
            line-height: 0%;
            justify-content: center;
            
            text-align: center;
            font-size: 30rem;
            text-transform: uppercase;

        }
        .hora{
            line-height: 0%;
            justify-content: center;
            text-align: center;
            font-size: 35rem;
        }
        .sede{
            
            justify-content: center;
            text-align: center;
            font-size: 30rem;

        }
        .direccion{
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
    <p><span class="primera-linea">TRIBUNALES DE JUSTICIA LOCAL</span><br></p>
    <p><span class="segunda-linea">EL  EVENTO  SE  LLEVARÁ  A  CABO  EL  PRÓXIMO</span></p><br>
    <p><span class="texto-fecha">{{$f}}</span><br></p>
    <p><span class="hora">{{$hora}}</span></p><br>
    <p><span class="sede">{{$evento->sede}}</span><br></p>
    <p><span class="direccion">{{$evento->domicilio_sede}}</span></p>
</body>
</html>