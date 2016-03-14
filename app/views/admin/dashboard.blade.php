@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            Morris.Area({
                element: 'appointments-chart',
                data: [
                    { y: '2006', a: 100, b: 90 },
                    { y: '2007', a: 75,  b: 65 },
                    { y: '2008', a: 50,  b: 40 },
                    { y: '2009', a: 75,  b: 65 },
                    { y: '2010', a: 50,  b: 40 },
                    { y: '2011', a: 75,  b: 65 },
                    { y: '2012', a: 100, b: 90 }
                ],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Series A', 'Series B']
            });
            Morris.Bar({
                element: 'patients-chart',
                data: {{ json_encode($data_chart2) }},
                xkey: 'y',
                ykeys: 'a',
                labels: ['Pacientes']
            });
        });
    </script>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="{{ URL::route('calendar') }}" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-calendar"></i>
            Calendario
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="{{ URL::route('patient-add') }}" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-user"></i>
            Agregar Paciente
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="{{ URL::route('user-add') }}" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-user-md"></i>
            Agregar Usuario
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="{{ URL::route('reports') }}" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-bar-chart-o"></i>
            Reportes
        </a>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-info widget">
            <div class="panel-heading">
                <h3 class="panel-title">Citas Asignadas para Hoy</h3>
            </div>
            <table class="table table-striped table-hover">
                <tbody data-link="row" class="rowlink">
                    <tr>
                        <td class="text-center">
                            <a class="hidden" href="{{ URL::route('calendar', array( date('Y'), date('m'), date('d') )) }}">Ver</a>
                            <strong>{{ date('d F, Y') }}</strong>
                        </td>
                    </tr>
                    @foreach($schedules as $s)
                    <tr>
                        <td>
                            <a class="hidden" href="{{ URL::route('appointment-view', array($s->appointment->id)) }}">Ver</a>
                            {{ $s->appointment->patient->person->fullname() }}
                            <span class="text-muted pull-right">
                                {{ date('h:i a', strtotime($s->start_datetime)) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-info widget">
            <div class="panel-heading">
                <h3 class="panel-title">Eventos Próximos</h3>
            </div>
            <table class="table table-striped table-hover">
                <tbody data-link="row" class="rowlink">
                    @foreach($events as $e)
                    <tr>
                        <td>
                            <a class="hidden" href="{{ URL::route('event-view', array($e->id)) }}">Ver</a>
                            {{ $e->subject }}
                            <span class="text-muted pull-right">
                                {{ date('d/m/Y', strtotime($e->schedule->start_datetime)) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-info widget">
            <div class="panel-heading">
                <h3 class="panel-title">Pacientes Nuevos</h3>
            </div>
            <table class="table table-striped table-hover">
                <tbody data-link="row" class="rowlink">
                    @foreach($patients as $p)
                    <tr>
                        <td>
                            <a class="hidden" href="{{ URL::route('patient-view', array($p->id)) }}">Ver</a>
                            {{ $p->person->fullname() }}
                            <span class="text-muted pull-right">
                                {{ $p->person->age() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Citas</h3>
            </div>
            <div class="panel-body">
                <div id="appointments-chart" style="height: 250px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Pacientes</h3>
            </div>
            <div class="panel-body">
                <div id="patients-chart" style="height: 250px;"></div>
            </div>
        </div>
    </div>
</div>
@stop
