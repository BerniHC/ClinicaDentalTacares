@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('treatment') ? 'has-error' : '' }}">
            <label class="control-label" for="treatment">Tratamiento* </label>
            {{ Form::select('treatment', $treatments, $treatment->id, array('class' => 'form-control')) }}
            @if( $errors->has('treatment') )
            <span class="help-block">{{ $errors->get('treatment')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            <label class="control-label" for="amount">Cantidad *</label>
            {{ Form::text('amount', $treatment->amount, array('class' => 'form-control', 'min' => '0', 'step' => '1')) }}
            @if( $errors->has('amount') )
            <span class="help-block">{{ $errors->get('amount')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label class="control-label" for="observation">Observación</label>
            {{ Form::textarea('observation', $treatment->observation, array('class' => 'form-control', 'rows' => '3')) }}
            @if( $errors->has('observation') )
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-info" type="submit">Guardar</button>
    </div>
</form>
@stop