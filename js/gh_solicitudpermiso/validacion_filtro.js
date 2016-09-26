$(function () {
    var datescierre = $('#fecha_ini, #fecha_fin').datepicker({
        defaultDate: '+1d',
        changeMonth: true,
        dateFormat: 'dd/mm/yy',
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var option = this.id == 'fecha_ini' ? 'minDate' : 'maxDate',
                    instance = $(this).data('datepicker');
            date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            datescierre.not(this).datepicker('option', option, date);
        }
    });
})
/**
 * Validar formulario solicitud de permiso
 */
function enviarSolicitud() {
    var form = document.getElementById('frmFiltro');
    var ok = 1;
    if (form.fecha_ini.value == "" || form.fecha_fin.value == "") {
        bootbox.alert('Las fechas son obligatorias.');
        ok = 0;
    }

    if (ok == 1) {
        form.submit();
    }
}