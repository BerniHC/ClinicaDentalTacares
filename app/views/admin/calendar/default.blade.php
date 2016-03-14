@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var date = moment().format('YYYYMMDD');
        var time = moment().format('HHmm');

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            firstDay: '{{ Setting::get("agenda.first_day") }}',
            defaultDate: '{{ $date }}',
            defaultView: '{{ $view }}',
            lang: 'es',
            minTime: '{{ date("H:i", strtotime(Setting::get("agenda.min_time"))) }}',
            maxTime: '{{ date("H:i", strtotime(Setting::get("agenda.max_time"))) }}',
            timeFormat: {
                day: 'h:mm a',
                week: 'h(:mm)t',
                month: 'h(:mm)t - '
            },
            axisFormat: 'h(:mm)a',
            slotDuration: '{{ Setting::get("agenda.slot_duration") }}',
            events: {
                url: '{{ URL::route("calendar-events") }}',
                error: function () {
                    alert('Error al cargar los datos.');
                }
            },
            dayClick: function (datetime, jsEvent, view) {
                date = moment(datetime).format('YYYYMMDD');
                time = moment(datetime).format('HHmm');

                switch (view.name) {
                    case 'agendaDay':
                        $('#modal').modal('toggle');
                        break;
                    case 'agendaWeek':
                        var url = '{{ URL::route("appointment-add") }}' + '/' + date + '/' + time;
                        window.location.href = url;
                        break;
                    case 'month':
                        $('#calendar').fullCalendar('changeView', 'agendaDay');
                        $('#calendar').fullCalendar('gotoDate', datetime);
                        break;
                }
            }
        });
        $('#go-to-date').click(function () {
            var target = $('input[name="date"]').val();
            target = moment(target, 'DD/MM/YYYY');
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            $('#calendar').fullCalendar('gotoDate', target);
        });
        $('#btn-appointment').click(function () {
            var url = '{{ URL::route("appointment-add") }}' + '/' + date + '/' + time;
            window.location.href = url;
        });
        $('#btn-event').click(function () {
            var url = '{{ URL::route("event-add") }}' + '/' + date + '/' + time;
            window.location.href = url;
        });
    });
</script>
@stop
@section('content')
<div class="row">
<div class='col-xs-12 col-sm-6 form-inline hidden-xs'>
    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
        <div class='input-group date' data-role="datepicker">
            {{ Form::text('date', date('d/m/Y', strtotime($date)), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if( $errors->has('date') )
        <span class="help-block">{{ $errors->get('date')[0] }}</span>
        @endif
    </div>
    <button id="go-to-date" type="button" class="btn btn-default">Ir</button>
</div>
<div class="col-xs-12 col-sm-6 text-right">
    <span class="label label-info">Citas</span>
    <span class="label label-success">Eventos</span>
</div>
</div>
<br/><br/>
<div class="row">
    <div class="col-xs-12">
        @include('layouts.alerts')
    </div>
    <div class="col-xs-12">
        <div id='calendar'></div>
    </div>
    <div id="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center" style="padding: 15px 20px 5px;">
                    Elija una acción
                </div>
                <div class="modal-footer" style="padding: 15px 40px;">
                    <button id="btn-appointment" type="button" class="btn btn-info">Agregar Cita</button>
                    <button id="btn-event" type="button" class="btn btn-success">Agregar Evento</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
