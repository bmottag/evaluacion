function buscarMotivo() {
    var idMotivo = $('select#motivo').val();
    var form = document.getElementById('frmPermisos');
    form.otro.disabled = false;
    form.idsubmotivo.disabled = false;

    if (idMotivo == 7) {
        /* OTRO: Habilitar la opcion otro y inhabilitar la opcion submotivo */
        $("#labelOtro").css("display", "block");

        form.idsubmotivo.value = "";
        $("#labelSubmotivo").css("display", "none");
    } else if (idMotivo == 4) {
        /* CALAMIDAD DOMESTICA: aqui inhabilito opcion otro  */
        $("#labelOtro").css("display", "none");
        form.otro.value = '';

        form.idsubmotivo.value = "";
        $("#labelSubmotivo").css("display", "none");
    } else {
        $("#labelOtro").css("display", "none");
        form.otro.value = '';

        if (idMotivo == 5 || idMotivo == 6) {
            form.idsubmotivo.value = "";
            $("#labelSubmotivo").css("display", "none");
        } else {
            if (idMotivo < 4) {
                $("#labelSubmotivo").css("display", "block");
                $.ajax({
                    type: 'POST',
                    url: './gh_solicitudpermiso/list_dropdown',
                    data: 'idMotivo=' + idMotivo,
                    success: function (resp) {
                        if (resp != "vacio") {
                            //Activar y Rellenar el select
                            $('select#idsubmotivo').attr('disabled', false).html(resp); //Con el método ".html()" incluimos el código html devuelto por AJAX en la lista
                        }
                    }
                });
            }
        }
    }
};