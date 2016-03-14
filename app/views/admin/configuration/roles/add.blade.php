@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="control-label">Nombre *</label>
            {{ Form::text('name', '', array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('name') )
            <span class="help-block">{{ $errors->get('name')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
    </div>
</form>
@stop