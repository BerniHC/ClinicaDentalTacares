@section('content')
<form class="row inline-form" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="control-label">Nombre *</label>
            {{ Form::text('name', $role->name, array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('name') )
            <span class="help-block">{{ $errors->get('name')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="permissions" class="control-label">Permisos</label>
            <ul class="list-group">
                @foreach($permissions as $p)
                <li class="list-group-item">
                    <label>{{ Form::checkbox('permissions[]', $p->id, $role->permissions()->find($p->id) != null) }} {{ $p->display_name }}</label>
                </li>
                @endforeach
            </ul>
        </div>
        <button class="btn btn-success btn-loading" type="submit">Guardar</button>
    </div>
</form>
@stop