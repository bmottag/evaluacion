$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('#txtIdentificacion').bloquearTexto().maxlength(12);
    $('#txtTelefono').bloquearTexto().maxlength(10);
    $('#txtExtension').bloquearTexto().maxlength(6);
    $('#txtEmail').soloTexto().maxlength(15);
    
    $.fn.mostrarModal = function (idDiv, titulo, cuerpo, pie) {
        $('#' + idDiv).html('');
        var html = '<div class="modal-dialog" style="width: 640px;"><div class="modal-content">';
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
    
    $('#formulario').validate({
        //Reglas de Validacion
        rules: {
            txtIdentificacion: {required: true},
            txtTelefono: {required: true},
            txtExtension: {required: true},
            txtEmail: {required: true},
            cmbDespacho: {required: true},
            dependencia: {required: true}
        },
        //Mensajes de validacion
        messages: {
            txtIdentificacion: {required: 'Campo requerido'},
            txtTelefono: {required: 'Campo requerido'},
            txtExtension: {required: 'Campo requerido'},
            txtEmail: {required: 'Campo requerido'},
            cmbDespacho: {required: 'Seleccione el despacho'},
            dependencia: {required: 'Seleccione la dependencia'}
        },
        //Mensajes de error
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', '#FF0000');
            //	$(element).focus();
        },
        submitHandler: function (form) {
            return true;
        }
    });

    $('#btnGuardar').click(function () {
        if ($('#formulario').valid() == true) {
            var form = document.getElementById('formulario');
            form.submit();
        } else {
            bootbox.alert('Campos del formulario con errores. Revise y corrija.');
        }
    });

    $('#btnCrearCancelar, #btnCancelarActualizar').click(function () {
        $(location).attr('href', base_url);
    });
    
    $('#infografiaCRM').click(function () {
        var html = '<img src="' + base_url + 'images/infografia_ingresar_CRM.jpg" id="infografia2CRM" height="875" width="600" />'
        $('#myModal').mostrarModal('myModal', '  ', html, '');
    });
});