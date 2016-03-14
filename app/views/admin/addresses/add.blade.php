@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Places
            $("[data-place]").change(function () {
                var target = $(this).attr('data-place');
                var place = $(this).val();
                var cbx = $(target);

                $.get(BASE_PATH + "/addresses/cities", { place: place }, function (data) {
                    cbx.empty();
                    $.each(data, function (index, element) {
                        var status = place == element.id ? "selected" : "";
                        cbx.append("<option value='" + element.id + "' " + status + ">" + element.name + "</option>");
                        cbx.selecter("update");
                    });
                });
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
        <div class="form-group {{ $errors->has('estate') ? 'has-error' : '' }}">
            <label for="estate" class="control-label">Provincia *</label>
            {{ Form::select('estate', $estates, '', array('class' => 'form-control optional', 'max-lenght' => '50', 'data-place' => '[name="city"]')) }}
            @if( $errors->has('estate') )
            <span class="help-block">{{ $errors->get('estate')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
            <label for="city" class="control-label">Ciudad *</label>
            {{ Form::select('city', [], '', array('class' => 'form-control optional', 'max-lenght' => '50')) }}
            @if( $errors->has('city') )
            <span class="help-block">{{ $errors->get('city')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            <label for="address" class="control-label">Dirección</label>
            {{ Form::textarea('address', '', array('class' => 'form-control', 'max-lenght' => '100', 'rows' => '2')) }}
            @if( $errors->has('address') )
            <span class="help-block">{{ $errors->get('address')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-success btn-loading" type="submit">Agregar</button>
    </div>
</form>
@stop
