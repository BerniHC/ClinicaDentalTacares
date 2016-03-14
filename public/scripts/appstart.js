var BASE_PATH = window.location.origin;

// Document Ready
jQuery(document).ready(function ($) {
    // Bootstrap
    $(".alert").alert();
    $(".inputmask").inputmask();
    $('.btn-loading').attr('data-loading-text', 'Cargando...');
    $(".btn-loading").click(function () {
        $(this).button("loading");
    });
    $("[data-role='popover']").popover({
        placement: "top",
        html: true
    });
    $("[data-role='tooltip'], [data-rol='tooltip-bottom']").tooltip({
        placement: "bottom"
    });
    $("[data-role='tooltip-top']").tooltip({
        placement: "top"
    });
    $("[data-role='tooltip-right']").tooltip({
        placement: "right"
    });
    $("[data-role='tooltip-left']").tooltip({
        placement: "left"
    });
    $('[data-role="colorpicker"]').colorpicker();
    setTimeout(function () {
        $(".page-alert").fadeOut();
    }, 3000);
    //Formstone
    $("[type=radio], [type=checkbox]:not(.toggle)").picker();
    $("[type=checkbox].toggle").picker({
        toggle: true
    });
    $("select:not(.optional)").selecter();
    $("select.optional").selecter({
        label: 'Seleccione...'
    });
    $(".scrollbar").scroller();
    // Prevent Default 
    $("a").click(function (e) {
        var attr = $(this).attr('href');
        if (attr == '#')
            e.preventDefault();
    });
    // Datatable
    $('.datatable tfoot th.search').each(function () {
        var title = $('.datatable thead th').eq($(this).index()).text();
        $(this).html('<input class="form-control" type="text" placeholder="' + title + '" />');
    });
    var table = $('.datatable').DataTable({
        language: {
            url: BASE_PATH + '/scripts/datatables-es.json'
        },
        columnDefs: [{
            orderable: false,
            searchable: false,
            targets: $(this).find('tr').length ? $(this).find('tr')[0].cells.length - 1 : -1
        }]
    });
    $('.datatable tfoot th').each(function (index) {
        var cell = $(this);
        cell.find('input').on('keyup change', function () {
            var idx = cell.parent('tr').children().index(cell);
            $(this).closest('.datatable').DataTable().column(idx).search(this.value).draw();
        });
    });

    // DateTime Picker
    $('[data-role="datepicker"]').datetimepicker({
        language: 'es-CR',
        pickTime: false,
        format: 'DD/MM/YYYY'
    });
    $('[data-role="timepicker"]').datetimepicker({
        language: 'es-CR',
        pickDate: false,
        format: 'hh:mm A'
    });
    // Scroll Link
    $('.scroll-link').click(function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        var position = $(target).offset();
        var distance = position.top;
        $('body,html').animate({ scrollTop: distance }, 500);
    });
    // Confirm Delete
    $('.confirm-action').click(function (e) {
        e.preventDefault();
        var msg = $(this).attr('data-message');
        if (msg === undefined)
            msg = "Realmente deseas continuar?";

        var link = $(this).attr('href');
        bootbox.setDefaults({
            title: "Confirmación",
            locale: "es"
        });
        bootbox.confirm(msg, function (result) {
            if (result == false || result === null) return;

            if (link !== undefined)
                window.location.href = link;
            else
                $(this).closest('form').submit();
        });
        $('.bootbox-confirm .modal-dialog').addClass('modal-sm');
    });
    // Check Calendar Availability
    $('#check-availability').click(function () {
        var schedule_id = $('[name="schedule_id"]').val();

        var start_date = $('[name="start_date"]').val();
        var start_time = $('[name="start_time"]').val();
        var end_date = $('[name="end_date"]').val();
        var end_time = $('[name="end_time"]').val();

        var now_datetime = moment();
        var start_datetime = moment(start_date + start_time, "DD/MM/YYYYhh:mm A").format("YYYYMMDDHHmm");
        var end_datetime;

        if (typeof end_date === "undefined" || typeof end_time === "undefined")
            end_datetime = moment(start_date + start_time, "DD/MM/YYYYhh:mm A").add('minutes', 30).format("YYYYMMDDHHmm");
        else
            end_datetime = moment(end_date + end_time, "DD/MM/YYYYhh:mm A").format("YYYYMMDDHHmm");

        var url = BASE_PATH + "/calendar/check/" + start_datetime + "/" + end_datetime + "/" + schedule_id;
        $.getJSON(url, function (data) {
            if (data.events > 0 || data.appointments > 0) {
                var msj = "La fecha y hora indicada coincide con: ";
                if (data.appointments > 0)
                    msj += data.appointments + " cita(s)";
                if (data.appointments > 0 && data.events > 0)
                    msj += " y ";
                if (data.events > 0)
                    msj += data.events + " evento(s)";
                msj += "<br/>Realmente desea continuar?"

                bootbox.dialog({
                    message: msj,
                    title: "Advertencia",
                    buttons: {
                        ok: {
                            label: "Continuar",
                            className: "btn-info",
                            callback: function () {
                                $("form").submit();
                            }
                        },
                        cancel: {
                            label: "Cancelar",
                            className: "btn-default"
                        }
                    }
                });
            }
            else {
                $("form").submit();
            }
        }).fail(function () {
            bootbox.alert({
                message: "Error de conexión. No se pudo verificar la disponibilidad.",
                title: "Error"
            });
        });
    });
    // Generate Random Password
    $('.random-pass').click(function () {
        var length = $(this).attr('data-length');
        var input = $(this).attr('data-input');

        var keylist = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        var pass = '';

        for (i = 0; i < length; i++)
            pass += keylist.charAt(Math.floor(Math.random() * keylist.length));

        $(input).val(pass).attr('type', 'text');
    });
});

// AllCheck
$(".all-check").click(function (e) {
    var check = $(this).attr("data-check");
    if ($(this).is(":checked")) {
        $("." + check + ":checkbox:not(:checked)").attr("checked", "checked");
    } else {
        $("." + check + ":checkbox:checked").removeAttr("checked");
    }
});

