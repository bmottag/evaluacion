<script>
    /**
     * Validar formulario de aprobacion
     */
    function validarFrmEstado() {
        var form = document.getElementById('frmEstado');
        var ok = 1;
        document.getElementById('bloqueAlerta').style.display = "none";

        if (form.estado.value == 2 && form.observaciones.value == '') {
            document.getElementById('bloqueAlerta').style.display = "block";
            form.observaciones.focus();
            ok = 0;
        }
        if (ok == 1) {
            form.submit();
        }
    }
</script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">APROBAR PERMISOS - LISTA SOCITUDES DE PERMISOS NUEVAS</h4>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover table-condensed">
        <tr class="info">
            <td class="text-center" style="font-weight: bold;">No. registro</td>
            <td class="text-center" style="font-weight: bold;">Fecha solicitud</td>
            <td class="text-center" style="font-weight: bold;">Funcionario</td>
            <td class="text-center" style="font-weight: bold;">Tipo</td>
            <td class="text-center" style="font-weight: bold;">Motivo</td>
            <td class="text-center" style="font-weight: bold;">Fecha permiso</td>
            <td class="text-center" style="font-weight: bold;">Estado actual</td>
            <td class="text-center" style="font-weight: bold;">Info</td>
        </tr>
        <?php
        foreach ($solicitudes as $data):
            echo "<tr>";
            echo "<td>" . $data['ID_SOLICITUD'] . "</td>";
            echo "<td>" . completar_fecha($data['FECHA_SOLICITUD']) . "</td>";
            echo "<td>" . strtoupper($data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO']) . "</td>";
            echo "<td>" . $data['TIPO'] . "</td>";
            echo "<td>" . $data['MOTIVO'] . "</td>";
            $txtFechaPermiso = '';
            switch ($data['ID_TIPO']) {
                case 1:
                    $txtFechaPermiso = completar_fecha($data['FECHA_INI']) . ' - ' . $data['HORA_INICIO'] . '-' . $data['HORA_FIN'];
                    break;
                case 2:
                    $txtFechaPermiso = completar_fecha($data['FECHA_INI']);
                    break;
                case 3:
                case 4:
                    $txtFechaPermiso = completar_fecha($data['FECHA_INI']) . ' - ' . completar_fecha($data['FECHA_FIN']);
                    break;
            }
            echo "<td>" . $txtFechaPermiso . "</td>";
            echo "<td class='text-center'><span class='label " . $data["CLASE"] . "'>" . $data['ESTADO'] . "</span></td>";
            echo "<td class='text-center'>";
            if ($idPermiso != 'x') {
                echo '<a class="btn" href="x" title="Regresar"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>';
            } else {
                echo "<a class='btn btn-primary' href='" . $data['ID_SOLICITUD'] . "'><span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span></a>";
            }
            echo "</td>";
            echo "</tr>";
        endforeach
        ?>
    </table>
    <!-- DETALLE DE LA SOLICITUD -->
<?php if ($detalle) { ?>
        <div class="col-md-6">	
            <div class="well">
                <div class="row">
                    <div class="col-md-12">
                        <legend class="text-error">Detalle de la solcitiud</legend>
                        <?php
                        $tipo_solicitud = $solicitudes[0]['ID_TIPO'];
                        $fecha_permiso = $solicitudes[0]['FECHA_PERMISO'] == '0000-00-00' ? '' : $solicitudes[0]['FECHA_PERMISO'];
                        $hora_inicio = $solicitudes[0]['HORA_INICIO'];
                        $hora_fin = $solicitudes[0]['HORA_FIN'];
                        $fecha_ini = $solicitudes[0]['FECHA_INI'] == '0000-00-00' ? '' : $solicitudes[0]['FECHA_INI'];
                        $fecha_fin = $solicitudes[0]['FECHA_FIN'] == '0000-00-00' ? '' : $solicitudes[0]['FECHA_FIN'];
                        $estado_proceso = $solicitudes[0]['ESTADO_PROCESO'];
                        $director = $solicitudes[0]['FK_ID_DIRECTOR'];
                        $tiempoCompensar = $solicitudes[0]['TIEMPO_COMPENSAR'];
                        $motivo = $solicitudes[0]['MOTIVO'];
                        $submotivo = $solicitudes[0]['SUBMOTIVO'];
                        $otro = $solicitudes[0]['OTRO_MOTIVO'];
                        $idEstado = $solicitudes[0]['FK_ID_ESTADO'];
                        $descripcion = $solicitudes[0]['DESCRIPCION'];

                        switch ($tipo_solicitud) {
                            case 1:
                                echo "<strong class='text-error'>Fecha permiso : </strong>" . $fecha_permiso;
                                echo "<br><strong class='text-error'>Hora inicio : </strong>" . $hora_inicio;
                                echo "<br><strong class='text-error'>Hora fin : </strong>" . $hora_fin;
                                break;
                            case 2:
                                echo "<strong class='text-error'>Fechas permiso : </strong>" . $fecha_ini;
                                break;
                            case 3:
                                echo "<strong class='text-error'>Fecha inicial : </strong>" . $fecha_ini;
                                echo "<br><strong class='text-error'>Fecha final : </strong>" . $fecha_fin;
                                break;
                            case 4:
                                echo "<strong class='text-error'>Fecha inicial : </strong>" . $fecha_ini;
                                echo "<br><strong class='text-error'>Fecha final : </strong>" . $fecha_fin;
                                break;
                            case 5:
                                if ($documentos) {
                                    echo "<p ><strong class='text-error'>Documentos anexados : </strong></p>";
                                    foreach ($documentos as $data):
                                        $url = base_url() . 'files/certificados/' . $data['NOMBRE_DOCUMENTO'];
                                        echo "<p ><a href='" . $url . "' target='_blank'><img src='" . base_url("images/pdf.png") . "' width='17' height='18' border='0' title='Ver detalle' /> " . $data['NOMBRE_DOCUMENTO'] . "</a></p>";
                                    endforeach;
                                } else
                                    echo "<p ><strong class='text-error'> -- No hay documentos -- </strong></p>";
                                echo "<p ><strong class='text-error'>Tiempo y forma de compensar : </strong><br>";
                                echo $tiempoCompensar . "</p>";
                                break;
                        }
                        echo "<br><strong class='text-error'>Motivo : </strong>";
                        if ($submotivo) {
                            $motivo.= " - " . $submotivo;
                        }
                        echo $motivo;
                        if ($otro) {
                            echo "<br><strong class='text-error'>Cual : </strong>" . $otro;
                        }
                        if ($descripcion) {
                            echo "<br><strong class='text-error'>Info. adicional : </strong>" . $descripcion;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <div class="row">
                    <div class="col-md-12">			
                        <form  name="frmEstado" id="frmEstado" role="form" method="post" action="<?php echo site_url("gh_solicitudpermiso/admin_permisos/respuesta"); ?>">
                            <input type="hidden" name="idSolicitud" value="<?php echo $solicitudes[0]['ID_SOLICITUD']; ?>" />
                            <input type="hidden" name="tipoSolicitud" value="<?php echo $tipo_solicitud; ?>" />
                            <input type="hidden" name="estado_proceso" value="<?php echo $estado_proceso; ?>" />
                            <input type="hidden" name="director" value="<?php echo $director; ?>" />

                            <legend class="text-error">Indicar su respuesta</legend>

                            <label class="control-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones"  rows="1" <?php if ($idEstado != 1 && $idEstado != 4) { ?> disabled="disabled" <?php } ?>></textarea>					
                            <br>
                            <?php if ($idEstado == 1 || $idEstado == 4) { ?>
                                <input name="hfActualizarEstado" type="hidden" id="hfActualizarEstado" value="SI" />
                                <?php if ($estado_proceso == 1) { ?>
                                    <input type="button" name="Button" value="Aprobar" onClick="document.forms[0].estado.value = 3, validarFrmEstado()" class="btn btn-primary"/>
                                <?php } else { ?>
                                    <input type="button" name="Button" value="Avalar" onClick="document.forms[0].estado.value = 4, validarFrmEstado()" class="btn btn-primary"/>
                                <?php } ?>
                                <input type="button" name="Button" value="Rechazar" onClick="document.forms[0].estado.value = 2, validarFrmEstado()" class="btn btn-danger"/>
                                <input type="hidden" name="estado" id="estado" value="" />
                                <?php
                            } else {
                                echo '<input class="btn btn-primary" type="button" value="Aprobar" disabled> ';
                                echo '<input class="btn" type="submit" value="Rechazar" disabled>';
                            }
                            ?>
                        </form>	
                        <br>
                        <div class="row" align="center" id="bloqueAlerta" style="display: none;">
                            <div class="alert alert-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                                Indicar observaciones
                            </div>
                        </div>					
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
</div>