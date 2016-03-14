@section('content')
@include('layouts.alerts')
<div class="row">
    <!-- Personal Data -->
    <div class="col-md-6">
        <h4>Datos Personales</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>{{ $user->person->document->description }}</strong></td>
                    <td>{{ $user->person->document_value }}</td>
                </tr>
                <tr>
                    <td><strong>Nombre</strong></td>
                    <td>{{ $user->person->firstname }}</td>
                </tr>
                <tr>
                    <td><strong>Primer Apellido</strong></td>
                    <td>{{ $user->person->middlename }}</td>
                </tr>
                <tr>
                    <td><strong>Segundo Apellido</strong></td>
                    <td>{{ $user->person->lastname }}</td>
                </tr>
                <tr>
                    <td><strong>Género</strong></td>
                    <td>{{ $user->person->gender->description }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Nacimiento</strong></td>
                    <td>{{ date('d F, Y', strtotime($user->person->birthdate)) }}</td>
                </tr>
                <tr>
                    <td><strong>Edad</strong></td>
                    <td>{{ $user->person->age() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Account -->
    <div class="col-md-6">
        <h4>Cuenta</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>Correo Electrónico</strong></td>
                    <td><a href="mailto:{{ $user->person->user->email }}">{{ $user->person->user->email }}</a></td>
                </tr>
                <tr>
                    <td><strong>Contraseña</strong></td>
                    <td><a href="{{ URL::route('change-password') }}">Cambiar contraseña</a></td>
                </tr>
                <tr>
                    <td><strong>Rol</strong></td>
                    <td>{{ $user->roles()->first()->name }}</td>
                </tr>
                <tr>
                    <td><strong>Estado</strong></td>
                    <td>
                        <span class="label {{ !$user->person->trashed() ? 'label-success' : 'label-danger' }}" >
                            {{ !$user->person->trashed() ? 'Activo' : 'Bloqueado' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Confirmación</strong></td>
                    <td>{{ $user->is_confirmed ? 'Completado' : 'Pendiente' }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Creación</strong></td>
                    <td>{{ date('d/m/Y h:i:s a', strtotime($user->created_at)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr/>
<div class="row">
    <!-- Addresses -->
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Direcciones</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Provincia</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    @if($user->person->addresses->count() == 0)
                    <tr>
                        <td class="text-center" colspan="4">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($user->person->addresses as $a)
                    <tr>
                        <td>{{ $a->city->name }}</td>
                        <td>{{ $a->estate->name }}</td>
                        <td>
                            <button class="btn btn-link btn-xs" type="button" data-toggle="popover" data-content="{{ $a->address }}">
                            {{ substr($a->address, 0, 30) }}
                            </button>
                        </td>
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
                <h3 class="panel-title">Teléfonos</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Número Teléfonico</th>
                    </tr>
                </thead>
                <tbody>
                    @if($user->person->telephones->count() == 0)
                    <tr>
                        <td class="text-center" colspan="2">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($user->person->telephones as $t)
                    <tr>
                        <td>{{ '+506' . $t->number }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop