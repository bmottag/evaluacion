$(document).ready(function () {    
    $('#btnDescargar').click(function () {
        $('#divMsgAlert').hide();
        $('#divSuccess').hide();
        var cadena = $('#frmUsuario').serialize();
        if (cadena.length > 0 && cadena != 'null') {
            $.ajax({// verifica si hay sesion
                type: 'POST',
                url: base_url + 'gh_asistencia/validaSesion',
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
                cache: false,
                success: function (data) {
                    if (resultadoValido(data)) {
                        var idPers = $('#txtIdPers').val();
                        var codigoBarras = $('#txtCodigoBarras').val();
                        $.ajax({// verifica si hay sesion
                            type: 'POST',
                            url: base_url + 'gh_asistencia/descargarCodigoBarras/',
                            data: {'opc': 'c','idPers': idPers, 'codigoBarras': codigoBarras},
                            cache: false,
                            success: function (data) {
                                data = data.replace('ï»¿ï»¿ ','');
                                data = data.replace('ï»¿','');
                                if(data.substr(0,5) == 'exito' || data.substr(0,5) == 'ï»¿exito') {
                                    
                                } else {
                                    $('#msgError').html(data);
                                    $('#divMsgAlert').show();
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $('#msgError').html('El c&oacute;digo de barras no se pudo guardar correctamente.');
                                $('#divMsgAlert').show();
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
                    /*if (jqXHR.status) {
                        alert(jqXHR.status);
                        //mostrarEstadoError(jqXHR.status, divDestino);
                    }*/
                }
            });
        }
        return false;
        return false;
    });
    
    $('#btnGuardar').click(function () {
        $('#divMsgAlert').hide();
        $('#divSuccess').hide();
        $('#frmUsuario').submit();
        return false;
    });
    
    $('#btnActualizar').click(function () {
        $('#divMsgAlert').hide();
        $('#divSuccess').hide();
        $('#frmUsuario').submit();
        return false;
    });
    
    $('#btnRegresar').click(function () {
        //history.back(1);
        window.location.href = base_url + 'gh_asistencia/editarCodigoBarras/x';
    });
});

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
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