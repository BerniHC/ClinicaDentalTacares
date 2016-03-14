@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('patient_type') ? 'has-error' : '' }}">
            <label for="pacient_type" class="control-label">Tipo de Paciente *</label>
            {{ Form::select('patient_type', $patient_types, '', array('class' => 'form-control')) }}
            @if( $errors->has('patient_type') )
            <span class="help-block">{{ $errors->get('patient_type')[0] }}</span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('document_type') ? 'has-error' : '' }}">
            <label for="document_type" class="control-label">Tipo de Documento *</label>
            {{ Form::select('document_type', $document_types, '', array('class' => 'form-control')) }}
            @if( $errors->has('document_type') )
            <span class="help-block">{{ $errors->get('document_type')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('document_value') ? 'has-error' : '' }}">
            <label for="document_value" class="control-label">Número de Documento *</label>
            {{ Form::text('document_value', '', array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('document_value') )
            <span class="help-block">{{ $errors->get('document_value')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Nombre *</label>
            {{ Form::text('firstname', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('firstname') )
            <span class="help-block">{{ $errors->get('firstname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('middlename') ? 'has-error' : '' }}">
            <label for="middlename" class="control-label">Primer Apellido</label>
            {{ Form::text('middlename', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('middlename') )
            <span class="help-block">{{ $errors->get('middlename')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
            <label for="lastname" class="control-label">Segundo Apellido</label>
            {{ Form::text('lastname', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('lastname') )
            <span class="help-block">{{ $errors->get('lastname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="gender" class="control-label">Género *</label>
            @foreach($genders as $index=>$gender)
            <label class="radio-inline">
                {{ Form::radio('gender', $gender->id, $index == 0) }} {{ $gender->description }}
            </label>
            @endforeach
            @if( $errors->has('gender') )
            <span class="help-block">{{ $errors->get('gender')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
            <label for="birthdate" class="control-label">Fecha de Nacimiento *</label>
            <div class='input-group date' data-role="datepicker">
                {{ Form::text('birthdate', '', array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
            @if( $errors->has('birthdate') )
            <span class="help-block">{{ $errors->get('birthdate')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Correo Electrónico</label>
            {{ Form::email('email', '', array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('email') )
            <span class="help-block">{{ $errors->get('email')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('telephone') ? 'has-error' : '' }}">
            <label for="telephone" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon">+506</span>
                {{ Form::text('telephone', '', array('class' => 'form-control', 'maxlength' => '15')) }}
            </div>
            @if( $errors->has('telephone') )
            <span class="help-block">{{ $errors->get('telephone')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('observations') ? 'has-error' : '' }}">
            <label for="observations" class="control-label">Observaciones</label>
            {{ Form::textarea('observations', '', array('class' => 'form-control', 'rows' => 3, 'maxlength' => '1000')) }}
            @if( $errors->has('observations') )
            <span class="help-block">{{ $errors->get('observations')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
    </div>
</form>
@stop