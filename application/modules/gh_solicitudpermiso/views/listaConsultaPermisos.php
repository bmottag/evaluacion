<!-- Contenido -->	
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">PERMISOS ASIGNADOS</h4>
        </div>
    </div>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <tr class="info">
            <td><p class="text-center"><strong>No. registro</strong></p></td>
            <td><p class="text-center"><strong>Fecha solicitud</strong></p></td>
            <td><p class="text-center"><strong>Funcionario</strong></p></td>
            <td><p class="text-center"><strong>Tipo</strong></p></td>
            <td><p class="text-center"><strong>Motivo</strong></p></td>
            <td><p class="text-center"><strong>Estado actual</strong></p></td>
            <td><p class="text-center"><strong>Info</strong></p></td>			
        </tr>
        <?php
        //var_dump($solicitudes);
        foreach ($solicitudes as $data):
            //$estadoId = $data['idEstado'];
            //$fechaSolicitud = $data['fecha_permiso'];
            $hoy = date('Y-m-d');
            echo "<tr>";
            echo "<td>" . $data['ID_SOLICITUD'] . "</td>";
            echo "<td>" . $data['FECHA_SOLICITUD'] . "</td>";
            echo "<td>" . strtoupper($data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO']) . "</td>";
            echo "<td>" . $data['TIPO'] . "</td>";
            echo "<td>" . $data['MOTIVO'] . "</td>";
            echo "<td class='text-center'><span class='label " . $data["CLASE"] . "'>" . $data['ESTADO'] . "</span></td>";
            echo "<td class='text-center'>";
            if ($idPermiso != 'x') {
                echo '<a class="btn" href="' . site_url() . '/gh_solicitudpermiso/admin_permisos/consulta_permisos/' . $bandera . '/x" title="Regresar"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>';
            } else {
                echo '<a class="btn btn-primary" href="' . site_url() . '/gh_solicitudpermiso/admin_permisos/consulta_permisos/' . $bandera . '/' . $data['ID_SOLICITUD'] . '"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>';
            }
            echo '</td>';
            echo "</tr>";
        endforeach
        ?>
    </table>
    <?php if (isset($links)) { ?>
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <ul class="pagination">
                        <?php echo $links; ?>
                    </ul>
                </nav>		
            </div>
        </div>
    <?php } ?>
    <!-- DETALLE DE LA SOLICITUD -->
    <?php if ($detalle) { ?>
        <div class="well">
            <div class="row">
                <div class="col-md-6">	
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
                <div class="col-md-6">
                    <strong class='text-error'>Jefe encargado de la solicitud :</strong><br />
                    <?php echo $jefe['nom_usuario'] . ' ' . $jefe['ape_usuario']; ?>				
                </div>
            </div>
        </div>
        <?php if ($proceso) { ?>
            <table class="table table-bordered table-striped table-hover table-condensed">
                <tr class="info">
                    <td colspan="8"><h4 align="center">CAMBIOS REALIZADOS DURANTE EL PROCESO DE LA SOLICITUD</h4></td>
                </tr>			
                <tr class="info">
                    <td><p class="text-center"><strong>Fecha proceso</strong></p></td>
                    <td><p class="text-center"><strong>Responsable</strong></p></td>
                    <td><p class="text-center"><strong>Estado</strong></p></td>
                    <td><p class="text-center"><strong>Observaci&oacute;n</strong></p></td>
                </tr>
                <?php
                foreach ($proceso as $lista):
                    echo "<tr>";
                    echo "<td><small>" . $lista['FECHA'] . "</small></td>";
                    echo "<td><small>" . $lista['NOM_USUARIO'] . ' ' . $lista['APE_USUARIO'] . "</small></td>";
                    echo "<td class='text-center'><span class='label " . $lista["CLASE"] . "'>" . $lista['ESTADO'] . "</span></td>";
                    echo "<td><small>" . $lista['OBSERVACIONES'] . "</small></td>";
                    echo "</tr>";
                endforeach;
            }echo '</table>';
        }
        ?>	
</div>