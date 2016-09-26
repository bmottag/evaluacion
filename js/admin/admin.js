/**********************************************************************************
 * Funciones javascript para modulo admistrador
 * @author hhchavezv
 * @since  20115-07-15
 **********************************************************************************/
$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    /**
     * Funciones JavaScript para interfaz de permisos
     * @author hhchavezv
     * @since  20115jul15
     */
    $("#form_permisos").validate({
        //Reglas de Validacion
        rules: {
            'modulo[]': {required: true
            }
        },
        //Mensajes de validacion
        messages: {
            'modulo[]': {required: "<br>Elija una o varias opciones"
            },
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
    
    $("#btnGuardarPermisos").click(function () {
        if ($("#form_permisos").valid() == true) {
            if (window.confirm('Haga clic en Aceptar para guardar.')) {
                //Activa icono guardando
                $('#btnGuardarPermisos').attr('disabled', '-1');
                $("#div_guardado").css("display", "none");
                $("#div_error").css("display", "none");
                $("#div_cargando").css("display", "inline");

                $.ajax({
                    type: "POST",
                    url: base_url + "admin/permisosGuardar",
                    //url: base_url + "admin/permisos/2628",					
                    data: $("#form_permisos").serialize(),
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    cache: false,
                    success: function (data) {
                        if (data === "-ok-") {
                            //Oculta icono guardando
                            $("#div_cargando").css("display", "none");
                            $("#div_guardado").css("display", "inline");
                            $('#btnGuardarPermisos').removeAttr('disabled');

                        } else {
                             bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btnGuardarPermisos').removeAttr('disabled');
                        }
                    },
                    error: function (result) {
                         bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                        $("#div_cargando").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $('#btnGuardarPermisos').removeAttr('disabled');
                    }
                });
            }
        }//if
    });
});//EOC