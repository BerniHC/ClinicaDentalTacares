@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('number') ? 'has-error' : '' }}">
            <label for="number" class="control-label">Número Telefónico *</label>
            <div class="input-group">
                <span class="input-group-addon">+506</span>
                {{ Form::text('number', '', array('class' => 'form-control', 'maxlength' => '15')) }}
            </div>
            @if( $errors->has('number') )
            <span class="help-block">{{ $errors->get('number')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop