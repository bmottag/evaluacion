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

    var rangoFechas = $('#fecha_ini, #fecha_fin').datepicker({
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
            rangoFechas.not(this).datepicker('option', option, date);
        }
    });
    
     $('#deslizarTablaInfo').click(function () {
        $('#tablaInfo').slideToggle('slow', function () {
            if ($(this).attr('alt') == 'Ocultar') {
                $(this).attr({
                    src: base_url + 'images/flechaabajo.png',
                    title: 'Mostrar',
                    alt: 'Mostrar'
                });
            } else if ($(this).attr('alt') == 'Mostrar') {
                $(this).attr({
                    src: base_url + 'images/flechaarriba.png',
                    title: 'Ocultar',
                    alt: 'Ocultar'
                });
            }
        });
    });
    
    //Ejecuta Ajax JSON para llenar los datos del grid jquery por primera vez
    var data = serializarForm('frmAsistencia');
    
    var lastsel = '';
    jQuery('#listAsistencias').jqGrid({
        url: generateGetURL('gh_asistencia/buscarAsistencias/', data),
        editurl: base_url + 'gh_asistencia/editarListAsistencias/',
        datatype: 'json',
        mtype: 'POST',
        colNames: ['Cedula', 'Apellidos', 'Nombre(s)', 'Fecha', 'Horario','Hora entrada', 'Hora Salida', 'RE', 'RS', 'Permisos', 'TR'],
        colModel: [
            {name: 'nume_docu', index: 'nume_docu', align: 'left', resizable: false, search: false, sortable: false, width: 60},
            {name: 'apellidos', index: 'apellidos', align: 'left', resizable: false, search: false, sortable: false, width: 120},
            {name: 'nombres', index: 'nombres', align: 'left', resizable: false, search: true, sortable: false, width: 120},
            {name: 'fecha', index: 'fecha', align: 'left', resizable: false, search: false, sortable: false, width: 60},
            {name: 'horario', index: 'horario', align: 'left', resizable: false, search: false, sortable: false, width: 60},
            {name: 'HE', index: 'HE', align: 'left', editable: true, resizable: false, search: false, sortable: false, width: 60},
            {name: 'HS', index: 'HS', align: 'left', editable: true, resizable: false, search: false, sortable: false, width: 60},
            {name: 'RE', index: 'RE', align: 'right', resizable: false, search: false, sortable: false, width: 40},
            {name: 'RS', index: 'RS', align: 'right', resizable: false, search: false, sortable: false, width: 40},
            {name: 'permiso', index: 'permiso', align: 'right', resizable: false, search: false, sortable: false, width: 40},
            {name: 'TR', index: 'TR', align: 'right', resizable: false, search: false, sortable: false, width: 40}
        ],
        autowidth: true,
        grouping: true,
        groupingView: {
            groupField: ['fecha'],
            groupColumnShow: [false]
        },
        height: 'auto',
        multiselect: false,
        pager: '#pagerAsistencias',
        pginput: false,
        pgbuttons: true,
        sortorder: 'asc',
        rowNum: 100,
        viewrecords: true,
        width: 'auto',
        loadComplete: function () {
            $('#btnBuscar').button('reset');
            $('tr.jqgrow:odd').addClass('altRow');
        },
        onSelectRow: function (id) {
            if (id && id !== lastsel) {
                $('#listAsistencias').jqGrid('restoreRow', lastsel);
                $('#listAsistencias').jqGrid('editRow', id, true);
                console.log(id);
                if($('#'+id+'_HE').val().length == 0) {
                    $('#'+id+'_HE').timepicker($.timepicker.regional['es']);
                } else {
                    $('#'+id+'_HE').attr('readonly', true);
                }
                if($('#'+id+'_HS').val().length == 0) {
                    $('#'+id+'_HS').timepicker($.timepicker.regional['es']);
                } else {
                    $('#'+id+'_HS').attr('readonly', true);
                }
                //lastsel = id;
            }
        }
    }).navGrid('#pagerAsistencias', {search: false, edit: false, add: false, del: false});
    
    $('#btnBuscar').click(function () {
        $('#btnBuscar').button('loading');
        $('#frmAsistencia').submit();
        return false;
    });
    
    $('#btnExcel').click(function () {
        var arreglo = $('#frmAsistencia').serializeArray();
        var s = '';
        var datos = new Object();
        for (i = 0; i < arreglo.length; i++) {
            s = arreglo[i].name;
            datos[s] = arreglo[i].value;
        }
        if (arreglo.length > 0) {
            $.ajax({// verifica si hay sesion
                type: 'POST',
                url: base_url + 'exportar_excel/asistencia',
                data: datos,
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                cache: false,
                error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.alert('Error al generar el archivo Excel.');
                },
                success: function (data) {
                    if (data.length > 0) {
                        if (validaURL(data)) {
                            window.open(data);
                        } else {
                            $('#msgError').html(data);
                            $('#divMsgAlert').show();
                        }
                    } else {

                    }
                }
            });
        }
        return false;
    });
    
    $('#frmAsistencia').submit(function (event) {
        var cadena = $('#frmAsistencia').serialize();
        if (cadena.length > 0 && cadena != 'null') {
            $.ajax({// verifica si hay sesion
                type: 'POST',
                url: base_url + 'gh_asistencia/validaSesion',
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                cache: false,
                success: function (data) {
                    if (resultadoValido(data)) {
                        data = generarURLserialize('frmAsistencia');
                        for (var i = 0; i < data.length; i++) {
                            if (isNaN(data[i]) && data[i].indexOf('%2F') > 0) {
                                data[i] = formatearFecha(data[i]);
                            }
                        }
                        $('#listAsistencias').setGridParam({
                            url: generateGetURL('gh_asistencia/buscarAsistencias/', data),
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
                    /*if (jqXHR.status) {
                        alert(jqXHR.status);
                        //mostrarEstadoError(jqXHR.status, divDestino);
                    }*/
                }
            });
        }
        return false;
    });
    
    $.fn.mostrarModal = function (idDiv, titulo, cuerpo, pie) {
        $('#' + idDiv).html('');
        var html = '<div class="modal-dialog"><div class="modal-content">';
        if (titulo.length > 0) {
            if (pie == 'default') {
                titulo = 'Titulo';
            }
            html += '<div class="modal-header">\n\
                    <button type="button" class="close" data-dismiss="modal">&times;</button>\n\
                        <h4 class="modal-title" id="modal-title">' + titulo + '</h4></div>';
        }
        if (cuerpo.length > 0) {
            html += '<div class="modal-body" id="modal-body">' + cuerpo + '</div>';
        }
        if (pie.length > 0) {
            if (pie == 'default') {
                pie = '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>';
            }
            html += '<div class="modal-footer" id="modal-footer">' + pie + '</div>';
        }
        for (var i = 0; i < arguments.length; i++) {
            //console.log(arguments[i]);
        }
        html += '</div></div>';
        $('#' + idDiv).html(html);
        $('#' + idDiv).modal({
            keyboard: false,
            show: true
        });
        return false;
    };
    
    $.fn.fnMostrarInfoPermiso = function (idPermiso) {
        if (idPermiso.length > 0 && idPermiso != 'null') {
            $.ajax({// verifica si hay sesion
                type: 'POST',
                url: base_url + 'gh_asistencia/validaSesion',
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                cache: false,
                success: function (data) {
                    if (resultadoValido(data)) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'gh_solicitudpermiso/consultarPermiso',
                            data: {'idPermiso': idPermiso},
                            dataType: 'html',
                            contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                            cache: false,
                            success: function (data) {
                                // Hay que revisar por que al principio hay un espacio
                                if (data.substr(1, 5) == 'exito') {
                                    $('#myModal').mostrarModal('myModal', 'Información solicitud de permiso', data.substr(6), '');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                            }
                        });
                    } else {
                        bootbox.alert('La sesi\u00f3n termin\u00f3. Vuelva a ingresar por favor.');
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
                    //location.reload();
                }
            });
        }
        return false;
    };
});

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

function mostrarInfoPermiso(idBtn, idPermiso) {
    $('#' + idBtn).fnMostrarInfoPermiso(idPermiso);
}
//EOC