$(document).ready(function () {
    //Configuracion de JQGrid
    $.jgrid.defaults.width = 1150;
    $.jgrid.defaults.styleUI = 'Bootstrap';
    $.jgrid.defaults.responsive = true;

    $('#nombre').bloquearNumeros().maxlength(50).convertirMayuscula();
    $('#apellido').bloquearNumeros().maxlength(50).convertirMayuscula();
    $('#txtDocu').bloquearTexto().maxlength(11);
    /*$('#txtEmail').blur(function(){
     if( /^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,3}$/.test($(this).val())) {
     return true;
     } else {
     $(this).val('');
     }
     });*/
    
    $('#cmbDespacho').change(function () {
        $('#cmbDespacho option:selected').each(function () {
            var despacho = $('#cmbDespacho').val();
            if (despacho > 0 || despacho != '-') {
                $.ajax ({
                    cache: false,
                    contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                    data: {'identificador': despacho},
                    dataType: 'html',
                    type: 'POST',
                    url: base_url + 'gh_directorio/listaDesplegable',
                    success: function (data) {
                        $('#dependencia').html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                        location.reload();
                    }
                });
            } else {
                var data = '<option value="-">Seleccione</option>';
                $('#dependencia').html(data);
            }
        });
    });
    
    $('#dependencia').change(function () {
        var despacho = $('#cmbDespacho').val();
        var dependencia = $('#dependencia').val();
        if(despacho == dependencia) {
            $('#grupo').html('<option value="">Seleccione...</option>');
        } else {
            $('#dependencia option:selected').each(function () {
                var dependencia = $('#dependencia').val();
                if (dependencia > 0 || dependencia != '-') {
                    $.ajax({
                        cache: false,
                        contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                        data: {'identificador': dependencia},
                        dataType: 'html',
                        type: 'POST',
                        url: base_url + 'gh_directorio/listaGrupo',
                        success: function (data) {
                            $('#grupo').html(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                            location.reload();
                        }
                    });
                } else {
                    var data = '<option value="-">Seleccione</option>';
                    $('#grupo').html(data);
                }
            });
        }
    });
    
    $('#txtNombres').autocomplete({
        minLength: 2,
        source: base_url + 'gh_directorio/get_autocomplete'
    });
    $('#txtApellidos').autocomplete({
        minLength: 2,
        source: base_url + 'gh_directorio/get_autoApellido'
    });
    
    
    
    /**
     * Muestra el resultado de la cedula digitada
     * @author alrodriguezm
     * @since  2015-07-09
     */
    $('#txtCedula').bloquearTexto().maxlength(11);
    
    $('#txtCedula').blur(function () {
        var cedula = $('#txtCedula').val();
        var regreso = $('#regreso').val();
        //alert ('aqui'+regreso);
        if (cedula != '0' && cedula.length > 0) {
            $.ajax ({
                type: 'post',
                url: base_url + 'gh_asistencia/buscarFuncionario',
                data: {'cedula': cedula, 'regreso': regreso},
                cache: false,
                success: function (data) {
                    $('#resultado').html(data);
                }
            });
        }
    });
    
    //Ejecuta Ajax JSON para llenar los datos del grid jquery por primera vez
    var cadena = $('#frmPersonasAsis').serialize();
    var temp = cadena.split('&');
    var temp2 = new Array();
    var data = new Array();
    for (i = 0; i < temp.length; i++) {
        temp2 = temp[i].split('=');
        data.push(temp2[1]);
    }

    jQuery('#listPersonasAsis').jqGrid({
        url: generateGetURL('gh_asistencia/buscarPersonas/', data),
        editurl: base_url + 'gh_asistencia/edit',
        datatype: 'json',
        mtype: 'POST',
        colNames: ['Cedula', 'Apellidos', 'Nombre(s)', 'Correo electrónico', 'Usuario', 'Horario', 'Opc.'],
        colModel: [
            {name: 'nume_docu', index: 'nume_docu', align: 'left', resizable: false, search: false, sortable: false, width: 60},
            {name: 'apellidos', index: 'apellidos', align: 'left', resizable: false, search: false, sortable: false, width: 120},
            {name: 'nombres', index: 'nombres', align: 'left', resizable: false, search: true, sortable: false, width: 120},
            {name: 'email', index: 'email', align: 'left', resizable: false, search: false, sortable: false, width: 80},
            {name: 'usuario', index: 'usuario', align: 'left', resizable: false, search: false, sortable: false, width: 40},
            {name: 'horario', index: 'horario', align: 'left', resizable: false, search: false, sortable: false, width: 40},
            {name: 'opciones', index: 'opciones', align: 'left', resizable: false, search: false, sortable: false, width: 40}
        ],
        autowidth: true,
        height: 'auto',
        multiselect: true,
        pager: '#pagerPersonasAsis',
        pginput: false,
        pgbuttons: true,
        sortorder: 'asc',
        rowNum: 200,
        viewrecords: true,
        width: 'auto',
        onSelectRow: function(id) {
            var s = jQuery('#listPersonasAsis').jqGrid('getGridParam', 'selarrrow');
            var tex = new String(s);
            $('#codigoBarrasSele').val(tex);
        },
        onSelectAll: function() {
            var s = jQuery('#listPersonasAsis').jqGrid('getGridParam', 'selarrrow');
            var tex = new String(s);
            $('#codigoBarrasSele').val(tex);
        },
        loadComplete: function () {
            $('#btnBuscar').button('reset');
            $('tr.jqgrow:odd').addClass('altRow');
        }
    }).navGrid('#pagerPersonasAsis', {search: false, edit: false, add: false, del: false});
    
    $('#btnBuscar').click(function () {
        $('#btnBuscar').button('loading');
        $('#frmPersonasAsis').submit();
        return false;
    });
    
    $('#btnDescargarCB').click(function () {
        var sele = $('#codigoBarrasSele').val();
        console.log(sele);
        if (sele.length > 0 && sele != 'null') {
            $('#formCBSele').attr('action', base_url + 'gh_asistencia/descargarCodigoBarras/'); 
            $('#formCBSele').submit();
        }
        return false;
    });
    
    $('#btnDescargarCB8').click(function () {
        var sele = $('#codigoBarrasSele').val();
        console.log(sele);
        if (sele.length > 0 && sele != 'null') {
            $('#formCBSele').attr('action', base_url + 'gh_asistencia/descargarCodigoBarras8/'); 
            $('#formCBSele').submit();
        }
        return false;
    });
        
    $('#frmPersonasAsis').submit(function (event) {
        var cadena = $('#frmPersonasAsis').serialize();
        if (cadena.length > 0 && cadena != 'null') {
            $.ajax({// verifica si hay sesion
                type: 'POST',
                url: base_url + 'gh_asistencia/validaSesion',
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                cache: false,
                success: function (data) {
                    if (resultadoValido(data)) {
                        data = generarURLserialize('frmPersonasAsis');
                        $('#listPersonasAsis').setGridParam({
                            url: generateGetURL('gh_asistencia/buscarPersonas/', data),
                            datatype: 'json'
                        }).trigger('reloadGrid', [{page: 1}]);
                    } else {
                        bootbox.alert('La sesi\u00f3n termin\u00f3. Vuelva a ingresar por favor.');
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                    //location.reload();
                },
            });
        }
        return false;
    });
});

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}

//*************************************************************************************************
//* Genera una direccion URL para paso de parametros por GET, para el envio de AJAX en JavaScript
//*************************************************************************************************
function generateGetURL(path, data) {
    var i = 0;
    var url = base_url + path;
    for (i = 0; i < data.length; i++) {
        if (isNaN(data[i]) && data[i].indexOf('/') > 0) {
            step1 = data[i].replace('/', '-');
            step2 = step1.replace('/', '-');
            data[i] = step2;
        } else if (isNaN(data[i]) && data[i].indexOf('%2F') > 0) {
            step1 = data[i].replace('%2F', '-');
            step2 = step1.replace('%2F', '-');
            data[i] = step2;
        } else if (data[i] == '') {
            data[i] = '-';
        }
        url = url + encodeURIComponent(data[i]) + '/';
    }
    url = url.substring(0, url.length - 1);
    return decodeURIComponent(url);
}

function generarURLserialize(idForm) {
    var cadena = $('#' + idForm).serialize();
    var temp = cadena.split('&');
    var temp2 = new Array();
    var data = new Array();
    var nombre_campo = '';
    var valor_campo = '';

    for (i = 0; i < temp.length; i++) {
        temp2 = temp[i].split('=');
        if (nombre_campo == temp2[0]) {
            if (valor_campo.length > 0) {
                valor_campo = valor_campo + '|' + temp2[1];
            } else {
                valor_campo = temp2[1];
                temp2 = temp[i - 1].split('=');
                valor_campo = temp2[1] + '|' + valor_campo;
            }
        } else {
            if (valor_campo.length > 0) {
                data.pop();
                data.push(valor_campo);
                nombre_campo = '';
                valor_campo = '';
            }
            data.push(temp2[1]);
        }
        nombre_campo = temp2[0];
    }
    return data;
}
//EOC