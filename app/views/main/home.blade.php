@section('content')
<div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
    <form id="login-form" method="post" action="{{ URL::route('login') }}">
        {{ Form::token() }}
        <div class="form-group">
            <label for="email" class="control-label">Correo Electrónico *</label>
            {{ Form::text('email', '', array('class' => 'form-control', 'maxlength' => '100')) }}
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Contraseña *</label>
            {{ Form::password('password', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label>
                {{ Form::checkbox('remember_me', 'true') }} Recordarme?
            </label>
        </div>
        <div class="form-group">
            <a class="pull-right" href="#">¿Has olvidado la contraseña?</a>
            <button class="btn btn-success btn-loading" type="submit">Entrar</button>
        </div>
    </form>
</div>
@stop