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

    Por medio del presente, tenemos el agrado de invitarle al evento <strong>"Diálogos Nacionales sobre Tribunales de Justicia Local"</strong>, organizado por la Cámara de Diputados, LXV Legislatura. El evento se llevará a cabo el próximo <strong> martes 23 de julio a las 10:30 AM en el Centro Expositor "Salón Fuerte de Loreto", ubicado en Av. Ejército de Oriente No. 100, Centro Cívico Cultural 5 de Mayo, Zona de los Fuertes, Puebla, México.</strong>

    <br><br>
    Adjunto encontrará la imagen con todos los detalles del evento.
    <br><br>

    Le recordamos que es imprescindible presentar el código QR al momento del acceso, ya que es de uso personal e intransferible.

    <br><br>
    Agradecemos de antemano su atención y esperamos contar con su valiosa presencia en este importante diálogo.
    <br><br>
    Atentamente,

    Cámara de Diputados, LXV Legislatura
    <br><br><br>
    
    CONFIRMA TU ASISTENCIA DANDO CLIC AL SIGUIENTE ENLACE<br>
    https://eventos.pjpuebla.gob.mx/confirmacion?folio={{$invitado->folio}}</p>

</body>
</html>