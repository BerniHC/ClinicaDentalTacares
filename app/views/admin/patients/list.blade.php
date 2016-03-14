<?php
    $actives = $patients->filter(function($patient) {
        return !$patient->trashed();
    });
    
    $trashed = $patients->filter(function($patient) {
        return $patient->trashed();
    });
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-info" href="{{ URL::route('patient-add') }}">Agregar</a>
</div>
<br/><br/>
@include('layouts.alerts')
<!-- Nav Tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#actives" role="tab" data-toggle="tab">Activos ({{ $actives->count() }})</a></li>
    <li><a href="#trashed" role="tab" data-toggle="tab">Inactivos ({{ $trashed->count() }})</a></li>
</ul>
<!-- Tab Panes -->
<div class="tab-content">
    <!-- Tab Actives -->
    <div class="tab-pane fade in active" id="actives">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Pacientes Activos</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>
                        <th class="hidden-xs">Tipo</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($actives as $p)
                    <tr>
                        <td class="col-md">{{ $p->person->document_value }}</td>
                        <td class="col-md">{{ $p->person->firstname }}</td>
                        <td class="col-md">{{ $p->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $p->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $p->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $p->type->description }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('patient-view', array('id' => $p->id)) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('patient-edit', array('id' => $p->id)) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('patient-delete', array('id' => $p->id)) }}" title="Desactivar">
                                    <i class="fa fa-ban"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Identificación</th>
                        <th class="search">Nombre</th>
                        <th class="search">Apellidos</th>
                        <th class="search hidden-xs hidden-sm">Edad</th>
                        <th class="search visible-lg">Género</th>
                        <th class="search hidden-xs">Tipo</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Tab Trashed -->
    <div class="tab-pane fade" id="trashed">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Pacientes Inactivos</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>
                        <th class="hidden-xs">Tipo</th>
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($trashed as $p)
                    <tr>
                        <td class="col-md">{{ $p->person->document_value }}</td>
                        <td class="col-md">{{ $p->person->firstname }}</td>
                        <td class="col-md">{{ $p->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $p->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $p->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $p->type->description }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('patient-view', array('id' => $p->id)) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('patient-restore', array('id' => $p->id)) }}" title="Restaurar">
                                    <i class="fa fa-reply"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Identificación</th>
                        <th class="search">Nombre</th>
                        <th class="search">Apellidos</th>
                        <th class="hidden-xs hidden-sm search">Edad</th>
                        <th class="visible-lg search">Género</th>
                        <th class="hidden-xs search">Tipo</th>
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop