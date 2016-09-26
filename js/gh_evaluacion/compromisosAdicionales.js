$(document).ready(function() {

    /**
     * Validacion formulario de inscripcion
     */
    $("#formulario").validate({
        rules: {
            valor: {required: true, number: true, minlength: 3, maxlength: 10}

        },
        errorPlacement: function(error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("name") + "']")
                    .append(error);
        },
        errorElement: "span",
        messages: {
            confirmarPassword: {
                confirmar: "La contrase\u00F1a y su confirmaci\u00f3n, no coinciden"
            },
            confirmarCorreo: {
                confirmar: "El correo principal y su confirmaci\u00f3n, no coinciden"
            }
        },
        submitHandler: function(form) {
            return true;
        }
    });
    $("#btnGuardar").click(function() {
        if ($("#formulario").valid() == true) {
            var form = document.getElementById('formulario');
            form.submit();
        } else
        {
            alert('Campos del formulario con errores. Revise y corrija.');

        }
    });
});


