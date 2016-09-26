/**
 * Lista de dependencias filtrados por despacho
 * @author bmottag
 * @since  2016-04-18
 */

$(document).ready(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();
    
    $('#cmbDespacho').change(function () {
        $('#cmbDespacho option:selected').each(function () {
            var despacho = $('#cmbDespacho').val();
            if (despacho > 0 || despacho != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'gh_directorio/listaDesplegable',
                    data: {'identificador': despacho},
                    cache: false,
                    success: function (data)
                    {
                        $('#dependencia').html(data);
                    }
                });
            } else {
                var data = '';
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
                        type: 'POST',
                        url: base_url + 'gh_directorio/listaGrupo',
                        data: {'identificador': dependencia},
                        cache: false,
                        success: function(data) {
                            $('#grupo').html(data);
                        }
                    });
                } else {
                    var data = '';
                    $('#grupo').html(data);
                }
            });
        }
    });
});