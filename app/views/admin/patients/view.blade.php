@section('content')
@if(!$patient->trashed())
<div class="btn-group">
    <a class="btn btn-info" href="{{ URL::route('patient-edit', array('id' => $patient->id)) }}">Editar</a>
    <a class="btn btn-default confirm-action" href="{{ URL::route('patient-delete', array('id' => $patient->id)) }}">Desactivar</a>
</div>
@else
<div class="btn-group">
    <a class="btn btn-default confirm-action" href="{{ URL::route('patient-restore', array('id' => $patient->id)) }}">Restaurar</a>
</div>
@endif
<br/><br/>
@include('layouts.alerts')
<div class="row">
    <!-- Personal Data -->
    <div class="col-md-6">
        <h4>Datos Personales</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>{{ $patient->person->document->description }}</strong></td>
                    <td>{{ $patient->person->document_value }}</td>
                </tr>
                <tr>
                    <td><strong>Nombre</strong></td>
                    <td>{{ $patient->person->firstname }}</td>
                </tr>
                <tr>
                    <td><strong>Primer Apellido</strong></td>
                    <td>{{ $patient->person->middlename }}</td>
                </tr>
                <tr>
                    <td><strong>Segundo Apellido</strong></td>
                    <td>{{ $patient->person->lastname }}</td>
                </tr>
                <tr>
                    <td><strong>Género</strong></td>
                    <td>{{ $patient->person->gender->description }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Nacimiento</strong></td>
                    <td>{{ date('d F, Y', strtotime($patient->person->birthdate)) }}</td>
                </tr>
                <tr>
                    <td><strong>Edad</strong></td>
                    <td>{{ $patient->person->age() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Account -->
    <div class="col-md-6">
        <h4>Datos del Paciente</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>Correo Electrónico</strong></td>
                    <td><a href="mailto:{{ $patient->email }}">{{ $patient->email }}</a></td>
                </tr>
                <tr>
                    <td><strong>Tipo de Paciente</strong></td>
                    <td>{{ $patient->type->description }}</td>
                </tr>
                <tr>
                    <td><strong>Estado</strong></td>
                    <td>
                        <span class="label {{ !$patient->trashed() ? 'label-success' : 'label-danger' }}">
                            {{ !$patient->trashed() ? 'Activo' : 'Eliminado' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Fecha de Creación</strong></td>
                    <td>{{ $patient->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Observacion</strong></td>
                    <td class="text-justify">{{ $patient->observation }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div><!-- End Row -->
<hr/>
<div class="row">
    <!-- Addresses -->
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                @if(!$patient->trashed())
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('address-add', $patient->person_id) }}">Agregar</a>
                @endif
                <h3 class="panel-title">Direcciones</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Provincia</th>
                        <th class="hidden-xs">Dirección</th>
                        @if(!$patient->trashed())
                        <th class="actions hidden-xs">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(!count($patient->person->addresses))
                    <tr>
                        <td class="text-center" colspan="100">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($patient->person->addresses as $a)
                    <tr>
                        <td>{{ $a->city->name }}</td>
                        <td>{{ $a->estate->name }}</td>
                        <td class="hidden-xs">
                            <button class="btn btn-link btn-xs" type="button" data-role="popover" data-content="{{ $a->address }}">
                            {{ substr($a->address, 0, 30) }}
                            </button>
                        </td>
                        @if(!$patient->trashed())
                        <td class="actions hidden-xs">
                            <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('address-delete', $a->id) }}" title="Eliminar">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Telephones -->
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                @if(!$patient->trashed())
                <a class="btn btn-xs btn-info pull-right" href="{{ URL::route('telephone-add', $patient->person_id) }}">Agregar </a>
                @endif
                <h3 class="panel-title">Teléfonos</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Número Teléfonico</th>
                        @if(!$patient->trashed())
                        <th class="actions">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(!count($patient->person->telephones))
                    <tr>
                        <td class="text-center" colspan="100">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($patient->person->telephones as $t)
                    <tr>
                        <td>{{ '+506' . $t->number }}</td>
                        @if(!$patient->trashed())
                        <td class="actions">
                            <a class="btn btn-success btn-xs visible-xs" href="tel:{{ '+506' . $t->number }}" title="Llamar">
                                <i class="fa fa-phone"></i>
                            </a>
                            <a class="btn btn-default btn-xs hidden-xs confirm-action" href="{{ URL::route('telephone-delete', $t->id) }}" title="Eliminar">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- End Row -->
@stop