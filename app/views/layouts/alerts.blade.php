@if (count($errors->all()) > 0)
<div class="alert alert-danger fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error en la solicitud!</strong> Corrija los errores e inténtelo de nuevo.
</div>
@elseif ($message = Session::get('info'))
<div class="alert alert-info fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Información!</strong> {{ $message }}
</div>
@elseif ($message = Session::get('success'))
<div class="alert alert-success fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Operación exitósa!</strong> {{ $message }}
</div>
@elseif ($message = Session::get('warning'))
<div class="alert alert-warning fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Advertencia!</strong> {{ $message }}
</div>
@elseif ($message = Session::get('error'))
<div class="alert alert-danger fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Ha ocurrido un error!</strong> {{ $message }}
</div>
@elseif (isset($alert_info) && $alert_info)
<div class="alert alert-info fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    Los campos marcados con * son requeridos.
</div>
@endif
