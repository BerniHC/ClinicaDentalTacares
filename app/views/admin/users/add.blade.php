@section('content')
<ul class="nav nav-pills nav-justified thumbnail setup-panel">
    <li class="active"><a href="#step-1">
        <h4 class="list-group-item-heading" style="margin-bottom: 0">Datos Personales</h4>
    </a></li>
    <li class="disabled"><a href="#step-2">
        <h4 class="list-group-item-heading" style="margin-bottom: 0">Credenciales de Acceso</h4>
    </a></li>
</ul>
<form class="row" method="post" >
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    {{ Form::token() }}
    <!-- Personal Data -->
    <fieldset class="setup-content col-xs-12" id="step-1">
        <legend>Datos Personales</legend>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('document_type') ? 'has-error' : '' }}">
                <label for="document_type" class="control-label">Tipo de Documento *</label>
                {{ Form::select('document_type', $document_types, '', array('class' => 'form-control')) }}
                @if( $errors->has('document_type') )
                <span class="help-block">{{ $errors->get('document_type')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('document_value') ? 'has-error' : '' }}">
                <label for="document_value" class="control-label">Número de Documento *</label>
                {{ Form::text('document_value', '', array('class' => 'form-control', 'maxlength' => '30')) }}
                @if( $errors->has('document_value') )
                <span class="help-block">{{ $errors->get('document_value')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                <label for="firstname" class="control-label">Nombre *</label>
                {{ Form::text('firstname', '', array('class' => 'form-control', 'maxlength' => '50')) }}
                @if( $errors->has('firstname') )
                <span class="help-block">{{ $errors->get('firstname')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('middlename') ? 'has-error' : '' }}">
                <label for="middlename" class="control-label">Primer Apellido</label>
                {{ Form::text('middlename', '', array('class' => 'form-control', 'maxlength' => '50')) }}
                @if( $errors->has('middlename') )
                <span class="help-block">{{ $errors->get('middlename')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                <label for="lastname" class="control-label">Segundo Apellido</label>
                {{ Form::text('lastname', '', array('class' => 'form-control', 'maxlength' => '50')) }}
                @if( $errors->has('lastname') )
                <span class="help-block">{{ $errors->get('lastname')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                <label for="gender" class="control-label">Género *</label>
                @foreach($genders as $index=>$gender)
                <label class="radio-inline">
                    {{ Form::radio('gender', $gender->id, $index == 0) }} {{ $gender->description }}
                </label>
                @endforeach
                @if( $errors->has('gender') )
                <span class="help-block">{{ $errors->get('gender')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
                <label for="birthdate" class="control-label">Fecha de Nacimiento *</label>
                <div class='input-group date' data-role="datepicker">
                    {{ Form::text('birthdate', '', array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
                @if( $errors->has('birthdate') )
                <span class="help-block">{{ $errors->get('birthdate')[0] }}</span>
                @endif
            </div>
            <a class="btn btn-primary next-step" href="#step-2">Siguiente</a>
        </div>
    </fieldset>
    <!-- Credenciales de Acceso-->
    <fieldset class="setup-content col-xs-12" id="step-2">
        <legend>Credenciales de Acceso</legend>
        <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Correo Electrónico *</label>
            {{ Form::email('email', '', array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('email') )
            <span class="help-block">{{ $errors->get('email')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="control-label">Contraseña *</label>
            <div class="input-group">
                {{ Form::password('password', array('class' => 'form-control password', 'minlenght' => '6', 'maxlength' => '12')) }}
                <span class="input-group-addon random-pass" title="Generar contraseña" data-length="8" data-input=".password" style="cursor: pointer">
                    <i class="fa fa-refresh"></i>
                </span>
            </div>
            @if( $errors->has('password') )
            <span class="help-block">{{ $errors->get('password')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label for="password_confirmation" class="control-label">Confirmar Contraseña *</label>
            {{ Form::password('password_confirmation', array('class' => 'form-control', 'minlenght' => '6', 'maxlength' => '12')) }}
            @if( $errors->has('password_confirmation') )
            <span class="help-block">{{ $errors->get('password_confirmation')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="require_new_password"> 
                {{ Form::checkbox('require_new_password', 'true', true) }} Solicitar cambiar contraseña
            </label>
        </div>
        <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
            <label for="role" class="control-label">Rol de Usuario *</label>
            {{ Form::select('role', $roles, '', array('class' => 'form-control')) }}
            @if( $errors->has('role') )
            <span class="help-block">{{ $errors->get('role')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
        </div>
    </fieldset>
</form>
@stop