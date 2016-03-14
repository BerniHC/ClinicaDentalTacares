@section('content')
<ul class="nav nav-tabs" role="tablist">
    <li><a href="{{ URL::route('config-website') }}" role="tab">Sitio Web</a></li>
    <li><a href="{{ URL::route('config-agenda') }}" role="tab">Agenda</a></li>
    <li><a href="{{ URL::route('role-list') }}" role="tab">Roles</a></li>
    <li class="hidden-xs"><a href="{{ URL::route('metatype-list') }}" role="tab">Metatipos</a></li>
    <li class="hidden-xs active"><a href="{{ URL::route('treatment-list') }}" role="tab">Tratamientos</a></li>
</ul>
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('treatment-add') }}">Agregar</a>
                <h3 class="panel-title">Tratamientos</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($treatments))
                    <tr>
                        <td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($treatments as $t)
                    <tr>
                        <td>{{ $t->description }}</td>
                        <td>{{ $t->category->description }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('treatment-edit', $t->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('treatment-delete', $t->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- end panel -->
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('category-add') }}">Agregar</a>
                <h3 class="panel-title">Categorías</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Color</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($categories))
                    <tr>
                        <td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($categories as $c)
                    <tr>
                        <td>{{ $c->description }}</td>
                        <td>
                            <span class="label label-default" style="background: {{ $c->color }}">
                                {{ $c->color }}
                            </span>
                        </td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('category-edit', $c->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('category-delete', $c->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- end panel -->
    </div>
</div>
@stop