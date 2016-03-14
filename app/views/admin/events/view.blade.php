<?php
    $year = date('Y', strtotime($event->schedule->start_datetime));
    $month = date('m', strtotime($event->schedule->start_datetime));
    $day = date('d', strtotime($event->schedule->start_datetime));
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-info" href="{{ URL::route('event-edit', array($event->id)) }}">Editar</a>
    <a class="btn btn-default confirm-action" href="{{ URL::route('event-delete', array($event->id)) }}">Eliminar</a>
</div>
<a class="btn btn-default" href="{{ URL::route('calendar', array($year, $month, $day)) }}">Ver en el calendario</a>
<br/><br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-md-6">
        <h4>Datos del Evento</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>Asunto</strong></td>
                    <td>{{ $event->subject }}</td>
                </tr>
                <tr>
                    <td><strong>Descripción</strong></td>
                    <td>{{ $event->description }}</td>
                </tr>
                <tr>
                    <td><strong>Prioridad</strong></td>
                    <td>{{ $event->priority->description }}</td>
                </tr>
                @if($event->schedule->start_datetime == $event->schedule->end_datetime)
                <tr>
                    <td><strong>Fecha</strong></td>
                    <td>{{ date('d F, Y', strtotime($event->schedule->start_datetime)) }}</td>
                </tr>
                @else
                <tr>
                    <td><strong>Fecha Inicio</strong></td>
                    <td>{{ date('d F, Y. h:i a', strtotime($event->schedule->start_datetime)) }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha Fin</strong></td>
                    <td>{{ date('d F, Y. h:i a', strtotime($event->schedule->end_datetime)) }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Duración</strong></td>
                    <td>{{ $event->schedule->duration() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop