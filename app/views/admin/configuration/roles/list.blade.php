@section('content')
<ul class="nav nav-tabs" role="tablist">
    <li><a href="{{ URL::route('config-website') }}" role="tab">Sitio Web</a></li>
    <li><a href="{{ URL::route('config-agenda') }}" role="tab">Agenda</a></li>
    <li class="active"><a href="{{ URL::route('role-list') }}" role="tab">Roles</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('metatype-list') }}" role="tab">Metatipos</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('treatment-list') }}" role="tab">Tratamientos</a></li>
</ul>
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('role-add') }}">Agregar</a>
                <h3 class="panel-title">Roles</h3>
            </div>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuarios</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $r)
                    <tr>
                        <td>{{ $r->name }}</td>
                        <td class="col-xs">{{ $r->users->count() }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('role-edit', array($r->id)) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('role-delete', array($r->id)) }}" title="Eliminar">
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