@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#generate').click(function () {
            var startdate = $('[name=startdate]').val();
            var enddate = $('[name=enddate]').val();

            startdate = moment(startdate, 'DD/MM/YYYY').format('YYYYMMDD');
            enddate = moment(enddate, 'DD/MM/YYYY').format('YYYYMMDD');
            
            window.location.href = '{{ URL::route("reports") }}/' + startdate + '/' + enddate;
        });
    });
</script>
@stop
@section('content')
<form class="form-inline">
    <div class="form-group">
        <label class="control-label" for="startdate">Fecha Inicio</label>
        <div class='input-group date' data-role="datepicker">
            {{ Form::text('startdate', $startdate, array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="enddate">Fecha Final</label>
        <div class='input-group date' data-role="datepicker">
            {{ Form::text('enddate', $enddate, array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="form-group" style="padding-top: 20px">
        <button type="button" id="generate" class="btn btn-info" >Generar</button>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Exportar <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ URL::route('reports-download', array('annual_report.html')) }}">Formato HTML</a></li>
                <li><a href="{{ URL::route('reports-download', array('annual_report.ods')) }}">Formato ODS</a></li>
                <li><a href="{{ URL::route('reports-download', array('annual_report.pdf')) }}">Formato PDF</a></li>
            </ul>
        </div>
    </div>
</form>
<hr/>
<div class="row">
    <div class="col-md-12">
        {{ include public_path() . '/jasper/annual_report.html' }}
    </div>
</div>
@stop