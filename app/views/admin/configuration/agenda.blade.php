<?php
    $week_days = array(
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    );

    $slot_durations = array(
        '00:10:00' => '10 minutos',
        '00:15:00' => '15 minutos',
        '00:20:00' => '20 minutos',
        '00:30:00' => '30 minutos',
    );
?>
@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#min_time, #max_time').datetimepicker({
                language: 'es-CR',
                pickDate: false,
                format: 'hh:mm A'
            });
        });
    </script>
@stop
@section('content')
<ul class="nav nav-tabs" role="tablist">
    <li><a href="{{ URL::route('config-website') }}" role="tab">Sitio Web</a></li>
    <li class="active"><a href="{{ URL::route('config-agenda') }}" role="tab">Agenda</a></li>
    <li><a href="{{ URL::route('role-list') }}" role="tab">Roles</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('metatype-list') }}" role="tab">Metatipos</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('treatment-list') }}" role="tab">Tratamientos</a></li>
</ul>
<br/>
@include('layouts.alerts', array('alert_info' => true))
        <form class="row" method="post">
            {{ Form::token() }}
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('first_day') ? 'has-error' : '' }}">
                    <label for="first_day" class="control-label">Primer día de la semana *</label>
                    {{ Form::select('first_day', $week_days, Setting::get('agenda.first_day'), array('class' => 'form-control')) }}
                    @if( $errors->has('first_day') )
                    <span class="help-block">{{ $errors->get('first_day')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('min_time') ? 'has-error' : '' }}">
                    <label for="min_time" class="control-label">Hora mínima *</label>
                    <div class='input-group date' id='min_time' data-date-format="hh:mm A">
                        {{ Form::text('min_time', Setting::get('agenda.min_time'), array('class' => 'form-control', 'data-mask' => '99:99 aa', 'placeholder' => '12:59 AM')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    @if( $errors->has('min_time') )
                    <span class="help-block">{{ $errors->get('min_time')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('max_time') ? 'has-error' : '' }}">
                    <label for="max_time" class="control-label">Hora máxima *</label>
                    <div class='input-group date' id='max_time' data-date-format="hh:mm A">
                        {{ Form::text('max_time', Setting::get('agenda.max_time'), array('class' => 'form-control', 'data-mask' => '99:99 aa', 'placeholder' => '12:59 AM')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    @if( $errors->has('max_time') )
                    <span class="help-block">{{ $errors->get('max_time')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('slot_duration') ? 'has-error' : '' }}">
                    <label for="slot_duration" class="control-label">Duración del bloque *</label>
                    {{ Form::select('slot_duration', $slot_durations, Setting::get('agenda.slot_duration'), array('class' => 'form-control')) }}
                    @if( $errors->has('slot_duration') )
                    <span class="help-block">{{ $errors->get('slot_duration')[0] }}</span>
                    @endif
                </div>
                <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
            </div>
        </form>
@stop