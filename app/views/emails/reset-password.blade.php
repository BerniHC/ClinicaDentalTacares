@extends('layouts.email')
<?php
    $reset_url = URL::route('reset-password', array($token));
?>
@section('content')
<h2>Restablecimiento de la contraseña</h2>
<br/>
<strong>Hola, {{ $username }}</strong><br/><br/>
Use el siguiente token para restablecer su contraseña. Si no has realizado dicha solicitud o no quieres restablecer la contraseña, 
no es necesario que lleves a cabo ninguna acción.<br/><br/>
El token de restablecimiento es: <strong>{{ $token }}</strong><br/><br/>Visite el siguiente enlace para restablecer su contraseña:<br/>
<a href='{{ $reset_url }}'>{{ $reset_url }}</a><br/><br/>Nota: El plazo de caducidad del token es de 30 minutos.
<br/><br/>
Si necesita ayuda, contacte por favor con el administrador del sitio,<br/>
{{ Setting::get('website.admin_name') }}<br/>
{{ Setting::get('website.admin_email') }}<br/>
<br/>
@stop