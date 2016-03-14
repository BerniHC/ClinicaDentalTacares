<?php 

    $code = $error;
    $title = "";
    $message = "";

    switch($code){
        case "400": 
            $title = "Solicitud<br/>Incorrecta";
            $message = "La solicitud no es correcta.";
            break;
        case "401":
            $title = "Acceso<br/>No Autorizado";
            $message = "Es posible que necesite registrarse en el sitio<br/>antes de estar autorizado a acceder a él.";
            break;
        case "403":
            $title = "Acceso<br/>Denegado";
            $message = "El cliente no tiene los privilegios necesarios para acceder a la página solicitada.";
            break;
        case "404":
            $title = "No<br/>Encontrado";
            $message = "El recurso solicitado ya no existe o ha sido desplazado,<br/>o es posible que la dirección esté mal escrita.";
            break;
        case "500":
            $title = "Error Interno<br/>Del Servidor";
            $message = "El servidor no pudo tratar la solicitud. ";
            break;
        case "501":
            $title = "No<br/>Implementado";
            $message = "El servidor no soporta el tipo de servicio o el protocolo solicitado.";
            break;
        case "503":
            $title = "Servicio<br/>No Disponible";
            $message = "El servidor se encuentra temporalmente en reparación. Regresaremos pronto.";
            break;
        case "504":
            $title = "Tiempo de Espera<br/>Agotado";
            $message = "El servidor tomó demasiado tiempo para responder y se desconectó.";
            break;
        default: 
            $title = "Error<br/>Desconocido";
            $message = "";
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
		<link href="{{ URL::to('fonts/error-fonts.css') }}" type="text/css" rel="stylesheet"/>
		<style>
			*{
				margin:0;
				padding:0;
			}
			body{
				font-family: Tahoma, arial, helvetica, sans-serif;
				background:url('{{ URL::asset("images/error_bg.png") }}') repeat;
				background-color:#39c;
				color:white;
				font-size: 18px;
				padding-bottom:20px;
			}
			.error-code{
				font-family: Molot, arial, helvetica, sans-serif;
				font-size: 200px;
				color: white;
				color: rgba(255, 255, 255, 0.98);
				width: 50%;
				text-align: right;
				margin-top: 5%;
				text-shadow: 5px 5px hsl(0, 0%, 25%);
				float: left;
			}
			.title{
				font-family: Akashi, arial, helvetica, sans-serif;
				width: 47%;
				float: right;
				margin-top: 5%;
				font-size: 50px;
				color: white;
				text-shadow: 3px 3px hsl(0, 0%, 25%);
				padding-top: 70px;
			}
			.clear{
				float:none;
				clear:both;
			}
			.content{
				text-align:center;
				line-height: 30px;
			}
			a{
				text-decoration: none;
				color: #ddd;
			}
			a:hover{
				color: #fff;
			}
		</style>
		<title>Error {{ $code }}</title>
	</head>
	<body>
		<p class="error-code">
			{{ $code }}
		</p>
		<p class="title">{{ $title }}</p>
		<div class="clear"></div>
		<div class="content">
			{{ $message }}<br/>
            Puede intentar lo siguiente:<br/>
            <a href="{{ URL::to('/') }}">Ir al inicio</a> o <a href="{{ URL::previous() }}">Regresar a la página anterior</a>
		</div>
	</body>
</html>
