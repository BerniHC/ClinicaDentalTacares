@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="control-label">Correo Electrónico *</label>
            {{ Form::text('email', '', array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('email') )
            <span class="help-block">{{ $errors->get('email')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="control-label">Contraseña *</label>
            {{ Form::password('password', array('class' => 'form-control', 'maxlength' => '12')) }}
            @if( $errors->has('password') )
            <span class="help-block">{{ $errors->get('password')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>
                {{ Form::checkbox('remember_me', 'true') }} Recordarme?
            </label>
        </div>
        <div class="form-group">
            <a class="pull-right" href="{{ URL::route('forgot-password') }}">¿Has olvidado la contraseña?</a>
            <button class="btn btn-success btn-loading" type="submit">Entrar</button>
        </div>
    </div>
</form>
@stop