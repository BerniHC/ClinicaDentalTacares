@extends('layouts.email')
@section('content')
<h2>Confirmación de la cuenta</h2>
<br/>
<strong>Hola, {{ $username }}</strong>
<br/><br/>
Se ha solicitado la apertura de una cuenta en <a href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>. 
Para completar el proceso de inscripción haga clic en el siguiente enlace: 
<a href='{{ $confirmation_url }}'>{{ $confirmation_url }}</a>.
<br/><br/>
Sus credenciales de acceso son:<br/>
Nombre de usuario: <strong>{{ $email }}</strong><br/>
Contraseña: <strong>{{ $password }}</strong><br/>
Código de confirmación: <strong>{{ $confirmation_code }}</strong>
<br/><br/>
Si no has realizado dicha solicitud o no quieres confirmar la cuenta, no es necesario que lleves a cabo ninguna acción. 
<br/><br/>
Si necesita ayuda, contacte por favor con el administrador del sitio,<br/>
{{ Setting::get('website.admin_name') }}<br/>
{{ Setting::get('website.admin_email') }}<br/>
<br/>
@stop