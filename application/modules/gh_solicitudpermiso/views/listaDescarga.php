<!-- Contenido -->	
<div class="container">
    <div class="page-header">
        <h2>LISTA SOLICITUDES DE PERMISOS REALIZADAS</h2>
    </div>
    <table class="table table-striped table-condensed">
        <tr class="info">
            <td colspan="4">
                <?php
                echo '<table class="table table-bordered table-striped table-hover table-condensed">	
                        <tr class="info">
                                <td><p class="text-center"><strong>Filtro</strong></p></td>
                                <td><p class="text-center"><strong>Descripci&oacute;n</strong></p></td>
                        </tr>';
                echo "<tr><td>Periodo</td>";
                $desde = $this->input->post('fecha_ini');
                $hasta = $this->input->post('fecha_fin');
                echo "<td>" . $desde . ' - ' . $hasta . "</td></tr>";
                if ($tipo != 'x') {
                    echo "<tr><td>Tipo</td>";
                    echo "<td>" . $tipo['TIPO'] . "</td></tr>";
                }
                if ($motivo != 'x') {
                    echo "<tr><td>Motivo</td>";
                    echo "<td>" . $motivo['MOTIVO'] . "</td></tr>";
                }
                if ($idDependencia = $this->input->post('dependencia')) {
                    echo "<tr><td>C&oacute;digo Dependencia</td>";
                    echo "<td>" . $idDependencia . "</td></tr>";
                }
                echo "</tr>";
                echo '</table>';
                ?>				
                <strong>No. de registros: </strong>				
                <?php echo $numRegistros; ?>
            </td>
            <td colspan="5">
                <?php
                if ($numRegistrosTipo) {
                    echo '<table class="table table-bordered table-striped table-hover table-condensed">	
                            <tr class="info">
                                    <td ><p class="text-center"><strong>Tipo soliciutd</strong></p></td>
                                    <td ><p class="text-center"><strong>No. de solicitudes</strong></p></td>
                            </tr>';
                    foreach ($numRegistrosTipo as $data):
                        echo "<tr>";
                        echo "<td>" . $data['TIPO'] . "</td>";
                        echo "<td>" . $data['CONTEO'] . "</td>";
                        echo "</tr>";
                    endforeach;
                    echo '</table>';
                }
                ?>			
            </td>			
            <td colspan="5">
                <?php
                if ($numRegistrosMotivo) {
                    echo '<table class="table table-bordered table-striped table-hover table-condensed">	
                            <tr class="info">
                                    <td ><p class="text-center"><strong>Motivo soliciutd</strong></p></td>
                                    <td ><p class="text-center"><strong>No. de solicitudes</strong></p></td>
                            </tr>';
                    foreach ($numRegistrosMotivo as $data):
                        echo "<tr>";
                        echo "<td>" . $data['MOTIVO'] . "</td>";
                        echo "<td>" . $data['CONTEO'] . "</td>";
                        echo "</tr>";
                    endforeach;
                    echo '</table>';
                }
                ?>			
            </td>			
        </tr>
    </table><br><br>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <tr class="info">
            <td><p class="text-center"><strong>No. registro</strong></p></td>
            <td><p class="text-center"><strong>Fecha solicitud</strong></p></td>
            <td><p class="text-center"><strong>No. Docu</strong></p></td>
            <td><p class="text-center"><strong>Funcionario</strong></p></td>
            <td><p class="text-center"><strong>Dependencia</strong></p></td>
            <td><p class="text-center"><strong>Tipo</strong></p></td>
            <td><p class="text-center"><strong>Motivo</strong></p></td>
            <td><p class="text-center"><strong>Submotivo</strong></p></td>
            <td><p class="text-center"><strong>Fecha del permiso</strong></p></td>
            <td><p class="text-center"><strong>Hora inicio</strong></p></td>			
            <td><p class="text-center"><strong>Hora final</strong></p></td>
            <td><p class="text-center"><strong>Fecha inicial</strong></p></td>
            <td><p class="text-center"><strong>Fecha final</strong></p></td>			
            <td><p class="text-center"><strong>Descripci&oacute;n</strong></p></td>			
            <td><p class="text-center"><strong>Estado</strong></p></td>
        </tr>
        <?php
        /* echo '<pre>';
          print_r($solicitudes);
          echo '</pre>'; */
        foreach ($solicitudes as $data):
            echo "<tr>";
            echo "<td>" . $data['ID_SOLICITUD'] . "</td>";
            echo "<td>" . $data['FECHA_SOLICITUD'] . "</td>";
            echo "<td>" . $data['NUMERO_IDENTIFICACION'] . "</td>";
            echo "<td>" . strtoupper($data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO']) . "</td>";
            echo "<td>" . $data['DEPENDENCIA'] . "</td>";
            echo "<td>" . $data['TIPO'] . "</td>";
            echo "<td>" . $data['MOTIVO'] . "</td>";
            echo "<td>" . $data['SUBMOTIVO'] . "</td>";
            echo "<td>" . $data['FECHA_PERMISO'] . "</td>";
            echo "<td>" . $data['HORA_INICIO'] . "</td>";
            echo "<td>" . $data['HORA_FIN'] . "</td>";
            echo "<td>" . $data['FECHA_INI'] . "</td>";
            echo "<td>" . $data['FECHA_FIN'] . "</td>";
            echo "<td>" . $data['DESCRIPCION'] . "</td>";
            echo "<td>" . $data['ESTADO'] . "</td>";
            echo "</tr>";
        endforeach
        ?>
    </table>
</div>