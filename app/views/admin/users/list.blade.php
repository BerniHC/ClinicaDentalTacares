<?php
    $actives = $users->filter(function($user) {
        return !$user->trashed();
    });
    
    $trashed = $users->filter(function($user) {
        return $user->trashed();
    });
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-info" href="{{ URL::route('user-add') }}">Agregar</a>
</div>
<br/><br/>
@include('layouts.alerts')
<!-- Nav Tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#actives" role="tab" data-toggle="tab">Activos ({{ $actives->count() }})</a></li>
    <li><a href="#trashed" role="tab" data-toggle="tab">Bloqueados ({{ $trashed->count() }})</a></li>
</ul>
<!-- Tab Tanes -->
<div class="tab-content">
    <!-- Tab Actives -->
    <div class="tab-pane fade in active" id="actives">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Usuarios Activos</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>
                        <th class="hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($actives as $u)
                    <tr>
                        <td class="col-md">{{ $u->person->document_value }}</td>
                        <td class="col-md">{{ $u->person->firstname }}</td>
                        <td class="col-md">{{ $u->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $u->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $u->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $u->roles()->first()->name }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('user-view', array('id' => $u->id)) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('user-edit', array('id' => $u->id)) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('user-delete', array('id' => $u->id)) }}" title="Bloquear">
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
                        <th class="search hidden-xs">Rol</th>
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
                <h3 class="panel-title">Usuarios Bloqueados</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>
                        <th class="hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($trashed as $u)
                    <tr>
                        <td class="col-md">{{ $u->person->document_value }}</td>
                        <td class="col-md">{{ $u->person->firstname }}</td>
                        <td class="col-md">{{ $u->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $u->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $u->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $u->roles()->first()->name }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('user-view', array('id' => $u->id)) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('user-restore', array('id' => $u->id)) }}" title="Restaurar">
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
                        <th class="search hidden-xs hidden-sm">Edad</th>
                        <th class="search visible-lg">Género</th>
                        <th class="search hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop
