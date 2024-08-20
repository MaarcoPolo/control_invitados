<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitación</title>
    <style>
        body{
            /* font-family: "Montserrat", sans-serif;
            text-align: justify;
            font-size: 14; */
        }
        .nombre-evento{
            font-family: "Montserrat", sans-serif;
            text-align: justify;
            font-size: 1rem;
            /* text-transform: uppercase; */
            color: black;
            /* font-weight: bold; */
        }
        .lugar{
            text-align: center;
            font-size: 20rem;
            text-transform: uppercase;
            color: #6a73a0;
            font-weight: bold;
        }
        .texto{
            text-align: center;
        }
        .texto-fecha{
            text-align: center;
            font-size: 30rem;
        }
        .hora{
            text-align: center;
            font-size: 35rem;
        }
        .firma{
            text-align: left;
        }
        .firma2{
            text-align: right;
        }
        .correo {
            font-family: "Montserrat", sans-serif;
            text-align: justify;
            font-size: 2rem;
        }
    </style>
</head>
<body >


    <p class="nombre-evento">
    <b>Estimado/a: </b> {{$invitado->nombre}} {{$invitado->apellido_p}} {{$invitado->apellido_m}} <br><br>

    Espero este mensaje le encuentre bien. <br><br>

    Por medio del presente, tenemos el agrado de invitarle al evento <strong>{{$evento->nombre}}</strong>, organizado por <strong>{{$evento->organizador}}.</strong> El evento se llevará a cabo el próximo <strong>{{$f}}</strong> a las <strong>{{$hora}}</strong> en el <strong>{{$evento->sede}}</strong>, ubicado en <strong>{{$evento->domicilio_sede}}.</strong> 

    <br><br>
    Adjunto encontrará la imagen con todos los detalles del evento.
    <br><br>

    Le recordamos que es imprescindible presentar el código QR al momento del acceso, ya que es de uso personal e intransferible.

    <br><br>
    Agradecemos de antemano su atención y esperamos contar con su valiosa presencia en este importante diálogo.
    <br><br>
    Atentamente,
    <br><br>
    {{$evento->organizador}}
    <br><br><br>
    
    <a href="https://eventos.pjpuebla.gob.mx/confirmacion?folio={{$invitado->folio}}">CONFIRMA TU ASISTENCIA DANDO CLIC AQUÍ.</a></p>
    <div>
    <!-- <img style="height: 10rem; width: 10rem;" src="../../../public/img/image-login.png" alt=""> -->
    
    <!-- <img style="height: 3rem; width: 3rem;" src="ub.png" alt=""> -->
    <img style="height: 3rem; width: 3rem;" src="https://img.freepik.com/vector-gratis/ubicacion_53876-25530.jpg?t=st=1721429830~exp=1721433430~hmac=1fd9a8e5f435a3d3e0ba0eee5c51d7e29530d53bfb0ab9406f1608b277d9c3e9&w=740" alt=""><a href="{{$evento->ubicacion}}">CONSULTA LA UBICACION DEL EVENTO AQUÍ.</a></p>
        <!-- <img style="height: 10rem; width: 10rem;" src="../../public/img/image-login.png" alt=""> -->
    </div>
    {{--  <a href="url">Enlace de texto u objeto  --}}
    {{--  https://eventos.pjpuebla.gob.mx/confirmacion?folio={{$invitado->folio}}</p>  --}}

</body>
</html>