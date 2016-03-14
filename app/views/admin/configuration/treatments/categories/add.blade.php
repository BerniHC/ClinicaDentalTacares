@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción *</label>
            {{ Form::text('description', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('description') )
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
            <label for="color" class="control-label">Color *</label>
            <div class="input-group" data-role="colorpicker">
                {{ Form::text('color', '', array('class' => 'form-control', 'data-mask' => '#******', 'placeholder' => '#FFFFFF')) }}
                <span class="input-group-addon"><i></i></span>
            </div>
            @if( $errors->has('color') )
            <span class="help-block">{{ $errors->get('color')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop