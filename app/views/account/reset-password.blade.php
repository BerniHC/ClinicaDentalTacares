@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('token') ? 'has-error' : '' }}">
            {{ Form::label('token', 'Token *', array('class' => 'control-label')) }}
            {{ Form::text('token', $token, array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('token') )
            <span class="help-block">{{ $errors->get('token')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="control-label">Nueva Contraseña *</label>
            {{ Form::password('password', array('class' => 'form-control', 'maxlength' => '12')) }}
            @if( $errors->has('password') )
            <span class="help-block">{{ $errors->get('password')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label for="password_confirmation" class="control-label">Comfirmar Contraseña *</label>
            {{ Form::password('password_confirmation', array('class' => 'form-control', 'maxlength' => '12')) }}
            @if( $errors->has('password_confirmation') )
            <span class="help-block">{{ $errors->get('password_confirmation')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Restablecer Contraseña</button>
    </div>
</form>
@stop