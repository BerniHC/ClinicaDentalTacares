@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Patients
            var patients = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '{{ URL::route("appointment-patients") }}'
            });

            patients.initialize();
            $('[name="patient"]').typeahead(null, {
                name: 'patients',
                displayKey: 'name',
                source: patients.ttAdapter()
            }).bind('typeahead:selected', function (obj, datum, name) {
                $('[name="patient_id"]').val(datum.id);
            });
            
            $('[name="patient"]').keyup(function () {
                $('[name="patient_id"]').val("");
            });

            // Doctors
            var doctors = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '{{ URL::route("appointment-doctors") }}'
            });

            doctors.initialize();
            $('[name="doctor"]').typeahead(null, {
                name: 'doctors',
                displayKey: 'name',
                source: doctors.ttAdapter()
            }).bind('typeahead:selected', function (obj, datum, name) {
                $('[name="doctor_id"]').val(datum.id);
            });

            $('[name="doctor"]').keyup(function () {
                $('[name="doctor_id"]').val("");
            });
        });
    </script>
@stop
@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        {{ Form::hidden('schedule_id', 0) }}
        <div class="form-group {{ $errors->has('patient_id') ? 'has-error' : '' }}">
            <label for="patient" class="control-label">Paciente *</label>
            {{ Form::text('patient', '', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')) }}
            {{ Form::hidden('patient_id', '') }}
            @if( $errors->has('patient_id') )
            <span class="help-block">{{ $errors->get('patient_id')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('doctor_id') ? 'has-error' : '' }}">
            <label for="doctor_id" class="control-label">Doctor</label>
            {{ Form::text('doctor', '', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')) }}
            {{ Form::hidden('doctor_id', '') }}
            @if( $errors->has('doctor_id') )
            <span class="help-block">{{ $errors->get('doctor_id')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
            <label for="category" class="control-label">Categoría *</label>
            {{ Form::select('category', $categories, '', array('class' => 'form-control')) }}
            @if( $errors->has('category') )
            <span class="help-block">{{ $errors->get('category')[0] }}</span>
            @endif
        </div>
        <div class="row">
           <div class='col-md-6'>
                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                    <label for="start_date" class="control-label">Fecha *</label>
                    <div class='input-group date' data-role="datepicker">
                        {{ Form::text('start_date', date('d/m/Y', $startDate), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    @if( $errors->has('start_date') )
                    <span class="help-block">{{ $errors->get('start_date')[0] }}</span>
                    @endif
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label for="start_time" class="control-label">Hora *</label>
                    <div class='input-group date' data-role="timepicker">
                        {{ Form::text('start_time', date('h:i A', $startDate), array('class' => 'form-control', 'data-mask' => '99:99 aa', 'placeholder' => '12:59 AM')) }}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    @if( $errors->has('start_time') )
                    <span class="help-block">{{ $errors->get('start_time')[0] }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label for="observation" class="control-label">Observaciones</label>
            {{ Form::textarea('observation', '', array('class' => 'form-control', 'rows' => 3, 'maxlength' => '1000')) }}
            @if( $errors->has('observation') )
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
        <button id="check-availability" class="btn btn-success" type="button">Agregar</button>
    </div>
</form>
@stop