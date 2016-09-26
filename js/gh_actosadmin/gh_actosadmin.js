/**********************************************************************************
 * Funciones JavaScript para modulo actos administrativos de gestión humana
 * @author hhchavezv
 * @since  20115jul22
 **********************************************************************************/

$(function () {

    /**
     * Funciones JavaScript para crear un acto administrativo
     * @author hhchavezv
     * @since  2015jul22
     */


    $('#formActAdmin').trigger("reset");//Limpiar la forma al cargar, ya que luego de guardar se carga un form blanco para volver a diligenciar
    $('#fecha_solicitud, #fecha_orfeo, #fecha_asignacion').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-1y',
        maxDate: 'now'
    });


    $('#fecha_rta').datepicker({
        dateFormat: 'dd/mm/yy',
        //startDate:$("#hd_fec").val(),
        minDate: new Date($("#hd_fec").val()),
        maxDate: 'now'
    });

    $('#fecha_solicitud, #fecha_orfeo, #fecha_asignacion, #fecha_rta').prop('readonly', true);
    /*$('#fecha_solicitud, #fecha_orfeo, #fecha_asignacion').datetimepicker({
     format: 'DD/MM/YYYY'
     //startDate: '-3d'
     //maxDate : +1d
     
     //setMaxDate:'0'
     
     });*/
    //$('#fecha_solicitud, #fecha_orfeo, #fecha_asignacion').datetimepicker('26/07/2015', minDate);	
    /*$('#fecha_solicitud').datetimepicker({
     maxDate:'26/07/2015'
     });*/

    /*.on('dp.change', function (selected) {
     $('#fecha_solicitud, #fecha_orfeo, #fecha_asignacion').data("DateTimePicker").setMinDate('26/07/2015');
     });
     */
//	$.datepicker.setDefaults( $.datepicker.regional["it"] );				

    $("#sel_firma").cargarCombo("sel_acto_admin", base_url + "gh_actosadmin/getTiposActosAdmin");

    $("#formActAdmin").validate({
        //Reglas de Validacion
        rules: {
            fecha_solicitud: {dateFormatValid: true, expresion: '$("#fecha_solicitud").val() =="" && $("#fecha_orfeo").val() =="" '
            },
            fecha_orfeo: {dateFormatValid: true, expresion: '$("#fecha_solicitud").val() =="" && $("#fecha_orfeo").val() =="" '
            },
            sel_firma: {comboBox: '-'
            },
            sel_acto_admin: {comboBox: '-'
            },
            sel_abogado: {comboBox: '-'
            },
            fecha_asignacion: {required: true, dateFormatValid: true
            },
            observaciones: {maxlength: 970
            }
        },
        //Mensajes de validacion
        messages: {
            fecha_solicitud: {expresion: "Diligencie Fecha Acto Admin o Fecha Radicado Orfeo", dateFormatValid: "Fecha debe tener formato dd/mm/yyyy"
            },
            fecha_orfeo: {expresion: "Diligencie Fecha Acto Admin o Fecha Radicado Orfeo", dateFormatValid: "Fecha debe tener formato dd/mm/yyyy"
            },
            sel_firma: {comboBox: 'Seleccione una opci&oacute;n'
            },
            sel_acto_admin: {comboBox: 'Seleccione una opci&oacute;n'
            },
            sel_abogado: {comboBox: 'Seleccione una opci&oacute;n'
            },
            fecha_asignacion: {required: "Seleccione una fecha", dateFormatValid: "Fecha debe tener formato dd/mm/yyyy"
            },
            observaciones: {maxlength: "Por favor escriba m&aacute;ximo 970 caracteres."
            }

        },
        //Mensajes de error
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");

            //	$(element).focus();
        },
        submitHandler: function (form) {
            return true;

        }
    });
    $("#btngGuardarActAdmin").click(function () {

        if ($("#formActAdmin").valid() == true) {


            if (window.confirm('Haga clic en Aceptar para guardar'))
            {
                //Activa icono guardando
                $('#btngGuardarActAdmin').attr('disabled', '-1');
                $("#div_guardado").css("display", "none");
                $("#div_error").css("display", "none");
                $("#div_cargando").css("display", "inline");

                $.ajax({
                    type: "POST",
                    url: base_url + "gh_actosadmin/guardaActoAdmin",
                    data: $("#formActAdmin").serialize(),
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    cache: false,
                    success: function (data) {
                        //data=utf8_decode(data);
                        // bootbox.alert(data);
                        //if(data ==="-ok-")
                        // bootbox.alert(data.length);

                        if (resultadoValido(data))
                        {

                            //Oculta icono guardando
                            $("#div_cargando").css("display", "none");
                            $("#div_guardado").css("display", "inline");

                             bootbox.alert('Acto administrativo guardado correctamente.');
                            location.reload();

                            $('#btngGuardarActAdmin').removeAttr('disabled');

                        } else
                        {
                             bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btngGuardarActAdmin').removeAttr('disabled');
                        }
                    },
                    error: function (result) {
                         bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                        $("#div_cargando").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $('#btngGuardarActAdmin').removeAttr('disabled');
                    }


                });
            }

        }//if			
    });

    //  Funciones para validar tramites

    $("#formTramiteActo").validate({
        ignore: [], // Permite validar campos ocultos type=hidden
        //Reglas de Validacion
        rules: {
            fecha_rta: {required: true//, dateFormatValid: true, 
            },
            sel_accion: {comboBox: '-'
            },
            hd_act: {required: true // oculto
            },
            hd_tip: {required: true // oculto
            },
            obs_tramite: {maxlength: 970
            }

        },
        //Mensajes de validacion
        messages: {
            fecha_rta: {required: "Seleccione una fecha"  //, dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
            },
            sel_accion: {comboBox: 'Seleccione una opci&oacute;n'
            },
            hd_act: {required: "<br>Error: Faltan datos. Vuelva a la p&aacute;gina anterior."
            },
            hd_tip: {required: "<br>Error: Faltan otros datos. Vuelva a la p&aacute;gina anterior."
            },
            obs_tramite: {maxlength: "Por favor escriba m&aacute;ximo 970 caracteres."
            }

        },
        //Mensajes de error
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");

            //	$(element).focus();
        },
        submitHandler: function (form) {
            return true;

        }
    });

    $("#btnGuardarTramiteActo").click(function () {

        if ($("#formTramiteActo").valid() == true) {


            if (window.confirm('Haga clic en Aceptar para guardar'))
            {
                //Activa icono guardando
                $('#btnGuardarTramiteActo').attr('disabled', '-1');
                $("#div_guardado").css("display", "none");
                $("#div_error").css("display", "none");
                $("#div_cargando").css("display", "inline");

                $.ajax({
                    type: "POST",
                    url: base_url + "gh_actosadmin/guardaTramiteActoAdmin",
                    data: $("#formTramiteActo").serialize(),
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    cache: false,
                    success: function (data) {
                        if (resultadoValido(data))
                        {
                            //Oculta icono guardando
                            $("#div_cargando").css("display", "none");
                            $("#div_guardado").css("display", "inline");

                             bootbox.alert('Tr\u00e1mite guardado correctamente.');
                            var url = base_url + "gh_actosadmin/" + $("#hd_interf").val();
                            $(location).attr("href", url);

                            $('#btnGuardarTramiteActo').removeAttr('disabled');

                        } else
                        {
                             bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btnGuardarTramiteActo').removeAttr('disabled');
                        }
                    },
                    error: function (result) {
                         bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                        $("#div_cargando").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $('#btnGuardarTramiteActo').removeAttr('disabled');
                    }


                });
            }

        }//if			
    });

});//EOC



function utf8_decode(str_data) {
    //  discuss at: http://phpjs.org/functions/utf8_decode/
    // original by: Webtoolkit.info (http://www.webtoolkit.info/)
    //    input by: Aman Gupta
    //    input by: Brett Zamir (http://brett-zamir.me)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Norman "zEh" Fuchs
    // bugfixed by: hitwork
    // bugfixed by: Onno Marsman
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: kirilloid
    //   example 1: utf8_decode('Kevin van Zonneveld');
    //   returns 1: 'Kevin van Zonneveld'

    var tmp_arr = [],
            i = 0,
            ac = 0,
            c1 = 0,
            c2 = 0,
            c3 = 0,
            c4 = 0;

    str_data += '';

    while (i < str_data.length) {
        c1 = str_data.charCodeAt(i);
        if (c1 <= 191) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if (c1 <= 223) {
            c2 = str_data.charCodeAt(i + 1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else if (c1 <= 239) {
            // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        } else {
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            c4 = str_data.charCodeAt(i + 3);
            c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
            c1 -= 0x10000;
            tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
            tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
            i += 4;
        }
    }
    return tmp_arr.join('');
}

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}