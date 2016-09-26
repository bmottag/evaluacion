function cambiarFormato(date) {
    var fecha = date.split("/");
    var fechaDate = new Date(fecha[2], fecha[1] - 1, fecha[0], 17);
    return fechaDate;
}

$(function () {
    $('#fechaPermiso, #fecha_ini, #fecha_fin').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: 'now'
    });
})

function copiar_valor(hora, minutos, completo)
{
    var hora = document.getElementById(hora);
    var minutos = document.getElementById(minutos);
    var pegar = document.getElementById(completo);
    pegar.value = hora.value + ':' + minutos.value;
}





/**
 * Validar formulario solicitud de permiso
 */
function enviarSolicitud() {
    var form = document.getElementById('frmPermisos');
    var x = form.tipoPermiso.value;
    var ok = 1;
    document.getElementById('alertTipo').style.display = "none";
    document.getElementById('alertFecha').style.display = "none";
    document.getElementById('alertFechaMenor').style.display = "none";
    document.getElementById('alertFechaMenor2').style.display = "none";



    document.getElementById('alertInicio').style.display = "none";
    document.getElementById('alertFinal').style.display = "none";
    document.getElementById('alertFirst').style.display = "none";
    document.getElementById('alertSecond').style.display = "none";

    document.getElementById('alertMotivo').style.display = "none";
    document.getElementById('alertOtro').style.display = "none";
    document.getElementById('alertDocs').style.display = "none";
    document.getElementById('alertEstudio').style.display = "none";
    document.getElementById('alertJefe').style.display = "none";
    document.getElementById('alertDirector').style.display = "none";
    document.getElementById('bloqueAlerta').style.display = "none";

    if (x == "")
    {
        document.getElementById('alertTipo').style.display = "block";
        ok = 0;
    }
    if (x == 1 && form.fechaPermiso.value == "") {
        document.getElementById('alertFecha').style.display = "block";
        ok = 0;
    }

    var today = new Date();
    var fechaPermiso = cambiarFormato(form.fechaPermiso.value);
    var fecha_ini = cambiarFormato(form.fecha_ini.value);
    var fecha_fin = cambiarFormato(form.fecha_fin.value);


    if (x == 1 && form.fechaPermiso.value != "" && today > fechaPermiso) {
        document.getElementById('alertFechaMenor').style.display = "block";
        ok = 0;
    }

    if (x == 1 && form.hora_ini.value == "") {
        document.getElementById('alertInicio').style.display = "block";
        ok = 0;
    }
    if (x == 1 && form.hora_fin.value == "") {
        document.getElementById('alertFinal').style.display = "block";
        ok = 0;
    }

    if (x == 2 && form.fecha_ini.value == "") {
        document.getElementById('alertFirst').style.display = "block";
        ok = 0;
    }




    if ((x == 2 || x == 3 || x == 4) && form.fecha_ini.value != "" && fecha_ini < today) {
        document.getElementById('alertFechaMenor').style.display = "block";
        ok = 0;
    }

    if ((x == 3 || x == 4) && (form.fecha_ini.value == "" || form.fecha_fin.value == "")) {
        document.getElementById('alertSecond').style.display = "block";
        ok = 0;
    }


    if ((x == 3 || x == 4) && (form.fecha_ini.value != "" && form.fecha_fin.value != "") && fecha_fin <= fecha_ini) {
        document.getElementById('alertFechaMenor2').style.display = "block";
        ok = 0;
    }

    //validaciones motivo del permiso
    if (form.motivo.value == "") {
        document.getElementById('alertMotivo').style.display = "block";
        ok = 0;
    }
    if (form.motivo.value >= 1 && form.motivo.value <= 3 && form.idsubmotivo.value == "") {
        document.getElementById('alertMotivo').style.display = "block";
        ok = 0;
    }
    if (form.motivo.value == 7 && form.otro.value == "") {
        document.getElementById('alertOtro').style.display = "block";
        ok = 0;
    }

    if (form.motivo.value == 5 && (form.archivo1.value == "" || form.archivo2.value == "")) {
        document.getElementById('alertDocs').style.display = "block";
        ok = 0;
    }

    if (form.motivo.value == 5 && form.tiempoCompensar.value == "") {
        document.getElementById('alertEstudio').style.display = "block";
        ok = 0;
    }
    if (form.jefe.value == "") {
        document.getElementById('alertJefe').style.display = "block";
        ok = 0;
    }
    if (form.director.value == "" && x == 4) {
        document.getElementById('alertDirector').style.display = "block";
        ok = 0;
    }
    if (ok == 1) {
        form.submit();
    } else {
        document.getElementById('bloqueAlerta').style.display = "block";
    }
}
//Validar segun el tipo de permiso
function validarTipo() {
    var form = document.getElementById('frmPermisos');
    document.getElementById('dias').style.display = "none";
    document.getElementById('dias_final').style.display = "none";
    document.getElementById('fraccion').style.display = "none";
    document.getElementById('certUni').style.display = "none";
    document.getElementById('labelSubmotivo').style.display = "none";
    document.getElementById('labelOtro').style.display = "none";
    form.fechaPermiso.value = '';
    form.hora_ini.value = '';
    form.hora_fin.value = '';
    form.fecha_ini.value = '';
    form.fecha_fin.value = '';
    form.motivo.value = '';
    form.director.value = '';
    form.director.disabled = true;
    form.motivo.disabled = false;
    form.tiempoCompensar.value = '';
    form.archivo1.value = '';
    form.archivo2.value = '';
    form.fechaPermiso.disabled = true;
    form.hora_ini.disabled = true;
    form.hora_fin.disabled = true;
    form.fecha_ini.disabled = true
    form.fecha_fin.disabled = true;
    form.otro.value = '';
    form.otro.disabled = true;

    if (form.tipoPermiso.value == 1)
    {
        document.getElementById('fraccion').style.display = "block";
        form.fechaPermiso.disabled = false;
        form.hora_ini.disabled = false;
        form.hora_fin.disabled = false;
    }
    /*1 dia*/
    if (form.tipoPermiso.value == 2)
    {
        document.getElementById('dias').style.display = "block";
        form.fecha_ini.disabled = false
    }
    /*2 0 3 dias*/
    if (form.tipoPermiso.value == 3 || form.tipoPermiso.value == 4)
    {
        document.getElementById('dias').style.display = "block";
        document.getElementById('dias_final').style.display = "block";
        form.fecha_ini.disabled = false
        form.fecha_fin.disabled = false;
    }
    /*3 dias*/
    if (form.tipoPermiso.value == 4)
    {
        form.director.disabled = false;
    }
    /*Estudio o docencia*/
    if (form.tipoPermiso.value == 5)
    {
        form.motivo.disabled = true;
        form.motivo.value = 5;
        document.getElementById('certUni').style.display = "block";
        form.archivo1.disabled = false;
        form.archivo2.disabled = false;
        form.tiempoCompensar.disabled = false;
        form.idsubmotivo.value = "";
        document.getElementById('labelSubmotivo').style.display = "none";
    }
}