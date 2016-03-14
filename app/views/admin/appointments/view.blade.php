<?php
    $year = date('Y', strtotime($appointment->schedule->start_datetime));
    $month = date('m', strtotime($appointment->schedule->start_datetime));
    $day = date('d', strtotime($appointment->schedule->start_datetime));
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-info" href="{{ URL::route('appointment-edit', array($appointment->id)) }}">Editar</a>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Estado <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            @foreach($status as $s)
            <li><a href="{{ URL::route('appointment-status', array($appointment->id, $s->id)) }}">{{ $s->description }}</a></li>
            @endforeach
        </ul>
    </div>
    <a class="btn btn-default confirm-action" href="{{ URL::route('appointment-delete', array($appointment->id)) }}">Eliminar</a>
</div>
<a class="btn btn-default" href="{{ URL::route('calendar', array($year, $month, $day)) }}">Calendario</a>
<br/><br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-md-6">
        <h4>Datos de la Cita</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th style="width: 170px">Doctor</th>
                    <td>
                        @if($appointment->doctor)
                        <a href="{{ Url::action('user-view', array('id' => $appointment->doctor_id )) }}">
                            {{ $appointment->doctor->person->fullname() }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width: 170px">Categoría</th>
                    <td>
                        <span class="label label-default" style="background: {{ $appointment->category->color }}">
                            {{ $appointment->category->description }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ date('d F, Y', strtotime($appointment->schedule->start_datetime)) }}</td>
                </tr>
                <tr>
                    <th>Hora</th>
                    <td>{{ date('h:i a', strtotime($appointment->schedule->start_datetime)) }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ $appointment->status->description }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{{ $appointment->observation }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h4>Datos del Paciente</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>{{ $appointment->patient->person->document->description }}</th>
                    <td>{{ $appointment->patient->person->document_value }}</td>
                </tr>
                <tr>
                    <th style="width: 170px">Nombre</th>
                    <td>
                        <a href="{{ Url::action('patient-view', array('id' => $appointment->patient->id )) }}">
                            {{ $appointment->patient->person->fullname() }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Tipo de Paciente</th>
                    <td>{{ $appointment->patient->type->description }}</td>
                </tr>
                <tr>
                    <th>Género</th>
                    <td>{{ $appointment->patient->person->gender->description }}</td>
                </tr>
                <tr>
                    <th>Edad</th>
                    <td>{{ $appointment->patient->person->age() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('appointment-treatment-add', $appointment->id) }}">Agregar</a>
                <h3 class="panel-title">Tratamientos aplicados</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th class="hidden-xs">Observación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($appointment->treatments))
                    <tr>
                        <td class="text-center" colspan="4">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($appointment->treatments as $t)
                    <tr>
                        <td class="col-md">{{ $t->description }}</td>
                        <td class="col-xs">{{ $t->pivot->amount }}</td>
                        <td class="col-lg hidden-xs">{{ $t->pivot->observation }}</td>
                        <td class="actions">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('appointment-treatment-edit', array($appointment->id, $t->id)) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="{{ URL::route('appointment-treatment-delete', array($appointment->id, $t->id)) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop