@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").setMinDate(e.date);
                $('#end_date input').val($('#start_date input').val());
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").setMaxDate(e.date);
            });
            $("[name='all_day_event']").click(function () {
                if ($(this).is(":checked")) {
                    $('#start_time').data("DateTimePicker").disable();
                    $('#end_date').data("DateTimePicker").disable();
                    $('#end_time').data("DateTimePicker").disable();
                }
                else {
                    $('#start_time').data("DateTimePicker").enable();
                    $('#end_date').data("DateTimePicker").enable();
                    $('#end_time').data("DateTimePicker").enable();
                }
            });
            if($("[name='all_day_event']").is(':checked')) {
                $('#start_time').data("DateTimePicker").disable();
                $('#end_date').data("DateTimePicker").disable();
                $('#end_time').data("DateTimePicker").disable();
            }
        });
    </script>
@stop
@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        {{ Form::hidden('schedule_id', 0) }}
        <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
            <label for="subject" class="control-label">Asunto *</label>
            {{ Form::text('subject', '', array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('subject') )
            <span class="help-block">{{ $errors->get('subject')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción</label>
            {{ Form::textarea('description', '', array('class' => 'form-control', 'rows' => 3, 'maxlength' => '1000')) }}
            @if( $errors->has('description') )
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
            <label for="priority" class="control-label">Prioridad *</label>
            {{ Form::select('priority', $priorities, '', array('class' => 'form-control')) }}
            @if( $errors->has('priority') )
            <span class="help-block">{{ $errors->get('priority')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="all_day_event"> 
                {{ Form::checkbox('all_day_event', 'true', $startDate == $endDate) }} Todo el día
            </label>
        </div>
        <div class="row">
           <div class='col-md-6'>
                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                    <label for="start_date" class="control-label">Fecha Inicio *</label>
                    <div class='input-group date' id='start_date' data-role="datepicker">
                        {{ Form::text('start_date', date('d/m/Y', $startDate), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    @if( $errors->has('start_date') )
                    <span class="help-block">{{ $errors->get('start_date')[0] }}</span>
                    @endif
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label for="start_time" class="control-label">Hora Inicio *</label>
                    <div class='input-group date' id='start_time' data-role="timepicker">
                        {{ Form::text('start_time', date('h:i A', $startDate), array('class' => 'form-control', 'data-mask' => '99:99 aa', 'placeholder' => '12:59 AM')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    @if( $errors->has('start_time') )
                    <span class="help-block">{{ $errors->get('start_time')[0] }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
           <div class='col-md-6'>
                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                    <label for="end_date" class="control-label">Fecha Fin *</label>
                    <div class='input-group date' id='end_date' data-role="datepicker">
                        {{ Form::text('end_date', date('d/m/Y', $endDate), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    @if( $errors->has('end_date') )
                    <span class="help-block">{{ $errors->get('end_date')[0] }}</span>
                    @endif
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                    <label for="end_time" class="control-label">Hora Fin *</label>
                    <div class='input-group date' id='end_time' data-role="timepicker">
                        {{ Form::text('end_time', date('h:i A', $endDate), array('class' => 'form-control', 'data-mask' => '99:99 aa', 'placeholder' => '12:59 AM')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    @if( $errors->has('end_time') )
                    <span class="help-block">{{ $errors->get('end_time')[0] }}</span>
                    @endif
                </div>
            </div>
        </div>
        <button id="check-availability" class="btn btn-success" type="button">Agregar</button>
    </div>
</form>
@stop