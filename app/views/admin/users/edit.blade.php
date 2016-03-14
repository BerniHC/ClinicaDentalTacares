@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('document_type') ? 'has-error' : '' }}">
            <label for="document_type" class="control-label">Tipo de Documento *</label>
            {{ Form::select('document_type', $document_types, $user->person->document_type_id, array('class' => 'form-control')) }}
            @if( $errors->has('document_type') )
            <span class="help-block">{{ $errors->get('document_type')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('document_value') ? 'has-error' : '' }}">
            <label for="document_value" class="control-label">Número de Documento *</label>
            {{ Form::text('document_value', $user->person->document_value, array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('document_value') )
            <span class="help-block">{{ $errors->get('document_value')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Nombre *</label>
            {{ Form::text('firstname', $user->person->firstname, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('firstname') )
            <span class="help-block">{{ $errors->get('firstname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('middlename') ? 'has-error' : '' }}">
            <label for="middlename" class="control-label">Primer Apellido</label>
            {{ Form::text('middlename', $user->person->middlename, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('middlename') )
            <span class="help-block">{{ $errors->get('middlename')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
            <label for="lastname" class="control-label">Segundo Apellido</label>
            {{ Form::text('lastname', $user->person->lastname, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('lastname') )
            <span class="help-block">{{ $errors->get('lastname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="gender" class="control-label">Género *</label>
            @foreach($genders as $index=>$gender)
            <label class="radio-inline">
                {{ Form::radio('gender', $gender->id, $gender->id == $user->person->gender_id) }} {{ $gender->description }}
            </label>
            @endforeach
            @if( $errors->has('gender') )
            <span class="help-block">{{ $errors->get('gender')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
            <label for="birthdate" class="control-label">Fecha de Nacimiento *</label>
            <div class='input-group date' data-role="datepicker">
                {{ Form::text('birthdate', date('d/m/Y', strtotime($user->person->birthdate)), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
            @if( $errors->has('birthdate') )
            <span class="help-block">{{ $errors->get('birthdate')[0] }}</span>
            @endif
        </div>
        @if(Auth::user()->id != $user->id)
        <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
            <label for="role" class="control-label">Rol de Usuario *</label>
            {{ Form::select('role[]', $roles, $user->roles()->first()->id, array('class' => 'form-control')) }}
            @if( $errors->has('role') )
            <span class="help-block">{{ $errors->get('role')[0] }}</span>
            @endif
        </div>
        @endif
        <button class="btn btn-success btn-loading" type="submit">Guardar</button>
    </div>
</form>
@stop