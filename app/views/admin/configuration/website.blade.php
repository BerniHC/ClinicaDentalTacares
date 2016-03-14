@section('content')
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="{{ URL::route('config-website') }}" role="tab">Sitio Web</a></li>
    <li><a href="{{ URL::route('config-agenda') }}" role="tab">Agenda</a></li>
    <li><a href="{{ URL::route('role-list') }}" role="tab">Roles</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('metatype-list') }}" role="tab">Metatipos</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('treatment-list') }}" role="tab">Tratamientos</a></li>
</ul>
<br/>
@include('layouts.alerts', array('alert_info' => true))
    <form class="row" method="post" enctype="multipart/form-data">
        {{ Form::token() }}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label">Nombre *</label>
                {{ Form::text('name', Setting::get('website.name'), array('class' => 'form-control', 'maxlength' => '60')) }}
                @if( $errors->has('name') )
                <span class="help-block">{{ $errors->get('name')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slogan') ? 'has-error' : '' }}">
                <label for="slogan" class="control-label">Eslogan</label>
                {{ Form::text('slogan', Setting::get('website.slogan'), array('class' => 'form-control', 'maxlength' => '60')) }}
                @if( $errors->has('slogan') )
                <span class="help-block">{{ $errors->get('slogan')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('admin_name') ? 'has-error' : '' }}">
                <label for="admin_name" class="control-label">Administrador *</label>
                {{ Form::text('admin_name', Setting::get('website.admin_name'), array('class' => 'form-control', 'maxlength' => '50')) }}
                @if( $errors->has('admin_name') )
                <span class="help-block">{{ $errors->get('admin_name')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('admin_email') ? 'has-error' : '' }}">
                <label for="admin_email" class="control-label">Correo Electrónico *</label>
                {{ Form::text('admin_email', Setting::get('website.admin_email'), array('class' => 'form-control', 'maxlength' => '60')) }}
                @if( $errors->has('admin_email') )
                <span class="help-block">{{ $errors->get('admin_email')[0] }}</span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('front') ? 'has-error' : '' }}">
                <label for="front" class="control-label">Portada *</label>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                        <span class="fileinput-filename">{{ Setting::get('website.front') }}</span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Seleccionar archivo</span>
                        <span class="fileinput-exists">Cambiar</span>
                        {{ Form::file('front', array()) }}
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                </div>
                @if( $errors->has('front') )
                <span class="help-block">{{ $errors->get('front')[0] }}</span>
                @endif
            </div>
            <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
        </div>
    </form>
@stop